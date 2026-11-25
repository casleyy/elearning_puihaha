@extends('layouts.members')

@section('title', 'Membership Levels')

@section('content')
    <section class="card">
        <h1>Membership Levels</h1>
        <p class="muted">These fixed plans are available when registering a member.</p>
    </section>

    <section class="card">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Level</th>
                        <th>Fee</th>
                        <th>Validity</th>
                        <th>Benefits</th>
                        <th>Members</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($levels as $level)
                        <tr>
                            <td><strong>{{ $level->name }}</strong></td>
                            <td>
                                {{ $level->fee === null ? 'Not configured' : '₱' . number_format((float) $level->fee, 2) }}
                            </td>
                            <td>
                                {{ $level->validity_days === null ? 'Not configured' : $level->validity_days . ' days' }}
                            </td>
                            <td class="benefits-cell">
                                {{ $level->benefits ?: 'Not configured' }}
                            </td>
                            <td>{{ $level->members_count }}</td>
                            <td>
                                <div class="actions">
                                    <a
                                        class="button button-small button-light"
                                        href="{{ route('membership-levels.edit', $level) }}"
                                    >
                                        Edit details
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-state">No levels found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection

