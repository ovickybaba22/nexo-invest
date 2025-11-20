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
        'min_deposit',
        'max_deposit',
        'min_months',
        'max_months',
        'target_roi_percent',
        'max_roi_percent',
        'risk_level',
        'features',
        'is_active',
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
        'target_roi_percent'=> 'float',
        'max_roi_percent'   => 'float',
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
        return (int) round(($this->min_deposit ?? 0) * 100);
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
}
