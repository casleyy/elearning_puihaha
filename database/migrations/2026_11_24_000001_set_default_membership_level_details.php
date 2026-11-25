<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $defaults = [
            'Basic' => [
                'fee' => 100.00,
                'validity_days' => 365,
                'benefits' => 'Basic membership benefits',
            ],
            'Silver' => [
                'fee' => 250.00,
                'validity_days' => 365,
                'benefits' => 'Enhanced membership benefits',
            ],
            'Gold' => [
                'fee' => 500.00,
                'validity_days' => 365,
                'benefits' => 'Priority membership benefits',
            ],
            'Platinum' => [
                'fee' => 1000.00,
                'validity_days' => 365,
                'benefits' => 'Premium membership benefits',
            ],
        ];

        foreach ($defaults as $name => $values) {
            $level = DB::table('membership_levels')
                ->where('name', $name)
                ->first();

            if (! $level) {
                continue;
            }

            $updates = [];

            foreach ($values as $field => $value) {
                if ($level->$field === null) {
                    $updates[$field] = $value;
                }
            }

            if ($updates !== []) {
                DB::table('membership_levels')
                    ->where('id', $level->id)
                    ->update($updates);
            }
        }
    }

    public function down(): void
    {
    }
};

