<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Investment;
use App\Models\Plan;
use App\Models\InvestmentProfitLog;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AccrueDailyInvestmentProfit extends Command
{
    protected $signature = 'investments:accrue-daily-profit';
    protected $description = 'Accrue daily profit for all active investments based on plan ROI.';

    public function handle(): int
    {
        $today = Carbon::today();

        // adjust "status" value to whatever you use for active investments
        $investments = Investment::with(['plan', 'user'])
            ->where('status', 'active')
            ->get();

        foreach ($investments as $investment) {
            // Skip if we already processed today
            if ($investment->last_profit_date && Carbon::parse($investment->last_profit_date)->equalTo($today)) {
                continue;
            }

            $plan = $investment->plan;

            if (! $plan || ! $plan->target_roi_percent) {
                continue;
            }

            // monthly ROI → daily ROI (simple 30-day month)
            $dailyRate = ($plan->target_roi_percent / 100) / 30;

            // base capital in USD (convert from cents for accuracy)
            $principalCents = (int) ($investment->amount_cents ?? 0);

            if ($principalCents <= 0) {
                continue;
            }

            $baseAmountUsd = $principalCents / 100;
            $profitTodayUsd = round($baseAmountUsd * $dailyRate, 2);
            $profitTodayCents = (int) round($profitTodayUsd * 100);

            if ($profitTodayCents <= 0) {
                continue;
            }

            DB::transaction(function () use ($investment, $profitTodayUsd, $profitTodayCents, $today) {
                // 1) log the profit
                InvestmentProfitLog::create([
                    'investment_id' => $investment->id,
                    'user_id'       => $investment->user_id,
                    'amount_cents'  => $profitTodayCents,
                    'for_date'      => $today,
                ]);

                // 2) update investment totals
                $investment->accrued_profit = $investment->accrued_profit + $profitTodayUsd;
                $investment->last_profit_date = $today;
                $investment->save();

                // 3) credit user wallet / available balance
                $user = $investment->user;
                if ($user) {
                    $currentBalance = (int) ($user->wallet_balance ?? 0);
                    $user->wallet_balance = $currentBalance + $profitTodayCents;
                    $user->save();
                }
            });
        }

        $this->info('Daily profit accrued successfully.');

        return Command::SUCCESS;
    }
}
