@extends('layouts.public')

@section('title', 'Log In | Puihaha E-Learning')

@section('content')
<main class="auth-wrap">
    <section class="auth-card">
        <p class="public-eyebrow">Puihaha account</p>
        <h1>Log In</h1>
        <p class="auth-description">Sign in to continue.</p>
        @if (session('status'))<div class="public-alert success-alert">{{ session('status') }}</div>@endif
        @if ($errors->any())<div class="public-alert error-alert">{{ $errors->first() }}</div>@endif
        <form method="POST" action="{{ route('login.store') }}" class="auth-form">
            @csrf
            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required autofocus>
            <label for="password">Password</label>
            <input id="password" name="password" type="password" autocomplete="current-password" required>
            <div class="auth-options">
                <label class="remember-option" for="remember">
                    <input id="remember" name="remember" type="checkbox" value="1" @checked(old('remember'))>
                    <span>Remember me</span>
                </label>
            </div>
            <div class="auth-actions">
                <button class="button button-primary" type="submit">Log In</button>
                <a class="button button-light" href="{{ route('home') }}">Back Home</a>
            </div>
        </form>
        <p class="auth-switch">Don't have an account? <a href="{{ route('register') }}">Register</a></p>
    </section>
</main>
@endsection
