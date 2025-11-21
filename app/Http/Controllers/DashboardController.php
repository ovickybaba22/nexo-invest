<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use App\Models\Plan;
use App\Models\Withdrawal;
use App\Models\Deposit;
use App\Models\InvestmentProfitLog;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // 1) Active investments for this user
        $activeInvestments = Investment::with('plan')
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->get();

        // Total amount currently invested (portfolio)
        $totalInvestedCents = $activeInvestments->sum('amount_cents');

        // Current value (principal + accrued profit) for each active investment
        $portfolioCurrentCents = $activeInvestments->sum('current_value_cents');

        // Total profit credited to date (lifetime)
        $lifetimeProfitCents = InvestmentProfitLog::where('user_id', $user->id)
            ->sum('amount_cents');

        // 2) Active plans count (how many distinct plans the user is in)
        $activePlansCount = $activeInvestments
            ->groupBy('plan_id')
            ->count();

        // 3) Deposits (confirmed only – credited from NOWPayments)
        // We treat both "confirmed" and "completed" as cleared deposits, to match IPN logic
        $confirmedDepositsCents = Deposit::where('user_id', $user->id)
            ->whereIn('status', ['confirmed', 'completed'])
            ->sum('amount_cents');

        // 4) Withdrawals
        $pendingWithdrawalsCents = Withdrawal::where('user_id', $user->id)
            ->where('status', 'pending')
            ->sum('amount_cents');

        $approvedWithdrawalsCents = Withdrawal::where('user_id', $user->id)
            ->where('status', 'approved')
            ->sum('amount_cents');

        // 5) Wallet logic (Nexo-style):
        //    Wallet / Available to invest = confirmed deposits
        //                                   - invested amounts
        //                                   - approved withdrawals
        //                                   - pending withdrawals
        $walletBalanceCents = max(
            $confirmedDepositsCents
            - $totalInvestedCents
            - $approvedWithdrawalsCents
            - $pendingWithdrawalsCents,
            0
        );

        // What we show as "Portfolio value" on the dashboard:
        // use the current value (principal + profit), not just principal.
        $portfolioBalanceCents = $portfolioCurrentCents;

        // --- Performance metrics: today, 7d, YTD ---

        $today = Carbon::today();
        $startOfYear = $today->copy()->startOfYear();
        $sevenDaysAgo = $today->copy()->subDays(6);

        $weekStart = $today->copy()->startOfWeek();
        $profitStats = InvestmentProfitLog::where('user_id', $user->id)
            ->whereBetween('for_date', [$startOfYear, $today])
            ->selectRaw("
                SUM(CASE WHEN for_date = ? THEN amount_cents ELSE 0 END) as today_profit,
                SUM(CASE WHEN for_date >= ? THEN amount_cents ELSE 0 END) as seven_day_profit,
                SUM(CASE WHEN for_date >= ? THEN amount_cents ELSE 0 END) as week_profit,
                SUM(amount_cents) as ytd_profit
            ", [$today->toDateString(), $sevenDaysAgo->toDateString(), $weekStart->toDateString()])
            ->first();

        $todayProfitCents = (int) optional($profitStats)->today_profit;
        $sevenDaysProfitCents = (int) optional($profitStats)->seven_day_profit;
        $ytdProfitCents = (int) optional($profitStats)->ytd_profit;
        $thisWeekProfitCents = (int) optional($profitStats)->week_profit;
        $totalProfitCents = $lifetimeProfitCents;

        $cycleTotals = InvestmentProfitLog::where('user_id', $user->id)
            ->selectRaw("
                SUM(CASE WHEN cycle_type = 'daily' THEN amount_cents ELSE 0 END) as daily_profit,
                SUM(CASE WHEN cycle_type = 'weekly' THEN amount_cents ELSE 0 END) as weekly_profit,
                SUM(CASE WHEN cycle_type = 'apy' THEN amount_cents ELSE 0 END) as apy_profit
            ")->first();

        $dailyCycleProfitCents = (int) optional($cycleTotals)->daily_profit;
        $weeklyCycleProfitCents = (int) optional($cycleTotals)->weekly_profit;
        $apyCycleProfitCents = (int) optional($cycleTotals)->apy_profit;

        // Percentage changes relative to invested capital
        $denominatorCents = max($totalInvestedCents, 1); // avoid division by zero

        $sevenDayChangePercent = round(($sevenDaysProfitCents / $denominatorCents) * 100, 3);
        $ytdChangePercent      = round(($ytdProfitCents / $denominatorCents) * 100, 3);

        // Available to withdraw / invest is the wallet balance (uninvested funds)
        $availableBalanceCents = $walletBalanceCents;

        $availableToInvestCents = $walletBalanceCents;

        // 6) Plans summary for "Your investment plans"
        $plansSummary = $activeInvestments
            ->groupBy('plan_id')
            ->map(function ($group) {
                $investment = $group->first();
                $plan = $investment->plan;
                $planMonths = $plan->min_months ?? 0;
                $termDays = max(1, $planMonths * 30);

                $totalAmountCents = $group->sum('amount_cents');
                $currentValueCents = $group->sum(function ($investment) {
                    return $investment->current_value_cents ?? $investment->amount_cents;
                });
                $profitCents = $currentValueCents - $totalAmountCents;

                $progressAverage = $group->avg(function ($investment) use ($termDays) {
                    $startedAt = $investment->started_at ?? $investment->created_at;
                    $elapsedDays = $startedAt ? $startedAt->diffInDays(Carbon::now()) : 0;
                    return min(100, max(0, ($elapsedDays / $termDays) * 100));
                });

                return [
                    'plan'                => $plan,
                    'total_amount_cents'  => $totalAmountCents,
                    'current_value_cents' => $currentValueCents,
                    'profit_cents'        => $profitCents,
                    'progress_percent'    => round($progressAverage ?? 0, 1),
                    'investment_count'    => $group->count(),
                    'target_roi_percent'  => $plan->target_roi_percent ?? 0,
                ];
            })
            ->values();

        // 7) Available plans (what user can still invest into)
        $availablePlans = Plan::where('is_active', true)->get();

        // 8) Recent activity (Investments + Withdrawals merged)
        $recentInvestments = Investment::with('plan')
            ->where('user_id', $user->id)
            ->latest()
            ->take(10)
            ->get();

        $recentWithdrawals = Withdrawal::where('user_id', $user->id)
            ->latest()
            ->take(10)
            ->get();

        $recentDeposits = Deposit::where('user_id', $user->id)
            ->latest()
            ->take(10)
            ->get();

        $recentActivity = collect();

        foreach ($recentInvestments as $inv) {
            $recentActivity->push([
                'date'         => $inv->created_at,
                'type'         => 'Investment',
                'plan_name'    => optional($inv->plan)->name,
                'amount_cents' => $inv->amount_cents,
                'status'       => $inv->status ?? 'active',
            ]);
        }

        foreach ($recentDeposits as $dep) {
            $recentActivity->push([
                'date'         => $dep->created_at,
                'type'         => 'Deposit',
                'plan_name'    => null,
                'amount_cents' => $dep->amount_cents,
                'status'       => $dep->status,
            ]);
        }

        foreach ($recentWithdrawals as $wd) {
            $recentActivity->push([
                'date'         => $wd->created_at,
                'type'         => 'Withdrawal',
                'plan_name'    => null,
                'amount_cents' => $wd->amount_cents,
                'status'       => $wd->status,
            ]);
        }

        $recentActivity = $recentActivity
            ->sortByDesc('date')
            ->take(10)
            ->values();

        $apyPortfolioCents = $activeInvestments
            ->filter(fn ($investment) => optional($investment->plan)->roi_type === 'apy')
            ->sum(fn ($investment) => $investment->current_value_cents ?? $investment->amount_cents);

        $chartStart = $today->copy()->subDays(29);
        $profitSeries = InvestmentProfitLog::where('user_id', $user->id)
            ->where('for_date', '>=', $chartStart)
            ->selectRaw('for_date, SUM(amount_cents) as total')
            ->groupBy('for_date')
            ->orderBy('for_date')
            ->get()
            ->map(fn ($row) => [
                'date' => Carbon::parse($row->for_date)->toDateString(),
                'amount' => (int) $row->total,
            ])
            ->values();

        $investmentsByCategory = $activeInvestments->groupBy(function ($investment) {
            return optional($investment->plan)->roi_type ?? 'daily';
        });

        // Money formatter passed to the dashboard view
        $formatMoney = function (?int $cents): string {
            $amount = ($cents ?? 0) / 100;
            return '$' . number_format($amount, 2);
        };

        $totalBalanceCents = $portfolioBalanceCents + $walletBalanceCents;

        // 9) Portfolio allocation per plan (for Core / Balanced / Growth chips)
        $allocation = collect();

        if ($totalInvestedCents > 0) {
            $colorPalette = ['sky', 'emerald', 'indigo', 'amber', 'rose'];
            $colorIndex = 0;
            $allocation = $activeInvestments
                ->filter(function ($investment) {
                    return $investment->plan !== null;
                })
                ->groupBy('plan_id')
                ->map(function ($group) use ($totalInvestedCents, &$colorIndex, $colorPalette) {
                    $investment = $group->first();
                    $plan = $investment->plan;

                    $planAmountCents = $group->sum('amount_cents');
                    $color = $colorPalette[$colorIndex % count($colorPalette)];
                    $colorIndex++;

                    return [
                        'plan_name'      => $plan->name,
                        'amount_cents'   => $planAmountCents,
                        'percent'        => round(($planAmountCents / $totalInvestedCents) * 100, 1),
                        'color'          => $color,
                    ];
                })
                ->sortByDesc('amount_cents')
                ->values();

            // Ensure rounding keeps total at 100% by correcting last slice
            $percentSum = $allocation->sum('percent');
            if (abs($percentSum - 100) >= 0.1) {
                $lastIndex = $allocation->count() - 1;
                if ($lastIndex >= 0) {
                    $allocation[$lastIndex]['percent'] = round($allocation[$lastIndex]['percent'] + (100 - $percentSum), 1);
                }
            }
        }

        return view('dashboard', [
            'totalBalanceCents'       => $totalBalanceCents,      // Total wallet + investments
            'totalProfitCents'        => $totalProfitCents,
            'walletBalanceCents'      => $walletBalanceCents,     // Available to invest
            'activePlansCount'        => $activePlansCount,
            'pendingWithdrawalsCents' => $pendingWithdrawalsCents,
            'pendingWithdrawalCents'  => $pendingWithdrawalsCents,
            'plansSummary'            => $plansSummary,
            'availablePlans'          => $availablePlans,
            'recentActivity'          => $recentActivity,
            'availableBalanceCents'   => $availableBalanceCents,
            'availableToInvestCents'  => $availableToInvestCents,
            'formatMoney'             => $formatMoney, 
            'allocation'              => $allocation,
            'todayProfitCents'       => $todayProfitCents,
            'sevenDayProfitCents'    => $sevenDaysProfitCents,
            'ytdProfitCents'         => $ytdProfitCents,
            'thisWeekProfitCents'    => $thisWeekProfitCents,
            'sevenDayChangePercent'  => $sevenDayChangePercent,
            'ytdChangePercent'       => $ytdChangePercent,
            'activeInvestments'      => $activeInvestments,
            'withdrawableWalletCents'=> $walletBalanceCents,
            'totalInvestedCents'     => $totalInvestedCents,
            'apyPortfolioCents'      => $apyPortfolioCents,
            'profitSeries'           => $profitSeries,
            'categoryProfitCents'    => [
                'daily' => $dailyCycleProfitCents,
                'weekly' => $weeklyCycleProfitCents,
                'apy' => $apyCycleProfitCents,
            ],
            'investmentsByCategory'  => $investmentsByCategory,
            'categoryLabels'         => [
                'daily' => 'Nexo Daily Yield',
                'weekly' => 'Nexo Weekly Growth',
                'apy'   => 'Nexo Managed Portfolios',
            ],
        ]);
    }
    
}
