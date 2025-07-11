<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CancellationRequestController;
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
Route::get('/adminDashboard', [PagesController::class, 'showAdminDashboard'])->name("show.adminDashboard")->middleware(['auth'])->middleware(['role:admin']);
Route::get('/login', [PagesController::class, 'showLogin'])->name("show.login")->middleware(['guest']);
Route::get('/register', [PagesController::class, "showRegister"])->name("show.register")->middleware(['guest']);

// Auth routes
Route::post('/auth/login', [AuthController::class, 'login'])->name("login")->middleware(['guest']);
Route::post('/auth/register', [AuthController::class, "register"])->name("register")->middleware(['guest']);
Route::post('/auth/logout', [AuthController::class, "logout"])->name("logout")->middleware(['auth']);

// Travel request routes
Route::post('/travelRequest/create', [TravelRequestController::class, "createTravelRequest"])->name("createTravelRequest")->middleware(['auth']);;
Route::get('/travelRequest/get', [TravelRequestController::class, "getUserTravelRequest"])->name("getUserTravelRequest")->middleware(['auth']);;
Route::post('/travelRequest/updateStatus', [TravelRequestController::class, "updateTravelRequestStatus"])->name("updateTravelRequestStatus")->middleware(['auth']);;

// Cancellation request routes
Route::post('/cancellationRequest/create', [CancellationRequestController::class, "createCancellationRequest"])->name("createCancellationRequest")->middleware(['auth']);;
Route::post('/cancellationRequest/updateStatus', [CancellationRequestController::class, "updateCancellationRequestStatus"])->name("updateCancellationRequestStatus")->middleware(['auth']);;