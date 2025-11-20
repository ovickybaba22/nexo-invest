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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();

            // Basics
            $table->string('name');                 // e.g. Core, Growth, Private, Institutional
            $table->string('slug')->unique();       // URL-safe unique id
            $table->text('description')->nullable();

            // Deposits (store money in cents to avoid float issues)
            $table->unsignedBigInteger('min_deposit')->default(0);   // 100000 = $1,000.00
            $table->unsignedBigInteger('max_deposit')->nullable();   // null = no max

            // Duration in months
            $table->unsignedTinyInteger('min_months')->default(1);
            $table->unsignedTinyInteger('max_months')->nullable();   // null = open-ended

            // Returns (percent, e.g. 200.00 == 200%)
            $table->decimal('target_roi_percent', 5, 2)->default(0);
            $table->decimal('max_roi_percent', 5, 2)->nullable();

            // Labeling / presentation
            $table->string('risk_level')->default('Balanced');       // Core / Growth / Balanced etc.
            $table->json('features')->nullable();                    // bullet list for UI

            // Status
            $table->boolean('is_active')->default(true);

            // Helpful indexes
            $table->index('is_active');
            $table->index('risk_level');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
