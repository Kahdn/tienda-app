<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../middleware/AuthMiddleware.php';

class ProductoController {
    private PDO $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function index(): void {
        AuthMiddleware::verificar();

        $stmt = $this->db->query(
            'SELECT id, nombre, descripcion, precio, stock, categoria FROM productos ORDER BY id'
        );
        echo json_encode($stmt->fetchAll());
    }

    public function update(int $id): void {
        AuthMiddleware::verificar(['admin']);

        $body = json_decode(file_get_contents('php://input'), true);
        $stmt = $this->db->prepare(
            'UPDATE productos SET nombre = :nombre, descripcion = :descripcion,
            precio = :precio, stock = :stock, categoria = :categoria WHERE id = :id'
        );
        $stmt->execute([
            ':nombre' => $body['nombre'],
            ':descripcion' => $body['descripcion'] ?? '',
            ':precio' => $body['precio'],
            ':stock' => $body['stock'] ?? 0,
            ':categoria' => $body['categoria'] ?? '',
            ':id' => $id,
        ]);
        echo json_encode(['message' => 'Producto actualizado']);
    }

    public function destroy(int $id): void {
        AuthMiddleware::verificar(['admin']);

        // En produccion siempre se evita eliminar registros, en su lugar se hace un soft delete
        // Modificalo para que en vez de eliminar actualice un campo activo a false

        $stmt = $this->db->prepare('DELETE FROM productos WHERE id = :id');
        $stmt->execute([':id' => $id]);
        echo json_encode(['message' => 'Producto eliminado']);
    }
}
