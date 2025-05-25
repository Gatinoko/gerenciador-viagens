<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\TravelRequestController;
use App\Models\TravelRequest;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// Page routes
Route::get('/', [PagesController::class, 'showIndex'])->name("show.index");
Route::get('/dashboard', [PagesController::class, 'showDashboard'])->name("show.dashboard")->middleware(['auth']);
Route::get('/login', [PagesController::class, 'showLogin'])->name("show.login");
Route::get('/register', [PagesController::class, "showRegister"])->name("show.register");

// Auth routes
Route::post('/login', [AuthController::class, 'login'])->name("login");
Route::post('/register', [AuthController::class, "register"])->name("register");
Route::post('/logout', [AuthController::class, "logout"])->name("logout")->middleware(['auth']);

// Travel request routes
Route::post('/travelRequest/create', [TravelRequestController::class, "createTravelRequest"])->name("createTravelRequest");
Route::get('/travelRequest/get', [TravelRequestController::class, "getUserTravelRequest"])->name("getUserTravelRequest");

Route::post('/travelRequest/update', [TravelRequestController::class, "updateTravelRequest"])->name("updateTravelRequest");
Route::post('/travelRequest/cancel', [TravelRequestController::class, "cancelTravelRequest"])->name("cancelTravelRequest");