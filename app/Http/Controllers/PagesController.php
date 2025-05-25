<?php

namespace App\Http\Controllers;

use App\Models\TravelRequest;
use Inertia\Inertia;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function showIndex(Request $request) {
        return Inertia::render("Index", [
            "appName" => config("app.name"),
        ]);
    }

    public function showDashboard(Request $request) {
        // Gets authenticated user's id
        $currUserId = $request->user()->only('id');

        // Retrieves respective user's travel requests
        $userTravelRequests = TravelRequest::where('solicitor_id', $currUserId)->get();

        // Returns dashboard view with all user travel requests
        return Inertia::render('Dashboard', [
            'appName' => config('app.name'),
            'allReqs' => $userTravelRequests,
        ]);
    }

    public function showLogin(Request $request) {
        return Inertia::render("Login", [
            "appName" => config("app.name"),
        ]);
    }

    public function showRegister(Request $request) {
        return Inertia::render("Register", [
            "appName" => config("app.name"),
        ]);
    }
}
