<?php
require_once __DIR__ . '/JwtService.php';
require_once __DIR__ . '/../../shared/responses/ApiResponse.php';

class PermissionService {
    public static function verificar(array $rolesPermitidos = []): array {
        $authHeader = $_SERVER['HTTP_AUTHORIZATION'] 
            ?? $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] 
            ?? getallheaders()['Authorization'] 
            ?? '';

        if (!str_starts_with($authHeader, 'Bearer ')) {
            ApiResponse::error('Token no proporcionado', 401);
            exit;
        }

        $token = substr($authHeader, 7);

        try {
            $payload = JwtService::decode($token);
        } catch (Exception $e) {
            ApiResponse::error($e->getMessage(), 401);
            exit;
        }

        if (!empty($rolesPermitidos) && !in_array($payload['rol'], $rolesPermitidos, true)) {
            ApiResponse::error('Acceso denegado', 403);
            exit;
        }

        return $payload;
    }
}