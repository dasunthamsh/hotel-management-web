<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        $branches = Branch::all();
        return view('auth.login', compact('branches'));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required|in:customer,clerk,manager',
            'branch_id' => 'required_if:role,clerk,manager|exists:branches,id'
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            if ($user->role === 'clerk' || $user->role === 'manager') {
                if ($user->branch_id != $request->branch_id) {
                    Auth::logout();
                    return back()->withErrors(['branch_id' => 'Invalid branch selection']);
                }
            }
            return redirect()->route('dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',
            'nationality' => 'required|string',
            'contact_number' => 'required|string'
        ]);

        $data['role'] = 'customer';
        $data['password'] = bcrypt($data['password']);
        User::create($data);

        return redirect()->route('login')->with('success', 'Registration successful');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}