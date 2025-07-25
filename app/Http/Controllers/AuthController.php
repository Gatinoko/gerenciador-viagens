<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;

class AuthController {

    public function login(Request $request) {
        // Validates input
        $validated = $request->validate([
            "email" => ['required', 'email', 'max:255'],
            "password" => ['required', 'string'],
        ]);

        // Attempts to log user in
        $token = Auth::attempt($validated);

        // If login attempt fails, return appropriate error message
        if (!$token) {
            throw ValidationException::withMessages([
                'wrongCredentialsError' => 'Email ou senha incorretos'
            ]);
        }

        // If login attempt succeeds, creates token cookie
        $cookie = cookie(
            'token',
            $token,
            60, // Minutes
            null,
            null, // Secure
            null, // HTTP only
            false, // Raw
            'Strict' // SameSite
        );

        // Redirects user to dashboard page with cookie
        return to_route("show.dashboard")->withCookie($cookie)->with(
            'toast',
            [
                'type' => 'success',
                'message' => 'Usuário logado com sucesso'
            ]
        );
    }

    public function register(Request $request) {
        // Validates input
        $request->validate([
            "name" => ['required', 'string', 'max:64'],
            "email" => ['required', 'email', 'max:255', 'unique:users'],
            "password" => ['required', 'required_with:passwordConfirmation', 'same:passwordConfirmation', 'string', 'min:8'],
            "passwordConfirmation" => ['required', 'string'],
        ]);

        // Creates user in the "user" database table
        User::create([
            "name" => $request->name,
            'email' => $request->email,
            'role' => 'user',
            'password' => Hash::make($request->password),
        ]);

        // Redirects user to index with success message
        return to_route('show.login')->with(
            'toast',
            [
                'type' => 'success',
                'message' => 'Usuário registrado com sucesso'
            ]
        );
    }

    public function logout(Request $request) {
        // Logs out user
        Auth::logout();

        // Forgets the token cookie
        Cookie::forget('token');

        // Redirects user to login and flashes logout message
        return to_route('show.login')->with(
            'toast',
            [
                'type' => 'success',
                'message' => 'Usuário deslogado com sucesso'
            ]
        );
    }
}