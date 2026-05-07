<?php
class Database {
    private string $host = 'localhost';
    private string $port = '5433';
    private string $dbname = 'tienda_db';
    private string $user = 'postgres';
    private string $password = '1234';
    private ?PDO $conn = null;

    public function connect(): PDO {
        if ($this->conn === null) {
            $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->dbname}";
            $this->conn = new PDO($dsn, $this->user, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        }
            return $this->conn;
    }
}