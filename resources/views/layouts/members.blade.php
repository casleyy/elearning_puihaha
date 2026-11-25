<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/members.css') }}">
    @stack('styles')
    <title>@yield('title', 'Member Management')</title>
</head>
<body>
    <main class="container">
        <header class="page-header">
            <a class="brand" href="{{ route('admin.dashboard') }}">Puihaha Admin</a>

            <nav class="main-nav">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                <a href="{{ route('members.index') }}">Members</a>
                <a href="{{ route('membership-categories.index') }}">Categories</a>
                <a href="{{ route('membership-levels.index') }}">Levels</a>
                <a href="{{ route('transactions.index') }}">Transactions</a>
            </nav>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="button button-light" type="submit">Log Out</button>
            </form>
        </header>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                <strong>Please fix the following:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>

