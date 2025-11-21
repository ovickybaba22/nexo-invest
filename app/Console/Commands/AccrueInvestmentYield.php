<?php

namespace App\Console\Commands;

use App\Models\Investment;
use App\Models\InvestmentProfitLog;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AccrueInvestmentYield extends Command
{
    protected $signature = 'investments:accrue-yield {cycle? : daily|weekly|apy}';
    protected $description = 'Credit daily, weekly and APY yield for all active investments.';

    public function handle(): int
    {
        $cycleArgument = $this->argument('cycle');

        $availableCycles = ['daily', 'weekly', 'apy'];
        $cycles = $cycleArgument ? [$cycleArgument] : $availableCycles;

        foreach ($cycles as $cycle) {
            if (! in_array($cycle, $availableCycles, true)) {
                $this->warn("Unknown cycle '{$cycle}', skipping.");
                continue;
            }

            $this->processCycle($cycle);
        }

        $this->info('Investment yield accrual completed.');

        return Command::SUCCESS;
    }

    protected function processCycle(string $cycle): void
    {
        $now = Carbon::now();

        Investment::with(['plan', 'user'])
            ->where('status', 'active')
            ->whereHas('plan', function ($query) use ($cycle) {
                $query->where('roi_type', $cycle)
                    ->where('is_active', true);
            })
            ->chunkById(200, function ($investments) use ($now, $cycle) {
                foreach ($investments as $investment) {
                    $plan = $investment->plan;
                    if (! $plan) {
                        continue;
                    }

                    if (! $investment->needsYieldProcessing($cycle, $now)) {
                        continue;
                    }

                    $profitCents = $this->calculateProfitForInvestment($investment, $cycle);
                    if ($profitCents <= 0) {
                        continue;
                    }

                    DB::transaction(function () use ($investment, $profitCents, $now, $cycle) {
                        InvestmentProfitLog::create([
                            'investment_id' => $investment->id,
                            'user_id'       => $investment->user_id,
                            'amount_cents'  => $profitCents,
                            'cycle_type'    => $cycle,
                            'for_date'      => $now->copy()->startOfDay(),
                        ]);

                        $investment->accrued_profit_cents = (int) ($investment->accrued_profit_cents ?? 0) + $profitCents;
                        $investment->last_payout_at = $now;
                        $investment->next_payout_at = $investment->nextCycleDate($now, $cycle);
                        $investment->last_yield_at = $investment->last_payout_at;
                        $investment->next_yield_at = $investment->next_payout_at;
                        $investment->save();

                        $user = $investment->user;
                        if ($user) {
                            $user->wallet_balance = (int) ($user->wallet_balance ?? 0) + $profitCents;
                            $user->save();
                        }
                    });
                }
            });
    }

    protected function calculateProfitForInvestment(Investment $investment, string $cycle): int
    {
        $plan = $investment->plan;
        if (! $plan) {
            return 0;
        }

        $principalCents = (int) ($investment->amount_cents ?? 0);
        if ($principalCents <= 0) {
            return 0;
        }

        $principalUsd = $principalCents / 100;

        if ($cycle === 'apy') {
            $apy = (float) ($plan->apy_value ?? $plan->roi_value ?? 0);
            $rate = ($apy / 100) / 12;
        } else {
            $rate = (float) ($plan->roi_value ?? 0) / 100;
        }

        if ($rate <= 0) {
            return 0;
        }

        return (int) round($principalUsd * $rate * 100);
    }
}
