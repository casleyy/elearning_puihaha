<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('membership_levels', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        $now = now();

        DB::table('membership_levels')->insert([
            ['name' => 'Basic', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Silver', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Gold', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Platinum', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('membership_levels');
    }
};

