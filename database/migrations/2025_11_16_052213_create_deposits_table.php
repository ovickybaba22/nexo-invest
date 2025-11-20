<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('deposits', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');

        // Amount stored in cents for precision
        $table->bigInteger('amount_cents');

        // e.g. 'USDT', 'BTC', 'ETH'
        $table->string('currency')->default('USDT');

        // Optional: transaction hash / reference from blockchain or gateway
        $table->string('tx_hash')->nullable();

        // pending = user submitted, admin not confirmed yet
        // confirmed = admin approved (balance can be counted)
        // rejected = admin declined
        $table->string('status')->default('pending');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deposits');
    }
};
