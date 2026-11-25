@extends('layouts.members')

@section('title', 'Edit Category')

@section('content')
    <section class="card form-card">
        <h1>Edit Category</h1>
        <p class="muted">Update the name of this existing category.</p>

        <form
            action="{{ route('membership-categories.update', $category) }}"
            method="POST"
            class="member-form"
        >
            @csrf
            @method('PUT')

            <label for="name">Category name</label>
            <input
                id="name"
                name="name"
                type="text"
                value="{{ old('name', $category->name) }}"
                required
                maxlength="100"
            >

            <div class="form-actions">
                <button class="button button-primary" type="submit">Save Changes</button>
                <a class="button button-light" href="{{ route('membership-categories.index') }}">
                    Cancel
                </a>
            </div>
        </form>
    </section>
@endsection

