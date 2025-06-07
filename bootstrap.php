<?php
// bootstrap.php

use App\Application\Router;
use App\Application\HttpResponder;
use App\Application\FrontController;
use App\Application\Security\CheckSessionUseCase;
use App\Infrastructure\Security\JWTSessionVerifier;
use App\Infrastructure\Middleware\AuthMiddleware;

// Cargar librerías externas
require_once __DIR__ . '/vendor/autoload.php';
$basePath = __DIR__ . '/';

$envName = $_ENV['APP_ENV'] ?? 'prod'; // default: prod
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/', '.env.' . $envName);
$dotenv->load();

// Carga rutas
$apiRoutes = require __DIR__ . '/src/Config/Routes/api.php';

// Crea routers
$apiRouter = new Router($apiRoutes);

// Crea middleware de sesión
$sessionVerifier = new JWTSessionVerifier();
$checkSessionUseCase = new CheckSessionUseCase($sessionVerifier);
$authMiddleware = new AuthMiddleware($checkSessionUseCase);

// Crea servicios de vista y traducción
// Inicia servicios
$responder = new HttpResponder($authMiddleware);

// Inyecta todo al FrontController (ojo que el orden de parámetros debe coincidir con el constructor)
$frontController = new FrontController(
    $requestUri,
    $apiRouter,           // Router implements RouterInterface
    $responder            // HttpResponder implements HttpResponderInterface
);

// Lanza la aplicación
$frontController->handleRequest();
