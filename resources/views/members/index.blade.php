@extends('layouts.members')

@section('title', 'Members')

@section('content')
    <section class="card">
        <div class="section-heading">
            <div>
                <h1>Members</h1>
                <p class="muted">Search by name, category, or membership level.</p>
            </div>
            <a class="button button-primary" href="{{ route('members.create') }}">Add Member</a>
        </div>

        <form method="GET" action="{{ route('members.index') }}" class="search-form">
            <label>
                <span>Search</span>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Name, category, level, or member number"
                >
            </label>

            <label>
                <span>Category</span>
                <select name="category_id">
                    <option value="">All categories</option>
                    @foreach ($categories as $category)
                        <option
                            value="{{ $category->id }}"
                            @selected((string) request('category_id') === (string) $category->id)
                        >
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </label>

            <label>
                <span>Level</span>
                <select name="level_id">
                    <option value="">All levels</option>
                    @foreach ($levels as $level)
                        <option
                            value="{{ $level->id }}"
                            @selected((string) request('level_id') === (string) $level->id)
                        >
                            {{ $level->name }}
                        </option>
                    @endforeach
                </select>
            </label>

            <div class="search-actions">
                <button class="button button-primary" type="submit">Search</button>
                <a class="button button-light" href="{{ route('members.index') }}">Clear</a>
            </div>
        </form>
    </section>

    <section class="card">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Member</th>
                        <th>Category</th>
                        <th>Level</th>
                        <th>Status</th>
                        <th class="actions-column">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($members as $member)
                        <tr>
                            <td>
                                <strong>{{ $member->name }}</strong>
                                <span class="table-subtext">{{ $member->membership_number }}</span>
                                <span class="table-subtext">{{ $member->email }}</span>
                            </td>
                            <td>{{ $member->category->name }}</td>
                            <td>{{ $member->level->name }}</td>
                            <td>
                                @if ($member->is_active)
                                    <span class="status status-active">Active</span>
                                @else
                                    <span class="status status-inactive">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="actions">
                                    <a class="button button-small button-light" href="{{ route('members.show', $member) }}">
                                        Profile
                                    </a>
                                    <a class="button button-small button-light" href="{{ route('members.edit', $member) }}">
                                        Edit
                                    </a>

                                    @if ($member->is_active)
                                        <form method="POST" action="{{ route('members.status', $member) }}" class="inline-form">
                                            @csrf
                                            @method('PATCH')
                                            <button class="button button-small button-danger" type="submit">Deactivate</button>
                                        </form>
                                    @else
                                        <a class="button button-small button-primary" href="{{ route('members.show', $member) }}">
                                            Renew / Reactivate
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty-state">No members match your search.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination">
            {{ $members->links() }}
        </div>
    </section>
@endsection

