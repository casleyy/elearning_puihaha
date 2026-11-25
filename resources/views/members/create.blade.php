@extends('layouts.members')

@section('title', 'Add Member')

@section('content')
    <section class="card form-card">
        <h1>Add New Member</h1>
        <p class="muted">The membership number will be generated automatically.</p>

        @include('members._form', [
            'formAction' => route('members.store'),
            'formMethod' => 'POST',
            'buttonText' => 'Add Member',
        ])
    </section>
@endsection

