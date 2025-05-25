<?php

namespace App\Http\Controllers;

use App\Models\TravelRequest;
use Illuminate\Http\Request;

class TravelRequestController extends Controller
{
    public function createTravelRequest(Request $request) {
        // Validates form input
        $request->validate([
            "solicitorId" => ['required', 'integer', 'exists:users,id'],
            "destination" => ['required', 'string', 'max:64'],
            "departureDate" => ['required', 'date'],
            "returnDate" => ['required', 'date', 'after:departureDate'],
            "status" => ['required', 'in:solicited,approved,cancelled'],
        ]);

        // Creates travel request in table
        TravelRequest::create([
            "solicitor_id" => $request->solicitorId,
            "destination" => $request->destination,
            "departure_date" => $request->departureDate,
            "return_date" => $request->returnDate,
            "status" => $request->status,
        ]);

        return to_route("show.dashboard")->with('message', 'successfully created travel request');
    }

    public function updateTravelRequest(Request $request) { }

    public function cancelTravelRequest(Request $request) { }

    public function getUserTravelRequest(Request $request) {
        // Request body content
        $bodyContent = $request->query();

        // Gets authenticated user's id
        $authUserId = $request->user()->only('id');

        // Retrieves respective user's travel requests
        $userTravelRequest = TravelRequest::where('solicitor_id', $authUserId)->where('id', $bodyContent['travel_request_id'])->with('user')->first();

        // return response()->json($bodyContent);
        return response()->json($userTravelRequest);
    }
}
