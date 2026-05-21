<?php
require_once __DIR__ . '/AuthService.php';

class AuthController {
    private AuthService $service;

    public function __construct() {
        $this->service = new AuthService();
    }

    public function login(): void {
        $body     = json_decode(file_get_contents('php://input'), true);
        $username = trim($body['username'] ?? '');
        $password = trim($body['password'] ?? '');

        $this->service->login($username, $password);
    }
}