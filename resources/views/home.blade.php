<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/members.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <title>Puihaha E-Learning Platform</title>
</head>
<body>
    <header class="site-header" id="home">
        <a class="brand" href="{{ route('home') }}">Puihaha</a>

        <nav class="site-nav">
            <a href="#home">Home</a>
            <a href="#about">About</a>
            <a href="#services">Services</a>
        </nav>

        <div class="site-actions">
            @auth
                @if (auth()->user()->isAdmin())
                    <a class="button button-primary" href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
                @else
                    <span class="user-label">Signed in as {{ auth()->user()->name }}</span>
                @endif

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="button button-light" type="submit">Log Out</button>
                </form>
            @else
                <a class="button button-light" href="{{ route('login') }}">Log In</a>
                <a class="button button-primary" href="{{ route('register') }}">Register</a>
            @endauth
        </div>
    </header>

    <main>
        @if (session('success'))
            <div class="container"><div class="alert alert-success">{{ session('success') }}</div></div>
        @endif

        @if (session('error'))
            <div class="container"><div class="alert alert-error">{{ session('error') }}</div></div>
        @endif

        <section class="hero">
            <div class="hero-content">
                <p class="eyebrow">Membership Management and Transaction Processing</p>
                <h1>Learning memberships, managed in one place.</h1>
                <p class="hero-text">
                    Puihaha helps administrators manage member records, membership plans,
                    applications, renewals, and payments.
                </p>

                <div class="hero-actions">
                    @auth
                        @if (auth()->user()->isAdmin())
                            <a class="button button-primary" href="{{ route('admin.dashboard') }}">Open Admin Dashboard</a>
                        @else
                            <p class="access-message">Your account is registered, but the admin dashboard is restricted to administrators.</p>
                        @endif
                    @else
                        <a class="button button-primary" href="{{ route('login') }}">Admin Log In</a>
                        <a class="button button-light" href="{{ route('register') }}">Create an Account</a>
                    @endauth
                </div>
            </div>

            <div class="hero-panel">
                <p class="eyebrow">Puihaha system</p>
                <div class="hero-panel-item"><span>01</span><strong>Member records</strong></div>
                <div class="hero-panel-item"><span>02</span><strong>Membership plans</strong></div>
                <div class="hero-panel-item"><span>03</span><strong>Applications and payments</strong></div>
            </div>
        </section>

        <section class="home-section container" id="about">
            <p class="eyebrow">About</p>
            <h2>One workspace for membership administration.</h2>
            <p>
                Puihaha keeps member information and membership transactions organized,
                so administrators can review applications, record payments, and track membership status.
            </p>
        </section>

        <section class="home-section home-section-soft" id="services">
            <div class="container">
                <p class="eyebrow">Services</p>
                <h2>What the system helps manage</h2>
                <div class="service-grid">
                    <article class="service-card">
                        <h3>Member records</h3>
                        <p>Register, search, view, edit, and deactivate member records.</p>
                    </article>
                    <article class="service-card">
                        <h3>Membership plans</h3>
                        <p>Review fixed membership levels, fees, validity periods, and benefits.</p>
                    </article>
                    <article class="service-card">
                        <h3>Transactions</h3>
                        <p>Track applications, renewals, payment records, and transaction status.</p>
                    </article>
                </div>
            </div>
        </section>
    </main>
</body>
</html>

