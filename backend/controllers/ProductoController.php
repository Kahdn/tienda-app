<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../middleware/AuthMiddleware.php';

class ProductoController {
    private PDO $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function index(): void {
        try {
            AuthMiddleware::verificar();
            $stmt = $this->db->query(
                'SELECT id, nombre, descripcion, precio, stock, categoria FROM productos WHERE activo = true ORDER BY id'
            );
            echo json_encode($stmt->fetchAll());
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Error al obtener productos']);
        }
    }

    public function update(int $id): void {
        try {
            AuthMiddleware::verificar(['admin']);
            $body = json_decode(file_get_contents('php://input'), true);
            $stmt = $this->db->prepare(
                'UPDATE productos SET nombre = :nombre, descripcion = :descripcion,
                 precio = :precio, stock = :stock, categoria = :categoria WHERE id = :id'
            );
            $stmt->execute([
                ':nombre'      => $body['nombre'],
                ':descripcion' => $body['descripcion'] ?? '',
                ':precio'      => $body['precio'],
                ':stock'       => $body['stock'] ?? 0,
                ':categoria'   => $body['categoria'] ?? '',
                ':id'          => $id,
            ]);
            echo json_encode(['message' => 'Producto actualizado']);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Error al actualizar producto']);
        }
    }

    public function destroy(int $id): void {
        try {
            AuthMiddleware::verificar(['admin']);
            $stmt = $this->db->prepare('UPDATE productos SET activo = false WHERE id = :id');
            $stmt->execute([':id' => $id]);
            echo json_encode(['message' => 'Producto eliminado']);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Error al eliminar producto']);
        }
    }
}