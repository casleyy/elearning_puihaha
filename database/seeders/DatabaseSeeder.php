<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\MembershipCategory;
use App\Models\MembershipLevel;
use App\Models\MembershipTransaction;
use App\Models\Payment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $category = MembershipCategory::where('name', 'Student')->firstOrFail();
        $level = MembershipLevel::where('name', 'Basic')->firstOrFail();

        $level->update([
            'fee' => $level->fee ?? 100,
            'validity_days' => $level->validity_days ?? 365,
            'benefits' => $level->benefits ?? 'Basic membership benefits',
        ]);

        DB::transaction(function () use ($category, $level): void {
            $member = Member::updateOrCreate(
                ['membership_number' => 'DEMO-EXPIRED-001'],
                [
                    'name' => 'Demo Expired Member',
                    'email' => 'expired.demo@example.com',
                    'phone' => '09170000000',
                    'address' => 'Demo record',
                    'membership_category_id' => $category->id,
                    'membership_level_id' => $level->id,
                    'is_active' => false,
                    'membership_expires_at' => now()->subDay()->toDateString(),
                ]
            );

            $transaction = MembershipTransaction::updateOrCreate(
                ['reference_number' => 'DEMO-TXN-EXPIRED-001'],
                [
                    'member_id' => $member->id,
                    'type' => 'Application',
                    'status' => 'Expired',
                    'amount' => $level->fee,
                    'period_starts_at' => now()->subYear()->toDateString(),
                    'period_ends_at' => now()->subDay()->toDateString(),
                ]
            );

            Payment::updateOrCreate(
                ['payment_reference' => 'DEMO-PAY-EXPIRED-001'],
                [
                    'membership_transaction_id' => $transaction->id,
                    'amount' => $level->fee,
                    'method' => 'GCash',
                    'paid_at' => now()->subYear(),
                    'notes' => 'Demo payment record',
                ]
            );
        });
    }
}

