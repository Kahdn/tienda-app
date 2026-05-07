export interface LoginRequest {
    username: string;
    password: string;
}

export interface LoginResponse {
    token: string;
    username: string;
    rol: 'admin' | 'user';
}

export interface Usuario {
    username: string;
    rol: 'admin' | 'user';
}