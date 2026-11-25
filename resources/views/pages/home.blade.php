@extends('layouts.public')

@section('title', 'Home | Puihaha E-Learning')

@section('content')
<main class="hero-section">
    <div class="hero-copy">
        <p class="public-eyebrow">Learn and grow with Puihaha</p>
        <h1>Make learning<br><span>work for you.</span></h1>
        <p class="hero-description">Puihaha E-Learning helps learners explore courses, build skills, and keep moving toward their goals.</p>
        <div class="hero-actions">
            <a class="button button-primary" href="{{ route('register') }}">Create an Account</a>
            <a class="text-link" href="{{ route('about') }}">Learn About Us</a>
        </div>
    </div>
    <div class="hero-art" aria-label="Learning illustration">
        <div class="art-circle"></div>
        <div class="art-card art-card-back"></div>
        <div class="art-card art-card-front">
            <span class="art-icon">✦</span>
            <span class="art-line art-line-long"></span>
            <span class="art-line"></span>
            <span class="art-progress"><i></i></span>
            <small>YOUR NEXT CHAPTER</small>
        </div>
        <span class="art-dot art-dot-one"></span>
        <span class="art-dot art-dot-two"></span>
    </div>
</main>

<section class="home-services">
    <div class="section-intro">
        <p class="public-eyebrow">What you can do</p>
        <h2>Learning support in one place</h2>
    </div>
    <div class="service-grid">
        <article class="service-card"><span>01</span><h3>Explore learning</h3><p>Find learning opportunities and resources that support your goals.</p></article>
        <article class="service-card"><span>02</span><h3>Build your skills</h3><p>Keep track of your learning and take the next step at your own pace.</p></article>
        <article class="service-card"><span>03</span><h3>Membership support</h3><p>Membership records and payments are managed by authorized administrators.</p></article>
    </div>
</section>
@endsection
