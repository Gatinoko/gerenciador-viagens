<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
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

    public function login(Request $request) {
        // Validates input
        $validated = $request->validate([
            "email" => ['required', 'email', 'max:255'],
            "password" => ['required', 'string'],
        ]);

        // Logs user in
        if (Auth::attempt($validated)) {
            // Regenerates session id for security
            $request->session()->regenerate();

            // Redirect user to X if successful, otherwise return error
            return to_route("show.dashboard");
        }

        throw ValidationException::withMessages([
            'credentials' => 'Incorrect credentials.'
        ]);
    }

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

    public function logout(Request $request) {
        // Logs out user
        Auth::logout();

        // Remove all data from the session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirects user to login page and flash message
        return to_route('show.login')->with('message', 'logged out');
    }
}