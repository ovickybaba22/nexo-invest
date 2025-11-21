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
        $toCents = fn (float $dollars) => (int) round($dollars * 100);

        $plans = [
            [
                'name' => 'Nexo Daily Starter',
                'slug' => 'nexo-daily-starter',
                'category' => 'daily',
                'roi_type' => 'daily',
                'roi_value' => 0.7,
                'apy_value' => null,
                'description' => 'Entry-tier daily yield with same-day liquidity after a 30 day runway.',
                'term_label' => 'Flexible / 30+ days',
                'risk_level' => 'Moderate risk',
                'min_deposit' => $toCents(500),
                'max_deposit' => $toCents(4999),
                'features' => [
                    ['value' => 'Automated trade execution'],
                    ['value' => 'Capital call alerts'],
                ],
            ],
            [
                'name' => 'Nexo Daily Turbo',
                'slug' => 'nexo-daily-turbo',
                'category' => 'daily',
                'roi_type' => 'daily',
                'roi_value' => 1.0,
                'apy_value' => null,
                'description' => 'Higher octane daily stream with proactive risk monitoring.',
                'term_label' => 'Flexible / 60+ days',
                'risk_level' => 'High risk',
                'min_deposit' => $toCents(1000),
                'max_deposit' => $toCents(9999),
                'features' => [
                    ['value' => 'Priority performance desk'],
                    ['value' => 'Intra-day visibility'],
                ],
            ],
            [
                'name' => 'Nexo Daily Elite',
                'slug' => 'nexo-daily-elite',
                'category' => 'daily',
                'roi_type' => 'daily',
                'roi_value' => 1.5,
                'apy_value' => null,
                'description' => 'Elite allocation combining derivatives hedging with liquidity buffers.',
                'term_label' => 'Recommended 90+ days',
                'risk_level' => 'High risk',
                'min_deposit' => $toCents(2500),
                'max_deposit' => $toCents(24999),
                'features' => [
                    ['value' => 'Hands-on treasury concierge'],
                    ['value' => 'Drawdown protection rules'],
                ],
            ],
            [
                'name' => 'Nexo Daily Ultra',
                'slug' => 'nexo-daily-ultra',
                'category' => 'daily',
                'roi_type' => 'daily',
                'roi_value' => 2.0,
                'apy_value' => null,
                'description' => 'Institutional grade high velocity routing for capital-hungry mandates.',
                'term_label' => 'Recommended 120+ days',
                'risk_level' => 'Very high risk',
                'min_deposit' => $toCents(5000),
                'max_deposit' => null,
                'features' => [
                    ['value' => 'Bespoke reporting stack'],
                    ['value' => 'Direct strategists access'],
                ],
            ],
            [
                'name' => 'Nexo Growth Weekly',
                'slug' => 'nexo-growth-weekly',
                'category' => 'weekly',
                'roi_type' => 'weekly',
                'roi_value' => 3.0,
                'apy_value' => null,
                'description' => 'Weekly compounding strategy focused on diversified growth venues.',
                'term_label' => 'Recommended 8+ weeks',
                'risk_level' => 'Balanced risk',
                'min_deposit' => $toCents(1000),
                'max_deposit' => $toCents(9999),
                'features' => [
                    ['value' => 'Weekly wallet credit'],
                    ['value' => 'Signals transparency'],
                ],
            ],
            [
                'name' => 'Nexo Alpha Weekly',
                'slug' => 'nexo-alpha-weekly',
                'category' => 'weekly',
                'roi_type' => 'weekly',
                'roi_value' => 5.0,
                'apy_value' => null,
                'description' => 'Alpha capture mix covering DeFi credit markets and OTC flows.',
                'term_label' => 'Recommended 12+ weeks',
                'risk_level' => 'Elevated risk',
                'min_deposit' => $toCents(2500),
                'max_deposit' => $toCents(24999),
                'features' => [
                    ['value' => 'Weekly rollovers'],
                    ['value' => 'Automated compliance evidence'],
                ],
            ],
            [
                'name' => 'Nexo Quantum Weekly',
                'slug' => 'nexo-quantum-weekly',
                'category' => 'weekly',
                'roi_type' => 'weekly',
                'roi_value' => 7.0,
                'apy_value' => null,
                'description' => 'Quantum strategy for scale-ups needing aggressive yet managed returns.',
                'term_label' => 'Recommended 16+ weeks',
                'risk_level' => 'High risk',
                'min_deposit' => $toCents(5000),
                'max_deposit' => $toCents(49999),
                'features' => [
                    ['value' => 'Dedicated account strategists'],
                    ['value' => 'Custom hedging overlays'],
                ],
            ],
            [
                'name' => 'Nexo Private Weekly',
                'slug' => 'nexo-private-weekly',
                'category' => 'weekly',
                'roi_type' => 'weekly',
                'roi_value' => 10.0,
                'apy_value' => null,
                'description' => 'Private office desk with bespoke structuring and concierge execution.',
                'term_label' => 'Recommended 24+ weeks',
                'risk_level' => 'Very high risk',
                'min_deposit' => $toCents(10000),
                'max_deposit' => null,
                'features' => [
                    ['value' => 'Executive performance reviews'],
                    ['value' => 'White-glove liquidity routing'],
                ],
            ],
            [
                'name' => 'Nexo Core Yield',
                'slug' => 'nexo-core-yield',
                'category' => 'apy',
                'roi_type' => 'apy',
                'roi_value' => 15.0,
                'apy_value' => 15.0,
                'description' => 'Conservative managed portfolio balancing blue-chip CeFi and DeFi exposure.',
                'term_label' => '12 month minimum',
                'risk_level' => 'Conservative income',
                'min_deposit' => $toCents(2000),
                'max_deposit' => null,
                'min_months' => 12,
                'features' => [
                    ['value' => 'Capital preservation focus'],
                    ['value' => 'Monthly cashflows'],
                ],
            ],
            [
                'name' => 'Nexo Balanced Yield',
                'slug' => 'nexo-balanced-yield',
                'category' => 'apy',
                'roi_type' => 'apy',
                'roi_value' => 22.0,
                'apy_value' => 22.0,
                'description' => 'Balanced risk/return managed portfolio for longer-term growth mandates.',
                'term_label' => '12 month minimum',
                'risk_level' => 'Balanced growth',
                'min_deposit' => $toCents(5000),
                'max_deposit' => null,
                'min_months' => 12,
                'features' => [
                    ['value' => 'Diversified strategy stack'],
                    ['value' => 'Monthly strategist briefing'],
                ],
            ],
            [
                'name' => 'Nexo Institutional Yield',
                'slug' => 'nexo-institutional-yield',
                'category' => 'apy',
                'roi_type' => 'apy',
                'roi_value' => 25.0,
                'apy_value' => 25.0,
                'description' => 'Institutional mandate with bespoke mandate design and reporting.',
                'term_label' => '12+ month custom term',
                'risk_level' => 'Custom mandate',
                'min_deposit' => $toCents(25000),
                'max_deposit' => null,
                'min_months' => 12,
                'features' => [
                    ['value' => 'Custom APY band'],
                    ['value' => 'Dedicated strategist pod'],
                ],
            ],
        ];

        $slugs = collect($plans)->pluck('slug');
        Plan::whereNotIn('slug', $slugs)->delete();

        foreach ($plans as $data) {
            $data['is_active'] = true;
            $data['target_roi_percent'] = $data['target_roi_percent'] ?? $data['roi_value'];
            $data['risk_level'] = $data['risk_level'] ?? null;
            $data['min_months'] = $data['min_months'] ?? 3;
            $data['features'] = $data['features'] ?? [];

            Plan::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }
    }
}
