<?php

use App\Http\Controllers\AuthController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Inertia::render('Index', [
        'appName' => config('app.name'),
    ]);
})->name("show.index");

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard', [
        'appName' => config('app.name'),
    ]);
})->name("show.dashboard");

Route::get('/login', [AuthController::class, 'showLogin'])->name("show.login");
Route::get('/register', [AuthController::class, "showRegister"])->name("show.register");
Route::post('/login', [AuthController::class, 'login'])->name("login");
Route::post('/register', [AuthController::class, "register"])->name("register");
Route::post('/logout', [AuthController::class, "logout"])->name("logout");