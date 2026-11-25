@extends('layouts.public')

@section('title', 'Reset Password | Puihaha E-Learning')

@section('content')
<main class="auth-wrap">
    <section class="auth-card">
        <p class="public-eyebrow">Account recovery</p>
        <h1>Set a New Password</h1>
        @if ($errors->any())<div class="public-alert error-alert">{{ $errors->first() }}</div>@endif
        <form method="POST" action="{{ route('password.update') }}" class="auth-form">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email', $email) }}" autocomplete="email" required>
            <label for="password">New password</label>
            <input id="password" name="password" type="password" autocomplete="new-password" required>
            <label for="password_confirmation">Confirm new password</label>
            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required>
            <button class="button button-primary" type="submit">Reset Password</button>
        </form>
    </section>
</main>
@endsection
