<?php

namespace App\Http\Controllers;

use App\Models\CancellationRequest;
use App\Models\TravelRequest;
use Illuminate\Http\Request;

class CancellationRequestController
{
    public function createCancellationRequest(Request $request) {
        // Validates form input
        $request->validate([
            "solicitorId" => ['required', 'integer', 'exists:users,id'],
            "destination" => ['required', 'string', 'max:64'],
            "departureDate" => ['required', 'date'],
            "returnDate" => ['required', 'date', 'after:departureDate'],
            "status" => ['required', 'in:solicited,approved,cancelled'],
            "requestMessage" => ['required', 'string', 'max:64'],
        ]);

        // Creates cancellation request in table
        CancellationRequest::create([
            "request_id" => $request->travelRequestId,
            "message" => $request->requestMessage,
        ]);

        return to_route('show.dashboard')->with(
            'toast',
            [
                'type' => 'success',
                'message' => 'Cancelamento solicitado com sucesso'
            ]
        );
    }
}
