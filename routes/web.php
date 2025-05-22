<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Inertia::render('Index', [
        'appName' => config('app.name'),
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard', [
        'appName' => config('app.name'),
    ]);
});

Route::get('/login', function () {
    return Inertia::render('Login', [
        'appName' => config('app.name'),
    ]);
});

Route::get('/register', function () {
    return Inertia::render('Register', [
        'appName' => config('app.name'),
    ]);
});