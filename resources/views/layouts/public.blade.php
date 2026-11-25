<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Puihaha E-Learning')</title>
    <link rel="stylesheet" href="{{ asset('css/members.css') }}">
    <link rel="stylesheet" href="{{ asset('css/public.css') }}">
</head>
<body class="public-body">
    <div class="public-shell">
        <header class="public-header">
            <a class="public-brand" href="{{ route('home') }}">PUIHAHA <span>E-Learning</span></a>
            <nav class="public-nav">
                <a href="{{ route('home') }}">Home</a>
                <a href="{{ route('about') }}">About</a>
                <a href="{{ route('services') }}">Services</a>
                <a href="{{ route('contact') }}">Contact</a>
                <a href="{{ route('dashboard.access') }}">Dashboard</a>
            </nav>
            <div class="public-account">
                @auth
                    <span class="account-name">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="button button-light" type="submit">Log Out</button>
                    </form>
                @else
                    <a class="button button-light" href="{{ route('login') }}">Log In</a>
                    <a class="button button-primary" href="{{ route('register') }}">Register</a>
                @endauth
            </div>
        </header>

        @if (session('success'))
            <div class="public-alert success-alert">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="public-alert error-alert">{{ session('error') }}</div>
        @endif

        @yield('content')

        <footer class="public-footer">
            <span>© {{ date('Y') }} Puihaha E-Learning</span>
            <div><a href="{{ route('about') }}">About</a><a href="{{ route('services') }}">Services</a><a href="{{ route('contact') }}">Contact</a></div>
        </footer>
    </div>
</body>
</html>
