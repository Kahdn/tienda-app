<?php
require_once __DIR__ . '/ProductoRepository.php';
require_once __DIR__ . '/../../../app/shared/responses/ApiResponse.php';

class ProductoService {
    private ProductoRepository $repository;

    public function __construct() {
        $this->repository = new ProductoRepository();
    }

    public function getAll(): void {
        try {
            $productos = $this->repository->findAll();
            ApiResponse::success($productos);
        } catch (Exception $e) {
            ApiResponse::error('Error al obtener productos', 500);
        }
    }

    public function update(int $id, array $data): void {
        try {
            $this->repository->update($id, $data);
            ApiResponse::success(['message' => 'Producto actualizado']);
        } catch (Exception $e) {
            ApiResponse::error('Error al actualizar producto', 500);
        }
    }

    public function delete(int $id): void {
        try {
            $this->repository->softDelete($id);
            ApiResponse::success(['message' => 'Producto eliminado']);
        } catch (Exception $e) {
            ApiResponse::error('Error al eliminar producto', 500);
        }
    }
}