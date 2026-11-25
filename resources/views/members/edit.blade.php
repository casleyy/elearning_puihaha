@extends('layouts.members')

@section('title', 'Edit Member')

@section('content')
    <section class="card form-card">
        <h1>Edit Member</h1>
        <p class="muted">Membership number: {{ $member->membership_number }}</p>

        @include('members._form', [
            'formAction' => route('members.update', $member),
            'formMethod' => 'PUT',
            'buttonText' => 'Save Changes',
        ])
    </section>
@endsection

