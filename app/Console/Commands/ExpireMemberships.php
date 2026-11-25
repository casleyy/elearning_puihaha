<?php

namespace App\Console\Commands;

use App\Models\Member;
use App\Models\MembershipTransaction;
use Illuminate\Console\Command;

class ExpireMemberships extends Command
{
    protected $signature = 'memberships:expire';
    protected $description = 'Mark memberships and approved transactions past their validity date as expired.';

    public function handle(): int
    {
        $expiredTransactions = MembershipTransaction::where('status', 'Approved')
            ->whereDate('period_ends_at', '<', today())
            ->get();

        foreach ($expiredTransactions as $transaction) {
            $transaction->update(['status' => 'Expired']);
        }

        Member::whereNotNull('membership_expires_at')
            ->whereDate('membership_expires_at', '<', today())
            ->update(['is_active' => false]);

        $this->info($expiredTransactions->count() . ' transaction(s) marked expired.');
        return self::SUCCESS;
    }
}
