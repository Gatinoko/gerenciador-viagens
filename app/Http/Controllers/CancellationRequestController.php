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
            "travelRequestId" => ['required', 'integer', 'exists:travel_requests,id', 'unique:cancellation_requests,request_id'],
            "solicitorId" => ['required', 'integer', 'exists:users,id'],
            "destination" => ['required', 'string', 'max:64'],
            "departureDate" => ['required', 'date'],
            "returnDate" => ['required', 'date', 'after:departureDate'],
            "status" => ['required', 'in:approved,rejected,solicited'],
            "requestMessage" => ['required', 'string', 'max:64'],
        ], [
            "travelRequestId.unique" => 'Cancelamento já solicitado para este pedido de viagem.'
        ]);

        // Creates cancellation request in table
        CancellationRequest::create([
            "request_id" => $request->travelRequestId,
            "status" => 'solicited',
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

    public function updateCancellationRequestStatus(Request $request) {
        $request->validate([
            "cancellationRequestId" => ['required', 'integer', 'exists:cancellation_requests,id'],
            "associatedTravelRequestId" => ['required', 'integer', 'exists:travel_requests,id'],
            "message" => ['required', 'string'],
            "status" => ['required', 'in:approved,rejected,solicited'],
        ]);

        $cancellationRequestId = $request->request->get('cancellationRequestId');
        $newStatusValue = $request->request->get('status');

        CancellationRequest::where('id', $cancellationRequestId)->update(['status' => $newStatusValue]);

        return to_route('show.adminDashboard')->with(
            'toast',
            [
                'type' => 'success',
                'message' => 'Status de cancelamento atualizado com sucesso'
            ]
        );
    }
}
