@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Login</h2>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role" class="form-control" id="role-select" required>
                <option value="">Select Role</option>
                <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>Customer</option>
                <option value="clerk" {{ old('role') == 'clerk' ? 'selected' : '' }}>Clerk</option>
                <option value="manager" {{ old('role') == 'manager' ? 'selected' : '' }}>Manager</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            @error('role') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3" id="branch-selection" style="display:none;">
            <label class="form-label">Branch</label>
            <select name="branch_id" id="branch_id" class="form-control">
                <option value="">Select Branch</option>
                @foreach($branches as $branch)
                    <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                @endforeach
            </select>
            @error('branch_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
    <a href="{{ route('register') }}" class="mt-3 d-block">Register as Customer</a>
</div>
<script>
    document.getElementById('role-select').addEventListener('change', function() {
        const branchSelection = document.getElementById('branch-selection');
        const branchId = document.getElementById('branch_id');
        if (this.value === 'clerk' || this.value === 'manager') {
            branchSelection.style.display = 'block';
            branchId.required = true;
        } else {
            branchSelection.style.display = 'none';
            branchId.required = false;
            branchId.value = ''; // Clear branch_id value for customer/admin
        }
    });
    // Trigger change event on page load to set initial state
    document.getElementById('role-select').dispatchEvent(new Event('change'));
</script>
@endsection