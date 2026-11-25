@extends('layouts.members')

@section('title', 'Admin Dashboard | Puihaha')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush

@section('content')
<section class="card dashboard-heading">
    <div>
        <p class="eyebrow">Administration</p>
        <h1>Dashboard</h1>
        <p class="muted">Membership and transaction overview.</p>
    </div>
    <a class="button button-primary" href="{{ route('members.create') }}">Add Member</a>
</section>

<section class="dashboard-stats">
    <article class="dashboard-stat">
        <span>Total Members</span>
        <strong>{{ $totalMembers }}</strong>
        <a href="{{ route('members.index') }}">View members</a>
    </article>
    <article class="dashboard-stat">
        <span>Active Members</span>
        <strong>{{ $activeMembers }}</strong>
        <a href="{{ route('members.index') }}">Manage members</a>
    </article>
    <article class="dashboard-stat">
        <span>Pending Transactions</span>
        <strong>{{ $pendingTransactions }}</strong>
        <a href="{{ route('transactions.index') }}">Review transactions</a>
    </article>
    <article class="dashboard-stat">
        <span>Collected Payments</span>
        <strong>₱{{ number_format((float) $collectedPayments, 2) }}</strong>
        <a href="{{ route('transactions.index') }}">View payments</a>
    </article>
</section>

<section class="card quick-actions-card">
    <div class="dashboard-section-title">
        <div>
            <p class="eyebrow">Shortcuts</p>
            <h2>Quick Actions</h2>
        </div>
    </div>

    <div class="quick-actions">
        <a href="{{ route('members.create') }}">
            <span>＋</span>
            <strong>Add a Member</strong>
            <small>Register a new member</small>
        </a>
        <a href="{{ route('transactions.create') }}">
            <span>＋</span>
            <strong>New Transaction</strong>
            <small>Create an application or renewal</small>
        </a>
        <a href="{{ route('membership-categories.index') }}">
            <span>▤</span>
            <strong>Categories</strong>
            <small>View membership categories</small>
        </a>
        <a href="{{ route('membership-levels.index') }}">
            <span>☆</span>
            <strong>Membership Levels</strong>
            <small>Review fees and benefits</small>
        </a>
    </div>
</section>

<section class="dashboard-charts">
    <article class="card chart-card">
        <div class="dashboard-section-title">
            <div>
                <p class="eyebrow">Transactions</p>
                <h2>Transaction Status</h2>
            </div>
        </div>

        <div class="bar-chart" role="img" aria-label="Counts of transactions by status">
            @foreach ($transactionStatuses as $status => $count)
                <div class="bar-row">
                    <div class="bar-label">
                        <span>{{ $status }}</span>
                        <strong>{{ $count }}</strong>
                    </div>
                    <div class="bar-track">
                        <span
                            class="bar-fill status-{{ strtolower($status) }}"
                            style="width: {{ $count > 0 ? max(5, ($count / $maxTransactionsByStatus) * 100) : 0 }}%"
                        ></span>
                    </div>
                </div>
            @endforeach
        </div>
    </article>

    <article class="card chart-card">
        <div class="dashboard-section-title">
            <div>
                <p class="eyebrow">Membership</p>
                <h2>Members by Level</h2>
            </div>
        </div>

        @if ($membersByLevel->isEmpty())
            <p class="muted">No membership levels are available.</p>
        @else
            <div class="bar-chart" role="img" aria-label="Counts of members by membership level">
                @foreach ($membersByLevel as $level)
                    <div class="bar-row">
                        <div class="bar-label">
                            <span>{{ $level->name }}</span>
                            <strong>{{ $level->members_count }}</strong>
                        </div>
                        <div class="bar-track">
                            <span
                                class="bar-fill level-fill"
                                style="width: {{ $level->members_count > 0 ? max(5, ($level->members_count / $maxMembersByLevel) * 100) : 0 }}%"
                            ></span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </article>
</section>

<section class="card">
    <div class="dashboard-section-title">
        <div>
            <p class="eyebrow">Latest activity</p>
            <h2>Recent Transactions</h2>
        </div>
        <a class="button button-light" href="{{ route('transactions.index') }}">View Transactions</a>
    </div>

    @if ($recentTransactions->isEmpty())
        <p class="muted">There are no transactions yet.</p>
    @else
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Reference</th>
                        <th>Member</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recentTransactions as $transaction)
                        <tr>
                            <td>{{ $transaction->reference_number }}</td>
                            <td>{{ $transaction->member?->name ?? 'Member unavailable' }}</td>
                            <td>{{ $transaction->type }}</td>
                            <td>
                                <span class="dashboard-status status-{{ strtolower($transaction->status) }}">
                                    {{ $transaction->status }}
                                </span>
                            </td>
                            <td>₱{{ number_format((float) $transaction->amount, 2) }}</td>
                            <td>
                                <a class="button button-small button-light" href="{{ route('transactions.show', $transaction) }}">
                                    Open
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</section>
@endsection

