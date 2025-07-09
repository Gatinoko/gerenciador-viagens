<?php

namespace App\Http\Controllers;

use App\Models\CancellationRequest;
use App\Models\TravelRequest;
use Inertia\Inertia;
use Illuminate\Http\Request;

class PagesController
{
    public function showIndex(Request $request) {
        return Inertia::render("Index");
    }

    public function showDashboard(Request $request) {
        // Gets authenticated user's id
        $authUserId = $request->user()->only('id');

        // Retrieves respective user's travel requests
        $userTravelRequests = TravelRequest::with('user')->where('solicitor_id', $authUserId)->get();

        // Returns dashboard view with the respective user's travel requests
        return Inertia::render('Dashboard', [
            'userRequests' => $userTravelRequests,
        ]);
    }

    public function showAdminDashboard(Request $request) {
        // Retrieves all travel requests
        $allTravelRequests = TravelRequest::with('user')->get();

        // Retrieves all travel requests
        $allCancellationRequests = CancellationRequest::with('travelRequest.user')->get();

        // Returns dashboard view with all user travel requests
        return Inertia::render('AdminDashboard', [
            'allRequests' => $allTravelRequests,
            'allCancellationRequests' => $allCancellationRequests,
        ]);
    }

    public function showLogin(Request $request) {
        return Inertia::render("Login");
    }

    public function showRegister(Request $request) {
        return Inertia::render("Register");
    }
}
