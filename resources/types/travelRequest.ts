import type { User } from "./user";

export type TravelRequest = {
    id: number;
    solicitorId: number;
    destination: string;
    departureDate: string;
    returnDate: string;
    user: User;
    status: "solicited" | "approved" | "cancelled";
};
