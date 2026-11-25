<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('membership_levels', function (Blueprint $table) {
            $table->decimal('fee', 10, 2)->nullable();
            $table->unsignedInteger('validity_days')->nullable();
            $table->text('benefits')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('membership_levels', function (Blueprint $table) {
            $table->dropColumn(['fee', 'validity_days', 'benefits']);
        });
    }
};

