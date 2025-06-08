@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Register</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="nationality" class="form-label">Nationality</label>
            <select name="nationality" id="nationality" class="form-control" required>
                <option value="">Select a nationality</option>
                @foreach ($countries as $country)
                    <option value="{{ $country['name'] }}" data-phone-code="{{ $country['phone_code'] }}"
                        {{ old('nationality') == $country['name'] ? 'selected' : '' }}>
                        {{ $country['name'] }}
                    </option>
                @endforeach
            </select>
            @error('nationality') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label for="contact_number" class="form-label">Contact Number</label>
            <div class="input-group">
                <span class="input-group-text" id="country-code"></span>
                <input type="text" name="contact_number" id="contact_number" class="form-control" value="{{ old('contact_number') }}" required>
            </div>
            @error('contact_number') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</div>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Initialize Select2
    $('#nationality').select2({
        placeholder: 'Select a nationality',
        allowClear: true,
        width: '100%'
    });

    // Update country code on nationality change
    $('#nationality').on('change', function() {
        const phoneCode = $(this).find(':selected').data('phone-code') || '';
        $('#country-code').text(phoneCode);
        const contactNumber = $('#contact_number').val();
        const currentCode = $('#country-code').data('current-code') || '';
        if (!contactNumber || contactNumber.startsWith(currentCode)) {
            $('#contact_number').val(phoneCode);
        }
        $('#country-code').data('current-code', phoneCode);
    });

    // Trigger change on page load
    $('#nationality').trigger('change');
});
</script>
@endsection