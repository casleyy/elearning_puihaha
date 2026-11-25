<?php

namespace App\Http\Controllers;

use App\Models\MembershipCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = MembershipCategory::withCount('members')
            ->orderBy('name')
            ->get();

        return view('membership-categories.index', compact('categories'));
    }

    public function edit(MembershipCategory $membershipCategory): View
    {
        return view('membership-categories.edit', [
            'category' => $membershipCategory,
        ]);
    }

    public function update(Request $request, MembershipCategory $membershipCategory): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('membership_categories', 'name')->ignore($membershipCategory->id),
            ],
        ]);

        $membershipCategory->update($validated);

        return redirect()
            ->route('membership-categories.index')
            ->with('success', 'Category updated successfully.');
    }
}

