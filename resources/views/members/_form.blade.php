<form action="{{ $formAction }}" method="POST" class="member-form">
    @csrf

    @if ($formMethod !== 'POST')
        @method($formMethod)
    @endif

    <label for="name">Full name</label>
    <input
        id="name"
        name="name"
        type="text"
        value="{{ old('name', $member->name) }}"
        required
        maxlength="255"
    >

    <label for="email">Email</label>
    <input
        id="email"
        name="email"
        type="email"
        value="{{ old('email', $member->email) }}"
        required
        maxlength="255"
    >

    <label for="phone">Phone</label>
    <input
        id="phone"
        name="phone"
        type="text"
        value="{{ old('phone', $member->phone) }}"
        maxlength="30"
    >

    <label for="address">Address</label>
    <textarea id="address" name="address" rows="3">{{ old('address', $member->address) }}</textarea>

    <label for="membership_category_id">Category</label>
    <select id="membership_category_id" name="membership_category_id" required>
        <option value="">Select a category</option>
        @foreach ($categories as $category)
            <option
                value="{{ $category->id }}"
                @selected((string) old('membership_category_id', $member->membership_category_id) === (string) $category->id)
            >
                {{ $category->name }}
            </option>
        @endforeach
    </select>

    <label for="membership_level_id">Membership level</label>
    <select id="membership_level_id" name="membership_level_id" required>
        <option value="">Select a level</option>
        @foreach ($levels as $level)
            <option
                value="{{ $level->id }}"
                @selected((string) old('membership_level_id', $member->membership_level_id) === (string) $level->id)
            >
                {{ $level->name }}
            </option>
        @endforeach
    </select>

    <div class="form-actions">
        <button class="button button-primary" type="submit">{{ $buttonText }}</button>
        <a class="button button-light" href="{{ route('members.index') }}">Cancel</a>
    </div>
</form>

