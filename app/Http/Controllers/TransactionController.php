<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MembershipTransaction;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TransactionController extends Controller
{
    public function index(): View
    {
        $transactions = MembershipTransaction::with(['member', 'payments'])
            ->latest()
            ->paginate(15);

        return view('transactions.index', compact('transactions'));
    }

    public function create(Request $request): View
    {
        return view('transactions.create', [
            'members' => Member::with('level')->orderBy('name')->get(),
            'selectedMember' => $request->query('member_id'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'member_id' => ['required', 'exists:members,id'],
            'type' => ['required', Rule::in(['Application', 'Renewal'])],
        ]);

        $member = Member::with('level')->findOrFail($data['member_id']);

        if ($member->level->fee === null || $member->level->validity_days === null) {
            return back()
                ->withErrors(['member_id' => 'Set this membership level fee and validity period before creating a transaction.'])
                ->withInput();
        }

        if (
            $data['type'] === 'Application'
            && ($member->is_active || $member->transactions()->where('type', 'Application')->exists())
        ) {
            return back()
                ->withErrors(['member_id' => 'This member already has an application or an active membership. Choose Renewal instead.'])
                ->withInput();
        }

        $transaction = MembershipTransaction::create([
            'member_id' => $member->id,
            'reference_number' => $this->uniqueReference(),
            'type' => $data['type'],
            'status' => 'Pending',
            'amount' => $member->level->fee,
        ]);

        return redirect()
            ->route('transactions.show', $transaction)
            ->with('success', 'Transaction created. Record its payment when received.');
    }

    public function show(MembershipTransaction $transaction): View
    {
        $transaction->load(['member.category', 'member.level', 'payments']);

        return view('transactions.show', compact('transaction'));
    }

    public function approve(MembershipTransaction $transaction): RedirectResponse
    {
        abort_unless($transaction->status === 'Paid', 422, 'Only paid transactions may be approved.');

        DB::transaction(function () use ($transaction): void {
            $member = Member::query()
                ->lockForUpdate()
                ->findOrFail($transaction->member_id);

            $today = now()->startOfDay();
            $days = max(1, (int) $member->level->validity_days);

            if ($transaction->type === 'Renewal' && $member->membership_expires_at) {
                $expiryDate = Carbon::parse($member->membership_expires_at)->startOfDay();
                $start = $expiryDate->greaterThan($today) ? $expiryDate : $today;
            } else {
                $start = $today;
            }

            $end = $start->copy()->addDays($days);

            $member->update([
                'is_active' => true,
                'membership_expires_at' => $end->toDateString(),
            ]);

            $transaction->update([
                'status' => 'Approved',
                'period_starts_at' => $start->toDateString(),
                'period_ends_at' => $end->toDateString(),
            ]);
        });

        return redirect()
            ->route('transactions.show', $transaction)
            ->with('success', 'Transaction approved and membership validity updated.');
    }

    public function cancel(MembershipTransaction $transaction): RedirectResponse
    {
        abort_unless($transaction->status === 'Pending', 422, 'Only pending transactions can be cancelled.');

        $transaction->update(['status' => 'Cancelled']);

        return redirect()
            ->route('transactions.show', $transaction)
            ->with('success', 'Transaction cancelled.');
    }

    private function uniqueReference(): string
    {
        do {
            $reference = 'TXN-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6));
        } while (MembershipTransaction::where('reference_number', $reference)->exists());

        return $reference;
    }
}

