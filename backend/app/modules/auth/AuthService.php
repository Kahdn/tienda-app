<?php
require_once __DIR__ . '/AuthRepository.php';
require_once __DIR__ . '/../../../app/shared/auth/JwtService.php';
require_once __DIR__ . '/../../../app/shared/responses/ApiResponse.php';

class AuthService {
    private AuthRepository $repository;

    public function __construct() {
        $this->repository = new AuthRepository();
    }

    public function login(string $username, string $password): void {
        try {
            if ($username === '' || $password === '') {
                ApiResponse::error('Usuario y contraseña son requeridos', 400);
                return;
            }

            $user = $this->repository->findByUsername($username);

            if (!$user || !password_verify($password, $user['password'])) {
                ApiResponse::error('Credenciales incorrectas', 401);
                return;
            }

            $token = JwtService::encode([
                'sub'      => $user['id'],
                'username' => $user['username'],
                'rol'      => $user['rol'],
                'iat'      => time(),
                'exp'      => time() + 3600,
            ]);

            ApiResponse::success([
                'token'    => $token,
                'username' => $user['username'],
                'rol'      => $user['rol'],
            ]);
        } catch (Exception $e) {
            ApiResponse::error('Error interno del servidor', 500);
        }
    }
}