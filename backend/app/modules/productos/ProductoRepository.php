<?php
require_once __DIR__ . '/../../../config/Database.php';

class ProductoRepository {
    private PDO $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function findAll(): array {
        $stmt = $this->db->query(
            'SELECT id, nombre, descripcion, precio, stock, categoria FROM productos WHERE activo = true ORDER BY id'
        );
        return $stmt->fetchAll();
    }

    public function update(int $id, array $data): void {
        $stmt = $this->db->prepare(
            'UPDATE productos SET nombre = :nombre, descripcion = :descripcion,
             precio = :precio, stock = :stock, categoria = :categoria WHERE id = :id'
        );
        $stmt->execute([
            ':nombre'      => $data['nombre'],
            ':descripcion' => $data['descripcion'] ?? '',
            ':precio'      => $data['precio'],
            ':stock'       => $data['stock'] ?? 0,
            ':categoria'   => $data['categoria'] ?? '',
            ':id'          => $id,
        ]);
    }

    public function softDelete(int $id): void {
        $stmt = $this->db->prepare('UPDATE productos SET activo = false WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }
}