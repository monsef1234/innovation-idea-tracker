import { PageProps as InertiaPageProps } from "@inertiajs/core";

export interface User {
    id: number;
    email: string;
    name: string;
    role: string;
}

export interface Flash {
    error: string | null;
    success: string | null;
}

export interface PageProps extends InertiaPageProps {
    auth: {
        user: User | null;
    };

    flash: Flash;
}
