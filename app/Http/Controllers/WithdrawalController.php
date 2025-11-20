<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use App\Models\Withdrawal;
use App\Models\Deposit;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function __construct()
    {
        // Only logged-in users can request withdrawals
        $this->middleware('auth');
    }

    /**
     * Show the withdrawal request form.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $walletBalanceCents = $this->calculateWithdrawableBalanceCents($user->id);
        $availableUsd = number_format($walletBalanceCents / 100, 2);

        return view('withdrawals.index', [
            'availableBalanceCents' => $walletBalanceCents,
            'availableBalanceUsd'   => $availableUsd,
        ]);
    }

    public function store(Request $request)
    {
        $user = $request->user();

        // 1) Validate input
        $data = $request->validate([
            'amount' => ['required', 'numeric', 'min:10'], // you can change the min
            'method' => ['nullable', 'string', 'max:255'],
        ]);

        // 2) Convert dollars to cents
        $amountCents = (int) round($data['amount'] * 100);

        if ($amountCents <= 0) {
            return back()
                ->withErrors(['amount' => 'Amount must be greater than zero.'])
                ->withInput();
        }

        // 3) Compute how much this user can withdraw right now.
        // Here we mirror the logic from DashboardController:
        $walletBalanceCents = $this->calculateWithdrawableBalanceCents($user->id);

        // 4) Block if they try to withdraw more than available wallet balance
        if ($amountCents > $walletBalanceCents) {
            $availableDollars = number_format($walletBalanceCents / 100, 2);

            return back()
                ->withErrors([
                    'amount' => "You cannot withdraw more than your available balance (\${$availableDollars}).",
                ])
                ->withInput();
        }
        // 5) Create the withdrawal row as pending
        Withdrawal::create([
            'user_id'      => $user->id,
            'amount_cents' => $amountCents,
            'method'       => $data['method'] ?? null,
            'status'       => 'pending',
        ]);

        // 6) Redirect back to dashboard with a success message
        return redirect()
            ->route('dashboard')
            ->with('success', 'Withdrawal request submitted. We’ll review it shortly.');
    }

    protected function calculateWithdrawableBalanceCents(int $userId): int
    {
        $confirmedDepositsCents = Deposit::where('user_id', $userId)
            ->whereIn('status', ['confirmed', 'completed'])
            ->sum('amount_cents');

        $activeInvestmentsCents = Investment::where('user_id', $userId)
            ->where('status', 'active')
            ->sum('amount_cents');

        $pendingWithdrawalsCents = Withdrawal::where('user_id', $userId)
            ->where('status', 'pending')
            ->sum('amount_cents');

        $approvedWithdrawalsCents = Withdrawal::where('user_id', $userId)
            ->where('status', 'approved')
            ->sum('amount_cents');

        return max(
            $confirmedDepositsCents
            - $activeInvestmentsCents
            - $approvedWithdrawalsCents
            - $pendingWithdrawalsCents,
            0
        );
    }
}
