<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Форма регистрации
    public function showRegisterForm()
    {
        return view('register');
    }

    // Обработка регистрации
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'phone' => 'required|string',
            'driver_license' => 'required|string|max:50',
            'password' => 'required|string|min:3|confirmed',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'driver_license' => $validated['driver_license'],
            'password' => Hash::make($validated['password']),
            'role_id' => 2, // Обычный пользователь
        ]);

        return redirect()->route('login')->with('success', 'Регистрация успешна!');
    }

    // Форма входа
    public function showLoginForm()
    {
        return view('login');
    }

    // Обработка входа
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Неверные учетные данные',
        ]);
    }

    // Выход
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}