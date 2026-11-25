<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MembershipTransaction;
use App\Models\Payment;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalMembers = Member::count();
        $activeMembers = Member::where('is_active', true)->count();
        $pendingTransactions = MembershipTransaction::where('status', 'Pending')->count();
        $collectedPayments = Payment::sum('amount');

        $recentPendingTransactions = MembershipTransaction::with('member')
            ->where('status', 'Pending')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalMembers',
            'activeMembers',
            'pendingTransactions',
            'collectedPayments',
            'recentPendingTransactions'
        ));
    }
}

