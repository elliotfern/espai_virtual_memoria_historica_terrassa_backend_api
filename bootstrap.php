<?php
// bootstrap.php

use App\Infrastructure\Database\DatabaseConnection;
use App\Application\Router;
use App\Application\HttpResponder;
use App\Application\FrontController;
use App\Application\Routes\UserRoutes;

// Cargar librerías externas
require_once __DIR__ . '/vendor/autoload.php';
$basePath = __DIR__ . '/';

$envName = $_ENV['APP_ENV'] ?? 'prod'; // default: prod
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/', '.env.' . $envName);
$dotenv->load();

// Configuración de base de datos
$host = $_ENV['DB_HOST'] ?? null;
$user = $_ENV['DB_USER'] ?? null;
$password = $_ENV['DB_PASS'] ?? null;
$dbName = $_ENV['DB_DBNAME'] ?? null;

// Crear conexión a la base de datos
$databaseConnection = new DatabaseConnection($host, $dbName, $user, $password);

// Crear router
$router = new Router(); // Aquí instanciamos la implementación concreta de Router

// Crear responder
$responder = new HttpResponder();

// Configura las rutas de los usuarios (ahora pasando la conexión a la base de datos)
UserRoutes::configure($router, $databaseConnection);

// Crear FrontController
$requestUri = $_SERVER['REQUEST_URI'];
$frontController = new FrontController($requestUri, $router, $responder);

// Ejecutar la aplicación
$frontController->handleRequest();
