<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('investment_profit_logs', function (Blueprint $table) {
            if (! Schema::hasColumn('investment_profit_logs', 'amount_cents')) {
                $table->unsignedBigInteger('amount_cents')->after('user_id')->default(0);
            }
        });

        if (Schema::hasColumn('investment_profit_logs', 'amount')) {
            DB::table('investment_profit_logs')
                ->select('id', 'amount')
                ->orderBy('id')
                ->chunkById(200, function ($rows) {
                    foreach ($rows as $row) {
                        $cents = (int) round(((float) $row->amount) * 100);
                        DB::table('investment_profit_logs')
                            ->where('id', $row->id)
                            ->update(['amount_cents' => $cents]);
                    }
                });

            Schema::table('investment_profit_logs', function (Blueprint $table) {
                $table->dropColumn('amount');
            });
        }
    }

    public function down(): void
    {
        Schema::table('investment_profit_logs', function (Blueprint $table) {
            if (! Schema::hasColumn('investment_profit_logs', 'amount')) {
                $table->decimal('amount', 18, 2)->after('user_id');
            }

            if (Schema::hasColumn('investment_profit_logs', 'amount_cents')) {
                $table->dropColumn('amount_cents');
            }
        });
    }
};
