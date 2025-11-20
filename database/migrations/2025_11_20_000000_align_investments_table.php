<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('investments', function (Blueprint $table) {
            if (! Schema::hasColumn('investments', 'amount_cents')) {
                $table->unsignedBigInteger('amount_cents')->after('plan_id')->default(0);
            }

            if (! Schema::hasColumn('investments', 'months')) {
                $table->unsignedSmallInteger('months')->after('amount_cents')->default(0);
            }

            if (! Schema::hasColumn('investments', 'target_roi_percent')) {
                $table->decimal('target_roi_percent', 8, 2)->after('months')->default(0);
            }

            if (! Schema::hasColumn('investments', 'expected_payout_cents')) {
                $table->unsignedBigInteger('expected_payout_cents')->after('target_roi_percent')->nullable();
            }

            if (! Schema::hasColumn('investments', 'started_at')) {
                $table->timestamp('started_at')->nullable()->after('expected_payout_cents');
            }
        });

        if (Schema::hasColumn('investments', 'amount')) {
            DB::table('investments')
                ->select('id', 'amount')
                ->orderBy('id')
                ->chunkById(100, function ($rows) {
                    foreach ($rows as $row) {
                        $cents = (int) round(((float) $row->amount) * 100);
                        DB::table('investments')
                            ->where('id', $row->id)
                            ->update(['amount_cents' => $cents]);
                    }
                });

            Schema::table('investments', function (Blueprint $table) {
                $table->dropColumn('amount');
            });
        }
    }

    public function down(): void
    {
        Schema::table('investments', function (Blueprint $table) {
            if (! Schema::hasColumn('investments', 'amount')) {
                $table->decimal('amount', 15, 2)->after('plan_id');
            }

            foreach (['started_at', 'expected_payout_cents', 'target_roi_percent', 'months', 'amount_cents'] as $column) {
                if (Schema::hasColumn('investments', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
