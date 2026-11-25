<?php

namespace App\Http\Controllers;

use App\Models\MembershipLevel;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MembershipLevelController extends Controller
{
    public function index(): View
    {
        $levels = MembershipLevel::withCount('members')
            ->orderBy('name')
            ->get();

        return view('membership-levels.index', compact('levels'));
    }

    public function edit(MembershipLevel $membershipLevel): View
    {
        return view('membership-levels.edit', [
            'level' => $membershipLevel,
        ]);
    }

    public function update(
        Request $request,
        MembershipLevel $membershipLevel
    ): RedirectResponse {
        $validated = $request->validate([
            'fee' => ['required', 'numeric', 'min:0'],
            'validity_days' => ['required', 'integer', 'min:1'],
            'benefits' => ['required', 'string', 'max:5000'],
        ]);

        $membershipLevel->update($validated);

        return redirect()
            ->route('membership-levels.index')
            ->with('success', 'Membership level details updated.');
    }
}

