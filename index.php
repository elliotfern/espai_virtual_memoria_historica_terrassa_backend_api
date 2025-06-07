<?php
// Mostrar errores en desarrollo (solo para entorno dev)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Obtener la URI solicitada
$requestUri = $_SERVER['REQUEST_URI'];

// Si la ruta comienza con "/api", manejarla con el backend
if (preg_match('#^/#', $requestUri)) {
    // Incluir el archivo o lógica para manejar las rutas de la API
    // Por ejemplo, incluir tu archivo de rutas de la API
    require_once __DIR__ . '/bootstrap.php';
    exit;  // Terminar la ejecución aquí, ya que la API está manejada
} else {
    // Si no es una ruta de API, servir el frontend SPA (index.html)
    echo "Error";
    exit;  // Terminar la ejecución aquí, ya que la API está manejada
}
