@extends('layouts.public')

@section('title', 'Register | Puihaha E-Learning')

@section('content')
<main class="auth-wrap">
    <section class="auth-card">
        <p class="public-eyebrow">Join Puihaha</p>
        <h1>Create Account</h1>
        <p class="auth-description">Create a learner account to get started.</p>
        @if ($errors->any())<div class="public-alert error-alert">{{ $errors->first() }}</div>@endif
        <form method="POST" action="{{ route('register.store') }}" class="auth-form">
            @csrf
            <label for="name">Name</label>
            <input id="name" name="name" value="{{ old('name') }}" autocomplete="name" required>
            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required>
            <label for="password">Password</label>
            <input id="password" name="password" type="password" autocomplete="new-password" required>
            <label for="password_confirmation">Confirm password</label>
            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required>
            <div class="auth-actions">
                <button class="button button-primary" type="submit">Create Account</button>
                <a class="button button-light" href="{{ route('home') }}">Back Home</a>
            </div>
        </form>
        <p class="auth-switch">Already registered? <a href="{{ route('login') }}">Log in</a></p>
    </section>
</main>
@endsection
