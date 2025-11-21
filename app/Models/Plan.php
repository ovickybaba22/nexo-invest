<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    /**
     * Mass-assignable columns.
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'category',
        'roi_type',
        'roi_value',
        'min_deposit',
        'max_deposit',
        'min_months',
        'max_months',
        'term_label',
        'target_roi_percent',
        'max_roi_percent',
        'risk_level',
        'features',
        'is_active',
        'apy_value',
    ];

    /**
     * Attribute casting.
     */
    protected $casts = [
        'features'          => 'array',
        'is_active'         => 'boolean',
        'min_deposit'       => 'integer',
        'max_deposit'       => 'integer',
        'min_months'        => 'integer',
        'max_months'        => 'integer',
        'roi_value'         => 'float',
        'target_roi_percent'=> 'float',
        'max_roi_percent'   => 'float',
        'apy_value'         => 'float',
    ];

    /**
     * Alias accessor: treat target_roi_percent as the primary annual ROI field.
     */
    public function getAnnualRoiPercentAttribute(): float
    {
        return (float) ($this->target_roi_percent ?? 0);
    }

    /**
     * Convenience accessor: minimum deposit in cents (for money-safe calculations).
     */
    public function getMinDepositCentsAttribute(): int
    {
        return (int) ($this->min_deposit ?? 0);
    }

    public function getMaxDepositCentsAttribute(): ?int
    {
        $value = $this->max_deposit;

        return is_null($value) ? null : (int) $value;
    }

    /**
     * Use the 'slug' column for route model binding.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Query scope: only active plans.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeCategory(Builder $query, string $category): Builder
    {
        return $query->where('category', $category);
    }

    public function getDisplayCategoryAttribute(): string
    {
        return match ($this->category) {
            'weekly' => 'Nexo Weekly Growth',
            'apy'    => 'Nexo Managed Portfolios',
            default  => 'Nexo Daily Yield',
        };
    }

    public function isDaily(): bool
    {
        return $this->roi_type === 'daily';
    }

    public function isWeekly(): bool
    {
        return $this->roi_type === 'weekly';
    }

    public function isApy(): bool
    {
        return $this->roi_type === 'apy';
    }

    /**
     * Helper to fetch the display ROI percent for the plan.
     */
    public function getDisplayRoiAttribute(): float
    {
        if ($this->isApy()) {
            return (float) ($this->apy_value ?? $this->roi_value ?? 0);
        }

        return (float) ($this->roi_value ?? 0);
    }
}
