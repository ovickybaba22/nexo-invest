<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();

            // Which user requested this withdrawal
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Amount in cents (e.g. $5000.00 = 500000)
            $table->unsignedBigInteger('amount_cents');

            // How they want to be paid (bank, USDT, BTC, etc.)
            $table->string('method')->nullable();

            // Optional reference / transaction id you can fill later
            $table->string('reference')->nullable();

            // pending | approved | rejected | cancelled
            $table->string('status')->default('pending');

            // When you processed it
            $table->timestamp('processed_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('withdrawals');
    }
};