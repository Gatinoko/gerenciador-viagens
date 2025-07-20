import type { User } from "./User";

export type TravelRequestStatus = "solicited" | "approved" | "cancelled";

export type TravelRequest = {
    id: number;
    solicitor_id: number;
    destination: string;
    departure_date: string;
    return_date: string;
    status: TravelRequestStatus;
    created_at: string;
    updated_at: string;
};

export type TravelRequestWithUser = {
    id: number;
    solicitor_id: number;
    destination: string;
    departure_date: string;
    return_date: string;
    status: TravelRequestStatus;
    created_at: string;
    updated_at: string;
    user: User;
};
