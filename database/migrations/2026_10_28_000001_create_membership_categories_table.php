<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('membership_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        $now = now();

        DB::table('membership_categories')->insert([
            ['name' => 'Student', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Regular', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Senior Citizen', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Corporate', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('membership_categories');
    }
};


