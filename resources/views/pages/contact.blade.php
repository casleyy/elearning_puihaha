@extends('layouts.public')

@section('title', 'Contact | Puihaha E-Learning')

@section('content')
<main class="info-page contact-page">
    <p class="public-eyebrow">Get in touch</p>
    <h1>Contact Puihaha</h1>
    <p class="info-lead">Need help with your account or membership? Contact the Puihaha administrator using the contact details provided by your school or organization.</p>
    <div class="info-panel contact-panel">
        <h2>Account and membership support</h2>
        <p>For account access, membership records, payments, and transaction questions, please reach out to your platform administrator.</p>
        <a class="button button-primary" href="{{ route('login') }}">Go to Log In</a>
    </div>
</main>
@endsection
