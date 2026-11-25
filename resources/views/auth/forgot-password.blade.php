@extends('layouts.public')

@section('title', 'Forgot Password | Puihaha E-Learning')

@section('content')
<main class="auth-wrap">
    <section class="auth-card">
        <p class="public-eyebrow">Account recovery</p>
        <h1>Forgot Password?</h1>
        <p class="auth-description">Enter your email and we will send a password reset link.</p>
        @if (session('status'))<div class="public-alert success-alert">{{ session('status') }}</div>@endif
        @if ($errors->any())<div class="public-alert error-alert">{{ $errors->first() }}</div>@endif
        <form method="POST" action="{{ route('password.email') }}" class="auth-form">
            @csrf
            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required autofocus>
            <div class="auth-actions">
                <button class="button button-primary" type="submit">Send Reset Link</button>
                <a class="button button-light" href="{{ route('login') }}">Back to Log In</a>
            </div>
        </form>
    </section>
</main>
@endsection
