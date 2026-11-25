@extends('layouts.members')

@section('title', 'Member Profile')

@section('content')
    <section class="card profile-card">
        <div class="section-heading">
            <div>
                <p class="eyebrow">Member profile</p>
                <h1>{{ $member->name }}</h1>
                <p class="muted">{{ $member->membership_number }}</p>
            </div>

            @if ($member->is_active)
                <span class="status status-active">Active</span>
            @else
                <span class="status status-inactive">Inactive</span>
            @endif
        </div>

        <dl class="profile-details">
            <div>
                <dt>Email</dt>
                <dd>{{ $member->email }}</dd>
            </div>
            <div>
                <dt>Phone</dt>
                <dd>{{ $member->phone ?: 'Not provided' }}</dd>
            </div>
            <div>
                <dt>Address</dt>
                <dd>{{ $member->address ?: 'Not provided' }}</dd>
            </div>
            <div>
                <dt>Category</dt>
                <dd>{{ $member->category->name }}</dd>
            </div>
            <div>
                <dt>Membership level</dt>
                <dd>{{ $member->level->name }}</dd>
            </div>
            <div>
                <dt>Membership expires</dt>
                <dd>{{ $member->membership_expires_at?->format('M d, Y') ?? 'Not yet set' }}</dd>
            </div>
        </dl>

        <div class="form-actions">
            <a class="button button-primary" href="{{ route('members.edit', $member) }}">
                Edit Member
            </a>
            <a class="button button-primary" href="{{ route('transactions.create', ['member_id' => $member->id]) }}">
                New Application / Renewal
            </a>
            <a class="button button-light" href="{{ route('members.index') }}">
                Back to Members
            </a>
        </div>
    </section>

    <section class="card">
        <div class="section-heading"><h2>Transaction History</h2></div>
        <div class="table-wrap"><table>
            <thead><tr><th>Reference</th><th>Type</th><th>Amount</th><th>Status</th><th>Date</th><th></th></tr></thead>
            <tbody>
            @forelse ($member->transactions->sortByDesc('created_at') as $transaction)
                <tr><td>{{ $transaction->reference_number }}</td><td>{{ $transaction->type }}</td><td>₱{{ number_format((float) $transaction->amount, 2) }}</td><td><span class="status status-{{ strtolower($transaction->status) }}">{{ $transaction->status }}</span></td><td>{{ $transaction->created_at->format('M d, Y') }}</td><td><a class="button button-small button-light" href="{{ route('transactions.show', $transaction) }}">View receipt</a></td></tr>
            @empty
                <tr><td colspan="6" class="empty-state">No transaction history yet.</td></tr>
            @endforelse
            </tbody>
        </table></div>
    </section>
@endsection

