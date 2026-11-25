@extends('layouts.members')

@section('title', 'Membership Categories')

@section('content')
    <section class="card">
        <h1>Membership Categories</h1>
        <p class="muted">Edit the existing categories. Categories cannot be added or deleted.</p>
    </section>

    <section class="card">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Members</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            <td><strong>{{ $category->name }}</strong></td>
                            <td>{{ $category->members_count }}</td>
                            <td>
                                <a class="button button-small button-light" href="{{ route('membership-categories.edit', $category) }}">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="empty-state">No categories found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection

