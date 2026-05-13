<?php
require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/ProductoController.php';

Flight::before('start', function () {
    header('Access-Control-Allow-Origin: ' . $_ENV['APP_URL']);
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    header('Content-Type: application/json; charset=utf-8');

    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200);
        exit;
    }
});

Flight::route('POST /api/login', function () {
    (new AuthController())->login();
});

Flight::route('GET /api/productos', function () {
    (new ProductoController())->index();
});

Flight::route('PUT /api/productos/@id', function (string $id) {
    (new ProductoController())->update((int) $id);
});

Flight::route('DELETE /api/productos/@id', function (string $id) {
    (new ProductoController())->destroy((int) $id);
});

Flight::start();