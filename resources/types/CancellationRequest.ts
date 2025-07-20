import type { TravelRequest, TravelRequestWithUser } from "./TravelRequest";

export type CancellationRequestStatus = "approved" | "rejected" | "solicited";

export type CancellationRequest = {
    id: number;
    request_id: number;
    status: CancellationRequestStatus;
    message: string;
    created_at: string;
    updated_at: string;
};

export type CancellationRequestWithTravelRequest = {
    id: number;
    request_id: number;
    status: CancellationRequestStatus;
    message: string;
    created_at: string;
    updated_at: string;
    travel_request: TravelRequest;
};

export type CancellationRequestWithTravelRequestWithUser = {
    id: number;
    request_id: number;
    status: CancellationRequestStatus;
    message: string;
    created_at: string;
    updated_at: string;
    travel_request: TravelRequestWithUser;
};
