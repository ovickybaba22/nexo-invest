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
    Schema::create('investment_profit_logs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('investment_id')->constrained()->cascadeOnDelete();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->unsignedBigInteger('amount_cents');   // profit amount in cents
        $table->date('for_date');          // date the profit belongs to
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('investment_profit_logs');
}
};
