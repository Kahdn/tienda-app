<?php
class DatabaseSqlServer {
    private string $host;
    private string $database;
    private string $user;
    private string $password;
    private ?PDO $conn = null;

    public function __construct() {
        $this->host     = $_ENV['SQLSRV_HOST'];
        $this->database = $_ENV['SQLSRV_NAME'];
        $this->user     = $_ENV['SQLSRV_USER'];
        $this->password = $_ENV['SQLSRV_PASSWORD'];
    }

    public function connect(): PDO {
        try {
            if ($this->conn === null) {
                $dsn = "sqlsrv:Server={$this->host};Database={$this->database};TrustServerCertificate=1";
                $this->conn = new PDO($dsn, null, null, [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]);
            }
            return $this->conn;
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Error de conexión a SQL Server']);
            exit;
        }
    }
}