<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    /**
     * Seed the application's database with default investment plans.
     */
    public function run(): void
    {
        // store dollars as integer cents to match DB schema
        $toCents = fn (float $dollars) => (int) round($dollars * 100);

        $plans = [
            [
                'name' => 'Core',
                'slug' => 'core',
                'description' => 'Simple growth with capital protection and auto‑rebalancing.',
                'min_deposit' => $toCents(1000),
                'max_deposit' => $toCents(100000),
                'min_months' => 3,
                'max_months' => 24,
                'target_roi_percent' => 70,   // adjust as desired
                'max_roi_percent' => 120,
                'risk_level' => 'Core',
                'features' => [
                    ['value' => 'Auto‑rebalancing'],
                    ['value' => 'Daily analytics'],
                    ['value' => 'Institutional custody'],
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Balanced',
                'slug' => 'balanced',
                'description' => 'Diversified strategies with higher APY and dynamic allocation.',
                'min_deposit' => $toCents(5000),
                'max_deposit' => $toCents(250000),
                'min_months' => 3,
                'max_months' => 36,
                'target_roi_percent' => 120,
                'max_roi_percent' => 180,
                'risk_level' => 'Balanced',
                'features' => [
                    ['value' => 'Factor tilts'],
                    ['value' => 'Quarterly updates'],
                    ['value' => 'Priority support'],
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Growth',
                'slug' => 'growth',
                'description' => 'Aggressive allocation for maximum performance.',
                'min_deposit' => $toCents(25000),
                'max_deposit' => $toCents(1000000),
                'min_months' => 3,
                'max_months' => 48,
                'target_roi_percent' => 200,  // per your request
                'max_roi_percent' => 250,
                'risk_level' => 'Growth',
                'features' => [
                    ['value' => 'Performance fee structure'],
                    ['value' => 'Pro analytics suite'],
                    ['value' => 'Dedicated manager'],
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Private',
                'slug' => 'private',
                'description' => 'Private manager, enhanced allocations, bespoke mandates.',
                'min_deposit' => $toCents(100000),
                'max_deposit' => $toCents(5000000),
                'min_months' => 6,
                'max_months' => 60,
                'target_roi_percent' => 150,
                'max_roi_percent' => 220,
                'risk_level' => 'Growth',
                'features' => [
                    ['value' => 'Custom mandate'],
                    ['value' => 'Direct manager access'],
                    ['value' => 'Quarterly reviews'],
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Institutional',
                'slug' => 'institutional',
                'description' => 'Bespoke structures for institutions with dedicated team.',
                'min_deposit' => $toCents(250000),
                'max_deposit' => null, // open‑ended
                'min_months' => 6,
                'max_months' => null,
                'target_roi_percent' => 120,
                'max_roi_percent' => 200,
                'risk_level' => 'Balanced',
                'features' => [
                    ['value' => 'Custom reporting'],
                    ['value' => 'Dedicated desk'],
                    ['value' => 'Enhanced due diligence'],
                ],
                'is_active' => true,
            ],
        ];

        foreach ($plans as $data) {
            Plan::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }
    }
}