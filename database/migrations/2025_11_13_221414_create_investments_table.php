<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('investments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('plan_id')->constrained('plans')->cascadeOnDelete();
            $table->unsignedBigInteger('amount_cents');
            $table->unsignedSmallInteger('months')->default(0);
            $table->decimal('target_roi_percent', 8, 2)->default(0);
            $table->unsignedBigInteger('expected_payout_cents')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->string('status')->default('active'); // or 'pending' if you prefer
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('investments');
    }
};
