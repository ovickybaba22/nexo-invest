<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->string('category')->default('daily')->after('slug');
            $table->string('roi_type')->default('daily')->after('category');
            $table->decimal('roi_value', 8, 4)->default(0)->after('roi_type');
            $table->string('term_label')->nullable()->after('max_months');
        });
    }

    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn(['category', 'roi_type', 'roi_value', 'term_label']);
        });
    }
};
