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
            $table->bigInteger('accrued_profit_cents')->default(0)->after('amount_cents');
            $table->timestamp('last_yield_at')->nullable()->after('last_profit_date');
            $table->timestamp('next_yield_at')->nullable()->after('last_yield_at');
        });

        if (Schema::hasColumn('investments', 'accrued_profit')) {
            DB::statement('UPDATE investments SET accrued_profit_cents = ROUND(COALESCE(accrued_profit,0) * 100)');

            Schema::table('investments', function (Blueprint $table) {
                $table->dropColumn('accrued_profit');
            });
        }
    }

    public function down(): void
    {
        Schema::table('investments', function (Blueprint $table) {
            $table->decimal('accrued_profit', 18, 2)->default(0);
            $table->dropColumn(['accrued_profit_cents', 'last_yield_at', 'next_yield_at']);
        });
    }
};
