<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /**
     * Show the registration form
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle registration request
     */
    public function register(Request $request)
    {
        // Validation
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        // Create user (DEFAULT ROLE: staff)
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => 'staff', // 🔐 AMAN
            'password' => Hash::make($validated['password']),
        ]);

        // ❌ TIDAK auto login
        return redirect()->route('login')
            ->with('success', 'Registrasi berhasil. Silakan login.');
    }
}