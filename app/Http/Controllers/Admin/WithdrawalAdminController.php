<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WithdrawalAdminController extends Controller
{
    /**
     * Show all withdrawals for the admin panel.
     */
    public function index()
    {
        $withdrawals = Withdrawal::with('user')
            ->latest()
            ->paginate(20);

        return view('admin.withdrawals.index', compact('withdrawals'));
    }

    /**
     * Approve a pending withdrawal.
     *
     * NOTE:
     * - We do NOT touch the user's wallet here.
     * - Funds were already reserved when the withdrawal was created.
     */
    public function approve(Withdrawal $withdrawal)
    {
        if ($withdrawal->status !== 'pending') {
            return back()->withErrors([
                'error' => 'This withdrawal is not pending.',
            ]);
        }

        DB::transaction(function () use ($withdrawal) {
            $withdrawal->status = 'approved';
            $withdrawal->save();
        });

        return back()->with('status', 'Withdrawal approved successfully.');
    }

    /**
     * Reject a pending withdrawal and refund it back to the user wallet.
     */
    public function reject(Withdrawal $withdrawal)
    {
        if ($withdrawal->status !== 'pending') {
            return back()->withErrors([
                'error' => 'This withdrawal is not pending.',
            ]);
        }

        DB::transaction(function () use ($withdrawal) {
            $user = $withdrawal->user;

            // Refund back to wallet balance if we have a user
            if ($user) {
                $currentBalance = $user->wallet_balance ?? 0;
                $user->wallet_balance = $currentBalance + $withdrawal->amount_cents;
                $user->save();
            }

            $withdrawal->status      = 'rejected';
            $withdrawal->save();
        });

        return back()->with('status', 'Withdrawal rejected and amount returned to user balance.');
    }
}