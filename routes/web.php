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