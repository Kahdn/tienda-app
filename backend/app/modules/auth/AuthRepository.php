<?php
require_once __DIR__ . '/../../../config/DatabaseSqlServer.php';

class AuthRepository {
    private PDO $db;

    public function __construct() {
        $this->db = (new DatabaseSqlServer())->connect();
    }

    public function findByUsername(string $username): array|false {
        $stmt = $this->db->prepare(
            'SELECT id, username, password, rol FROM usuarios WHERE username = :u'
        );
        $stmt->execute([':u' => $username]);
        return $stmt->fetch();
    }
}