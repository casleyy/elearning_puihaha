@extends('layouts.members')

@section('title', 'New Transaction')

@section('content')
    <section class="card form-card">
        <h1>Create Membership Transaction</h1>
        <p class="muted">The transaction amount is copied from the member's current membership level.</p>
        <form method="POST" action="{{ route('transactions.store') }}" class="member-form">
            @csrf
            <label for="member_id">Member</label>
            <select id="member_id" name="member_id" required>
                <option value="">Choose a member</option>
                @foreach ($members as $member)
                    <option value="{{ $member->id }}" @selected((string) old('member_id', $selectedMember) === (string) $member->id)>
                        {{ $member->name }} — {{ $member->membership_number }} ({{ $member->level->name }}, ₱{{ number_format((float) $member->level->fee, 2) }})
                    </option>
                @endforeach
            </select>
            <label for="type">Transaction type</label>
            <select id="type" name="type" required>
                <option value="Application" @selected(old('type') === 'Application')>Application</option>
                <option value="Renewal" @selected(old('type') === 'Renewal')>Renewal</option>
            </select>
            <p class="muted">After creating this transaction, open it to record payment. The status only becomes Approved after payment is recorded.</p>
            <div class="form-actions"><button class="button button-primary" type="submit">Create Transaction</button><a class="button button-light" href="{{ route('transactions.index') }}">Cancel</a></div>
        </form>
    </section>
@endsection
