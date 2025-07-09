import { type ClassValue, clsx } from "clsx";
import { twMerge } from "tailwind-merge";

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}

export function formatDbDate(unformattedDateString: string) {
    const [year, month, day] = unformattedDateString.split("-");
    return `${day}-${month}-${year}`;
}

export function translateStatus(
    status: "solicited" | "approved" | "cancelled" | "rejected"
) {
    switch (status) {
        case "solicited":
            return "solicitado";
        case "approved":
            return "aprovado";
        case "cancelled":
            return "cancelado";
        case "rejected":
            return "rejeitado";
    }
}

export function translateAndFormatStatus(
    status: "solicited" | "approved" | "cancelled" | "rejected"
) {
    return (
        translateStatus(status).charAt(0).toUpperCase() +
        translateStatus(status).slice(1)
    );
}
