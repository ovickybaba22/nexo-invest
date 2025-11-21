<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DepositController extends Controller
{
    /**
     * Handle a new deposit request from the user.
     * This creates a local Deposit record and a NOWPayments invoice,
     * then redirects the user to the NOWPayments checkout page.
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount'   => ['required', 'numeric', 'min:1'],
            'currency' => ['required', 'string', 'max:10'],
        ]);

        $user = Auth::user();
        $amount = (float) $request->input('amount');
        $amountCents = (int) round($amount * 100);
        $currency = strtoupper($request->input('currency'));
        $allowedCurrencies = collect(config('services.nowpayments.allowed_currencies', ['USD', 'EUR', 'GBP']))
            ->filter()
            ->map(fn ($code) => strtoupper($code))
            ->unique()
            ->values()
            ->all();

        if (! in_array($currency, $allowedCurrencies, true)) {
            $currency = $allowedCurrencies[0] ?? 'USD';
        }

        // Create a local deposit record (adjust column names to match your schema)
        $deposit = Deposit::create([
            'user_id'      => $user->id,
            'amount_cents' => $amountCents,
            'currency'     => $currency,
            'status'       => 'pending',
            'tx_hash'      => null,
        ]);

        $apiKey = env('NOWPAYMENTS_API_KEY');
        if (! $apiKey) {
            Log::error('NOWPayments API key missing in .env');
            return back()->withErrors([
                'deposit' => 'Deposit temporarily unavailable. Please contact support.',
            ]);
        }

        $ipnUrl     = env('NOWPAYMENTS_IPN_URL');
        $successUrl = route('dashboard');
        $cancelUrl  = route('dashboard');

        $payload = [
            'price_amount'   => $amount,
            'price_currency' => $currency,
            'order_id'       => (string) $deposit->id,
            'success_url'    => $successUrl,
            'cancel_url'     => $cancelUrl,
        ];

        if ($ipnUrl) {
            $payload['ipn_url'] = $ipnUrl;
        }

        // Create NOWPayments invoice
        $response = Http::withHeaders([
            'x-api-key' => $apiKey,
            'Content-Type' => 'application/json',
        ])->post(
            rtrim(config('services.nowpayments.base_url', 'https://api.nowpayments.io/v1'), '/').'/invoice',
            $payload
        );

        if (! $response->ok()) {
            Log::error('NOWPayments invoice creation failed', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);

            // Mark deposit as failed
            $deposit->status = 'failed';
            $deposit->save();

            return back()->withErrors([
                'deposit' => 'Unable to initiate payment. Please try again later.',
            ]);
        }

        $data = $response->json();

        // Save external invoice/payment ID if provided
        if (isset($data['id'])) {
            $deposit->tx_hash = (string) $data['id'];
            $deposit->save();
        }

        // Redirect user to NOWPayments checkout URL
        $redirectUrl = $data['invoice_url'] ?? $data['payment_url'] ?? null;

        if (! $redirectUrl) {
            Log::error('NOWPayments response missing redirect URL', ['data' => $data]);
            return back()->withErrors([
                'deposit' => 'Payment provider error. Please contact support.',
            ]);
        }

        return redirect()->away($redirectUrl);
    }
    public function create(Request $request)
    {
        return view('deposits.create');
    }


    /**
     * Handle NOWPayments IPN callback.
     * This is called by NOWPayments servers when payment status changes.
     */
    public function ipn(Request $request)
    {
        Log::info('NOWPayments IPN received', $request->all());

        $orderId = $request->input('order_id');
        $status  = $request->input('payment_status');

        if (! $orderId) {
            return response()->json(['message' => 'Missing order_id'], 400);
        }

        $deposit = Deposit::find($orderId);

        if (! $deposit) {
            Log::warning('Deposit not found for IPN', ['order_id' => $orderId]);
            return response()->json(['message' => 'Deposit not found'], 404);
        }

        $status = strtolower($status);
        $successStatuses = ['finished', 'confirmed', 'partially_paid'];
        $failedStatuses   = ['failed', 'expired', 'cancelled', 'canceled'];

        $shouldCreditUser = false;

        if (in_array($status, $successStatuses, true)) {
            $shouldCreditUser = ! $deposit->credited;
            $deposit->status = 'confirmed';
        } elseif (in_array($status, $failedStatuses, true)) {
            $deposit->status = 'rejected';
        } else {
            $deposit->status = 'pending';
        }

        $deposit->save();

        if ($shouldCreditUser) {
            $user = $deposit->user;
            if ($user) {
                $currentBalance = (int) ($user->wallet_balance ?? 0);
                $user->wallet_balance = $currentBalance + (int) $deposit->amount_cents;
                $user->save();

                $deposit->credited = true;
                $deposit->save();
            }
        }

        return response()->json(['message' => 'ok']);
    }
    
}
