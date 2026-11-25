<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MembershipLevel;
use App\Models\MembershipTransaction;
use App\Models\Payment;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function access(): RedirectResponse
    {
        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('home')->with('error', 'Admin access only. Your account cannot open the dashboard.');
    }

    public function index(): View
    {
        $transactionStatuses = collect(['Pending', 'Paid', 'Approved', 'Expired', 'Cancelled'])
            ->mapWithKeys(fn (string $status): array => [$status => 0])
            ->merge(
                MembershipTransaction::query()
                    ->selectRaw('status, COUNT(*) as total')
                    ->groupBy('status')
                    ->pluck('total', 'status')
            );

        $membersByLevel = MembershipLevel::withCount('members')->orderBy('id')->get();

        return view('admin.dashboard', [
            'totalMembers' => Member::count(),
            'activeMembers' => Member::where('is_active', true)->count(),
            'pendingTransactions' => MembershipTransaction::where('status', 'Pending')->count(),
            'collectedPayments' => Payment::sum('amount'),
            'recentTransactions' => MembershipTransaction::with('member')->latest()->limit(8)->get(),
            'transactionStatuses' => $transactionStatuses,
            'membersByLevel' => $membersByLevel,
            'maxMembersByLevel' => max(1, (int) $membersByLevel->max('members_count')),
            'maxTransactionsByStatus' => max(1, (int) $transactionStatuses->max()),
        ]);
    }
}

