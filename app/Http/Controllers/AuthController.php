<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class AuthController extends Controller {

    public function showLogin() {
        return Inertia::render("Login", [
            "appName" => config("app.name"),
        ]);
    }

    public function showRegister() {
        return Inertia::render("Register", [
            "appName" => config("app.name"),
        ]);
    }

    public function login(Request $request) { }

    public function register(Request $request) {
        // Validates input
        $validated = $request->validate([
            "email" => ['required', 'email', 'max:255', 'unique:users'],
            "password" => ['required', 'required_with:passwordConfirmation', 'same:passwordConfirmation', 'string', 'min:8'],
            "passwordConfirmation" => ['required', 'string'],
        ]);

        // Creates user in the "user" database table
        $user = User::create($validated);

        // Logs in user after registration
        // Auth::login($user);

        // Redirects user to index
        return to_route('show.login')->with('message', 'success');
    }
}