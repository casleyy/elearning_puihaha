@extends('layouts.members')

@section('title', 'Transaction ' . $transaction->reference_number)

@section('content')
    <section class="card transaction-receipt">
        <div class="section-heading">
            <div><p class="eyebrow">Transaction record</p><h1>{{ $transaction->reference_number }}</h1><p class="muted">{{ $transaction->type }} · {{ $transaction->created_at->format('M d, Y h:i A') }}</p></div>
            <span class="status status-{{ strtolower($transaction->status) }}">{{ $transaction->status }}</span>
        </div>
        <dl class="profile-details">
            <div><dt>Member</dt><dd><a href="{{ route('members.show', $transaction->member) }}">{{ $transaction->member->name }}</a><br>{{ $transaction->member->membership_number }}</dd></div>
            <div><dt>Membership</dt><dd>{{ $transaction->member->category->name }} · {{ $transaction->member->level->name }}</dd></div>
            <div><dt>Amount due</dt><dd>₱{{ number_format((float) $transaction->amount, 2) }}</dd></div>
            <div><dt>Membership period</dt><dd>@if ($transaction->period_starts_at) {{ $transaction->period_starts_at->format('M d, Y') }} to {{ $transaction->period_ends_at->format('M d, Y') }} @else Not yet approved @endif</dd></div>
        </dl>
        <div class="form-actions no-print">
            <a class="button button-light" href="{{ route('transactions.index') }}">All Transactions</a>
            <button class="button button-light" type="button" onclick="window.print()">Print Receipt</button>
            @if ($transaction->status === 'Paid')
                <form method="POST" action="{{ route('transactions.approve', $transaction) }}">@csrf @method('PATCH')<button class="button button-primary" type="submit">Approve</button></form>
            @endif
            @if ($transaction->status === 'Pending')
                <form method="POST" action="{{ route('transactions.cancel', $transaction) }}">@csrf @method('PATCH')<button class="button button-danger" type="submit">Cancel</button></form>
            @endif
        </div>
    </section>

    <section class="card no-print">
        <h2>Payment History</h2>
        @if ($transaction->payments->isNotEmpty())
            <div class="table-wrap"><table><thead><tr><th>Payment Ref.</th><th>Amount</th><th>Method</th><th>Paid at</th><th>Notes</th></tr></thead><tbody>
            @foreach ($transaction->payments as $payment)
                <tr><td>{{ $payment->payment_reference }}</td><td>₱{{ number_format((float) $payment->amount, 2) }}</td><td>{{ $payment->method }}</td><td>{{ $payment->paid_at->format('M d, Y h:i A') }}</td><td>{{ $payment->notes ?: '—' }}</td></tr>
            @endforeach
            </tbody></table></div>
        @else
            <p class="muted">No payment recorded.</p>
        @endif
    </section>

    @if ($transaction->status === 'Pending')
        <section class="card no-print">
            <h2>Record Payment</h2>
            <p class="muted">For this simple classroom workflow, record one full payment matching the amount due.</p>
            <form method="POST" action="{{ route('transactions.payments.store', $transaction) }}" class="member-form">
                @csrf
                <label for="amount">Amount (₱)</label><input id="amount" name="amount" type="number" min="0.01" step="0.01" value="{{ old('amount', $transaction->amount) }}" required>
                <label for="method">Payment method</label><select id="method" name="method" required><option value="Cash">Cash</option><option value="Bank Transfer">Bank Transfer</option><option value="GCash">GCash</option><option value="Card">Card</option></select>
                <label for="notes">Notes (optional)</label><textarea id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                <div class="form-actions"><button class="button button-primary" type="submit">Save Payment</button></div>
            </form>
        </section>
    @endif
@endsection
