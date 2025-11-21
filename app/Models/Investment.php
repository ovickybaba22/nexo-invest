<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Investment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan_id',
        'amount_cents',
        'months',
        'accrued_profit_cents',
        'target_roi_percent',
        'expected_payout_cents',
        'started_at',
        'status',
        'last_yield_at',
        'next_yield_at',
        'last_payout_at',
        'next_payout_at',
    ];

    protected $casts = [
        'amount_cents'         => 'integer',
        'accrued_profit_cents' => 'integer',
        'expected_payout_cents'=> 'integer',
        'months'               => 'integer',
        'target_roi_percent'   => 'float',
        'started_at'           => 'datetime',
        'last_profit_date'     => 'date',
        'last_yield_at'        => 'datetime',
        'next_yield_at'        => 'datetime',
        'last_payout_at'       => 'datetime',
        'next_payout_at'       => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    // Helper to get amount in dollars
    public function getAmountDollarsAttribute(): float
    {
        return $this->amount_cents / 100;
    }

    // Helper to get expected payout in dollars
    public function getExpectedPayoutDollarsAttribute(): float
    {
        return $this->expected_payout_cents / 100;
    }

    public function getAccruedProfitDollarsAttribute(): float
    {
        return ($this->accrued_profit_cents ?? 0) / 100;
    }

    public function needsYieldProcessing(string $cycle, Carbon $now): bool
    {
        $last = $this->last_payout_at ?? $this->last_yield_at;

        if (! $last instanceof Carbon) {
            $last = $last ? Carbon::parse($last) : null;
        }

        if (! $last) {
            return true;
        }

        return match ($cycle) {
            'weekly' => $last->diffInDays($now) >= 7,
            'apy'    => $last->diffInDays($now) >= 30,
            default  => $last->lt($now->copy()->startOfDay()),
        };
    }

    public function cycleRate(string $cycle): float
    {
        $plan = $this->plan;
        if (! $plan) {
            return 0.0;
        }

        return match ($cycle) {
            'weekly' => (float) ($plan->roi_value ?? 0) / 100,
            'apy'    => (float) ($plan->apy_value ?? $plan->roi_value ?? 0) / 100 / 12,
            default  => (float) ($plan->roi_value ?? 0) / 100,
        };
    }

    public function nextCycleDate(Carbon $now, string $cycle): Carbon
    {
        return match ($cycle) {
            'weekly' => $now->copy()->addWeek(),
            'apy'    => $now->copy()->addMonth(),
            default  => $now->copy()->addDay(),
        };
    }

    /**
     * Computed current value of this investment (principal + accrued profit) in cents.
     *
     * Uses the plan's annual ROI and the number of days since started_at
     * to approximate a daily-compounded return.
     */
    public function getCurrentValueCentsAttribute(): int
    {
        $principal = (int) ($this->amount_cents ?? 0);

        // Fallback: if we do not have a plan, ROI or start date, return principal.
        if (! $this->relationLoaded('plan')) {
            $this->load('plan');
        }

        $plan = $this->plan;
        $annual = $plan?->annual_roi_percent ?? $this->target_roi_percent ?? 0;

        if (! $this->started_at instanceof Carbon || $annual <= 0) {
            return $principal;
        }

        $days = $this->started_at->diffInDays(Carbon::now());

        // Daily compound interest based on annual percentage rate.
        $dailyRate = $annual / 100 / 365;
        $value = $principal * pow(1 + $dailyRate, $days);

        return (int) round($value);
    }

    /**
     * Computed profit in cents (current value minus principal).
     */
    public function getProfitCentsAttribute(): int
    {
        return $this->current_value_cents - (int) ($this->amount_cents ?? 0);
    }
}
