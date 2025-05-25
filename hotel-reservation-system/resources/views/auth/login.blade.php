@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Login</h2>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role" class="form-control" id="role-select">
                <option value="customer">Customer</option>
                <option value="clerk">Clerk</option>
                <option value="manager">Manager</option>
            </select>
        </div>
        <div class="mb-3" id="branch-selection" style="display:none;">
            <label class="form-label">Branch</label>
            <select name="branch_id" class="form-control">
                @foreach($branches as $branch)
                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
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
        document.getElementById('branch-selection').style.display = this.value === 'customer' ? 'none' : 'block';
    });
</script>
@endsection