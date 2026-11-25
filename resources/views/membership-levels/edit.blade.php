@extends('layouts.members')

@section('title', 'Edit Membership Level')

@section('content')
    <section class="card form-card">
        <h1>Edit {{ $level->name }} Details</h1>
        <p class="muted">The level name is fixed. Update its fee, validity, and benefits.</p>

        <form action="{{ route('membership-levels.update', $level) }}"
              method="POST"
              class="member-form">
            @csrf
            @method('PUT')

            <label for="fee">Fee</label>
            <input id="fee" name="fee" type="number"
                   value="{{ old('fee', $level->fee) }}"
                   min="0" step="0.01" required>

            <label for="validity_days">Validity period in days</label>
            <input id="validity_days" name="validity_days" type="number"
                   value="{{ old('validity_days', $level->validity_days) }}"
                   min="1" step="1" required>

            <label for="benefits">Benefits</label>
            <textarea id="benefits" name="benefits" rows="4"
                      maxlength="5000" required>{{ old('benefits', $level->benefits) }}</textarea>

            <div class="form-actions">
                <button class="button button-primary" type="submit">Save Details</button>
                <a class="button button-light" href="{{ route('membership-levels.index') }}">Cancel</a>
            </div>
        </form>
    </section>
@endsection

