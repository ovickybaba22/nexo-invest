<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Plan;
use App\Models\Deposit;
use App\Models\Withdrawal;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Aggregate metrics
        $totalUsers = User::count();
        $totalPlans = Plan::count();
        $totalDepositsCents = Deposit::sum('amount_cents');
        $totalWithdrawalsCents = Withdrawal::sum('amount_cents');

        // Simple money formatting helper for this view
        $formatMoney = function (int $cents = 0): string {
            return '$' . number_format($cents / 100, 2);
        };

        return view('admin.dashboard', [
            'totalUsers'             => $totalUsers,
            'totalPlans'             => $totalPlans,
            'totalDepositsCents'     => $totalDepositsCents,
            'totalWithdrawalsCents'  => $totalWithdrawalsCents,
            'formatMoney'            => $formatMoney,
        ]);
    }
}