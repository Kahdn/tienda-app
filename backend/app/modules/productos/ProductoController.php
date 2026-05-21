<?php
require_once __DIR__ . '/ProductoService.php';
require_once __DIR__ . '/../../../app/shared/auth/PermissionService.php';

class ProductoController {
    private ProductoService $service;

    public function __construct() {
        $this->service = new ProductoService();
    }

    public function index(): void {
        PermissionService::verificar();
        $this->service->getAll();
    }

    public function update(int $id): void {
        PermissionService::verificar(['admin']);
        $body = json_decode(file_get_contents('php://input'), true);
        $this->service->update($id, $body);
    }

    public function destroy(int $id): void {
        PermissionService::verificar(['admin']);
        $this->service->delete($id);
    }
}