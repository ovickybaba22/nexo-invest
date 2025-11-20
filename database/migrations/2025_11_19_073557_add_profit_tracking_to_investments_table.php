<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('investments', function (Blueprint $table) {
        $table->decimal('accrued_profit', 18, 2)->default(0); // total profit on this investment
        $table->date('last_profit_date')->nullable();         // last date we credited profit
    });
}

public function down()
{
    Schema::table('investments', function (Blueprint $table) {
        $table->dropColumn(['accrued_profit', 'last_profit_date']);
    });
}
};
