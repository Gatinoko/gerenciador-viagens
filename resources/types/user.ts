import type { UserRole as Role } from "./UserRole";

export type User = {
    id: number;
    name: string;
    email: string;
    email_verified_at: string;
    user_role: Role;
    password: string;
    created_at: string;
    updated_at: string;
};
