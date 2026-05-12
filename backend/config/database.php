<?php
class Database {
    private string $host = 'localhost'; // Aqui igual se bedería de cargar desde una variable del archivo .env
    private string $port = '5433'; // Aqui igual se bedería de cargar desde una variable del archivo .env
    private string $dbname = 'tienda_db'; // Aqui igual se bedería de cargar desde una variable del archivo .env
    private string $user = 'postgres'; // Aqui igual se bedería de cargar desde una variable del archivo .env
    private string $password = '1234'; // Aqui igual se bedería de cargar desde una variable del archivo .env
    private ?PDO $conn = null;

    // Tambien hay que crear un archivo setup.sql en la carpeta config/ con la creación e inserts de las tablas
    // debes de incluir el codigo sql necesario para correr el proyecto

    public function connect(): PDO {
        // Toda conexion a base de datos debe de ir dentro de un try catch
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