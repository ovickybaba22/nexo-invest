<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('investments', function (Blueprint $table) {
            $table->index(['user_id', 'status'], 'investments_user_status_idx');
            $table->index(['plan_id', 'status'], 'investments_plan_status_idx');
        });

        Schema::table('investment_profit_logs', function (Blueprint $table) {
            $table->index(['user_id', 'for_date'], 'profit_logs_user_date_idx');
        });
    }

    public function down(): void
    {
        Schema::table('investments', function (Blueprint $table) {
            $table->dropIndex('investments_user_status_idx');
            $table->dropIndex('investments_plan_status_idx');
        });

        Schema::table('investment_profit_logs', function (Blueprint $table) {
            $table->dropIndex('profit_logs_user_date_idx');
        });
    }
};
