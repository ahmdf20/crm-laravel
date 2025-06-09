import { LucideIcon } from 'lucide-react';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavGroup {
    title: string;
    items: NavItem[];
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon | null;
    isActive?: boolean;
}

export interface SharedData {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
    [key: string]: unknown;
}

export interface User {
    id: string;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    role: string;
    created_at: string;
    updated_at: string;
    [key: string]: unknown; // This allows for additional properties...
}

export interface Product {
    id: string;
    name: string;
    price: number;
    description: string;
    [key: string]: unknown;
}

export interface Sector {
    id: string;
    name: string;
    bg_color: string;
    text_color: string;
    [key: string]: unknown;
}

export interface Contact {
    id: string;
    name: string;
    company_name: string;
    email: string;
    phone: string;
    sector: Sector;
    sector_id: string;
    address: string;
    [key: string]: string;
}

export interface Column {
    id: string;
    name: string;
}
