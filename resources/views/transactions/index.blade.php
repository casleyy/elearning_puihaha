@extends('layouts.members')

@section('title', 'Transactions')

@section('content')
    <section class="card">
        <div class="section-heading">
            <div><h1>Membership Transactions</h1><p class="muted">Applications, renewals, payment records, and current status.</p></div>
            <a class="button button-primary" href="{{ route('transactions.create') }}">New Transaction</a>
        </div>
    </section>
    <section class="card table-wrap">
        <table>
            <thead><tr><th>Reference</th><th>Member</th><th>Type</th><th>Amount</th><th>Status</th><th>Created</th><th></th></tr></thead>
            <tbody>
            @forelse ($transactions as $transaction)
                <tr>
                    <td><strong>{{ $transaction->reference_number }}</strong></td>
                    <td>{{ $transaction->member->name }}<span class="table-subtext">{{ $transaction->member->membership_number }}</span></td>
                    <td>{{ $transaction->type }}</td><td>₱{{ number_format((float) $transaction->amount, 2) }}</td>
                    <td><span class="status status-{{ strtolower($transaction->status) }}">{{ $transaction->status }}</span></td>
                    <td>{{ $transaction->created_at->format('M d, Y') }}</td>
                    <td><a class="button button-small button-light" href="{{ route('transactions.show', $transaction) }}">Open</a></td>
                </tr>
            @empty
                <tr><td colspan="7" class="empty-state">No transactions yet.</td></tr>
            @endforelse
            </tbody>
        </table>
        <div class="pagination">{{ $transactions->links() }}</div>
    </section>
@endsection
