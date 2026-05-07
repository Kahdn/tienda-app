<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../config/JWT.php';

class AuthController {
    public function login(): void {
        $body = json_decode(file_get_contents('php://input'), true);

        $username = trim($body['username'] ?? '');
        $password = trim($body['password'] ?? '');

        if ($username === '' || $password === '') {
            http_response_code(400);
            echo json_encode(['error' => 'Usuario y contraseña son requeridos']);
            return;
        }

        $db = (new Database())->connect();
        $stmt = $db->prepare('SELECT id, username, password, rol FROM usuarios WHERE username = :u');
        $stmt->execute([':u'=> $username]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Credenciales incorrectas']);
            return;
        }

        $token = JWT::encode([
            'sub' => $user['id'],
            'username' => $user['username'],
            'rol' => $user['rol'],
            'iat' => time(),
            'exp' => time() + 3600,
        ]);

        echo json_encode([
            'token' => $token,
            'username' => $user['username'],
            'rol' => $user['rol'],
        ]);
    }
}