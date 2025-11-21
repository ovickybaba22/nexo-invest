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
            if (! Schema::hasColumn('investments', 'last_payout_at')) {
                $table->timestamp('last_payout_at')->nullable()->after('last_yield_at');
            }

            if (! Schema::hasColumn('investments', 'next_payout_at')) {
                $table->timestamp('next_payout_at')->nullable()->after('last_payout_at');
            }
        });

        if (Schema::hasColumn('investments', 'last_yield_at')) {
            DB::table('investments')->update([
                'last_payout_at' => DB::raw('COALESCE(last_payout_at, last_yield_at)'),
            ]);
        }

        if (Schema::hasColumn('investments', 'next_yield_at')) {
            DB::table('investments')->update([
                'next_payout_at' => DB::raw('COALESCE(next_payout_at, next_yield_at)'),
            ]);
        }
    }

    public function down(): void
    {
        Schema::table('investments', function (Blueprint $table) {
            if (Schema::hasColumn('investments', 'next_payout_at')) {
                $table->dropColumn('next_payout_at');
            }

            if (Schema::hasColumn('investments', 'last_payout_at')) {
                $table->dropColumn('last_payout_at');
            }
        });
    }
};
