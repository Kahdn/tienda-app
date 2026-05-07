<?php
require_once __DIR__ . '/../config/JWT.php';

class AuthMiddleware {
    public static function verificar(array $rolesPermitidos = []): array {
        $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] ?? getallheaders()['Authorization'] ?? '';

        if (!str_starts_with($authHeader, 'Bearer ')) {
            http_response_code(401);
            echo json_encode(['error' => 'Token no proporcionado']);
            exit;
        }

        $token = substr($authHeader, 7);

        try {
            $payload = JWT::decode($token);
        } catch (Exception $e) {
            http_response_code(401);
            echo json_encode(['error' => $e->getMessage()]);
            exit;
        }

        if (!empty($rolesPermitidos) && !in_array($payload['rol'], $rolesPermitidos, true)) {
            http_response_code(403);
            echo json_encode(['error' => 'Acceso denegado']);
            exit;
        }

        return $payload;
    }
}