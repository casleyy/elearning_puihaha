<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MembershipCategory;
use App\Models\MembershipLevel;
use App\Models\MembershipTransaction;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class MemberController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));
        $categoryId = $request->query('category_id');
        $levelId = $request->query('level_id');

        $members = Member::with(['category', 'level'])
            ->when($search !== '', function (Builder $query) use ($search): void {
                $query->where(function (Builder $searchQuery) use ($search): void {
                    $searchQuery
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('membership_number', 'like', "%{$search}%")
                        ->orWhereHas('category', function (Builder $categoryQuery) use ($search): void {
                            $categoryQuery->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('level', function (Builder $levelQuery) use ($search): void {
                            $levelQuery->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->when($categoryId, function (Builder $query) use ($categoryId): void {
                $query->where('membership_category_id', $categoryId);
            })
            ->when($levelId, function (Builder $query) use ($levelId): void {
                $query->where('membership_level_id', $levelId);
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('members.index', [
            'members' => $members,
            'categories' => MembershipCategory::orderBy('name')->get(),
            'levels' => MembershipLevel::orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        return view('members.create', [
            'member' => new Member(),
            'categories' => MembershipCategory::orderBy('name')->get(),
            'levels' => MembershipLevel::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:members,email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:2000'],
            'membership_category_id' => [
                'required',
                'exists:membership_categories,id',
            ],
            'membership_level_id' => [
                'required',
                'exists:membership_levels,id',
            ],
        ]);

        $level = MembershipLevel::findOrFail($validated['membership_level_id']);
        if ($level->fee === null || $level->validity_days === null) {
            return back()->withErrors(['membership_level_id' => 'Configure the selected level fee and validity period first.'])->withInput();
        }

        $transaction = DB::transaction(function () use ($validated, $level): MembershipTransaction {
            $validated['membership_number'] = $this->generateMembershipNumber();
            $validated['is_active'] = false;
            $member = Member::create($validated);

            return $member->transactions()->create([
                'reference_number' => $this->generateTransactionReference(),
                'type' => 'Application',
                'status' => 'Pending',
                'amount' => $level->fee,
            ]);
        });

        return redirect()->route('transactions.show', $transaction)
            ->with('success', 'Member registered. The application transaction is ready for payment.');
    }

    public function show(Member $member): View
    {
        $member->load(['category', 'level', 'transactions.payments']);

        return view('members.show', compact('member'));
    }

    public function edit(Member $member): View
    {
        return view('members.edit', [
            'member' => $member,
            'categories' => MembershipCategory::orderBy('name')->get(),
            'levels' => MembershipLevel::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Member $member): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('members', 'email')->ignore($member->id),
            ],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:2000'],
            'membership_category_id' => [
                'required',
                'exists:membership_categories,id',
            ],
            'membership_level_id' => [
                'required',
                'exists:membership_levels,id',
            ],
        ]);

        $member->update($validated);

        return redirect()
            ->route('members.show', $member)
            ->with('success', 'Member details updated.');
    }

    public function toggleStatus(Member $member): RedirectResponse
    {
        if (! $member->is_active) {
            return redirect()->route('members.show', $member)
                ->with('error', 'Reactivate through a paid and approved membership application or renewal.');
        }

        $member->update(['is_active' => false]);

        return redirect()
            ->route('members.index')
            ->with('success', 'Member deactivated.');
    }

    private function generateMembershipNumber(): string
    {
        do {
            $membershipNumber = 'MEM-' . Str::upper(Str::random(8));
        } while (Member::where('membership_number', $membershipNumber)->exists());

        return $membershipNumber;
    }

    private function generateTransactionReference(): string
    {
        do {
            $reference = 'TXN-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6));
        } while (MembershipTransaction::where('reference_number', $reference)->exists());

        return $reference;
    }
}

