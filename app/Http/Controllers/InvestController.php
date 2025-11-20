<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Investment;
use App\Models\Deposit;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class InvestController extends Controller
{
    public function __construct()
    {
        // Only logged-in users can invest
        $this->middleware('auth');
    }

    /**
     * Show the "Start investment" form for a given plan.
     * Route: GET /invest/{plan:slug}
     */
    public function create(Plan $plan, Request $request)
    {
        // Only allow active plans
        abort_unless($plan->is_active, 404);

        $user = $request->user();

        // Compute wallet balance for this user so they can see what they can invest
        $walletBalanceCents = $this->calculateWalletBalanceCents($user->id);

        return view('invest.start', [
            'plan'               => $plan,
            'walletBalanceCents' => $walletBalanceCents,
        ]);
    }

    /**
     * Handle the form submit and create the investment.
     * Route: POST /invest/{plan:slug}
     */
    public function store(Request $request, Plan $plan)
    {
        // 1) Validate the form input
        $data = $request->validate([
            'amount' => ['required', 'numeric', 'min:1'],
        ]);

        // 2) Convert dollars → cents (e.g. 5000 => 500000)
        $amountCents = (int) round($data['amount'] * 100);

        // 2b) Enforce plan minimum deposit (if defined)
        $minDepositCents = 0;

        // If your plans table has a min_deposit_cents column, use it directly
        if (isset($plan->min_deposit_cents) && $plan->min_deposit_cents !== null) {
            $minDepositCents = (int) $plan->min_deposit_cents;
        }
        // Otherwise, fall back to a decimal min_deposit column (in dollars)
        elseif (isset($plan->min_deposit) && $plan->min_deposit !== null) {
            $minDepositCents = (int) round($plan->min_deposit * 100);
        }

        if ($minDepositCents > 0 && $amountCents < $minDepositCents) {
            $minDepositUsd = number_format($minDepositCents / 100, 2);

            return back()
                ->withErrors([
                    'amount' => "Minimum investment for this plan is \${$minDepositUsd}.",
                ])
                ->withInput();
        }

        $user = $request->user();

        // 3) Check wallet balance before creating investment
        $walletBalanceCents = $this->calculateWalletBalanceCents($user->id);

        if ($amountCents > $walletBalanceCents) {
            $availableUsd = number_format($walletBalanceCents / 100, 2);

            return back()
                ->withErrors([
                    'amount' => "Insufficient balance. Your available balance is \${$availableUsd}.",
                ])
                ->withInput();
        }

        // 4) How many months this investment will run
        //    We'll use the plan's minimum months as the default term
        $months = $plan->min_months ?? 0;

        // 4b) Target ROI for this investment
        $targetRoiPercent = $plan->target_roi_percent ?? 0;

        // 4c) Expected payout (principal + profit) in cents
        $expectedPayoutCents = (int) round(
            $amountCents + ($amountCents * ($targetRoiPercent / 100))
        );

        // 5) Create the investment row (funded from wallet balance)
        Investment::create([
            'user_id'               => $user->id,
            'plan_id'               => $plan->id,
            'amount_cents'          => $amountCents,
            'months'                => $months,
            'target_roi_percent'    => $targetRoiPercent,
            'expected_payout_cents' => $expectedPayoutCents,
            'started_at'            => now(),
            'status'                => 'active',
        ]);

        // 6) Back to dashboard with a success message
        return redirect()
            ->route('dashboard')
            ->with('status', 'Investment created successfully and funded from your balance.');
    }

    /**
     * Helper: calculate the user's wallet balance in cents.
     * Wallet balance = confirmed deposits - investments - approved withdrawals - pending withdrawals.
     */
    protected function calculateWalletBalanceCents(int $userId): int
    {
        // Confirmed deposits (credited from NOWPayments)
        $confirmedDepositsCents = Deposit::where('user_id', $userId)
            ->where('status', 'confirmed')
            ->sum('amount_cents');

        // Active investments
        $totalInvestedCents = Investment::where('user_id', $userId)
            ->where('status', 'active')
            ->sum('amount_cents');

        // Withdrawals
        $pendingWithdrawalsCents = Withdrawal::where('user_id', $userId)
            ->where('status', 'pending')
            ->sum('amount_cents');

        $approvedWithdrawalsCents = Withdrawal::where('user_id', $userId)
            ->where('status', 'approved')
            ->sum('amount_cents');

        // Wallet logic
        $walletBalanceCents = max(
            $confirmedDepositsCents
            - $totalInvestedCents
            - $approvedWithdrawalsCents
            - $pendingWithdrawalsCents,
            0
        );

        return $walletBalanceCents;
    }
}
