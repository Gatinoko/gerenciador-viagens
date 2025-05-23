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

    public function register(Request $request) { }
}