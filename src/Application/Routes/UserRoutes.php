<?php

// src/Application/Routes/UserRoutes.php
namespace App\Application\Routes;

use App\Application\Controllers\UserController;
use App\Application\HttpResponder;
use App\Domain\Services\UserService;
use App\Domain\UseCases\GetUsersUseCase;
use App\Application\Controllers\LoginController;
use App\Domain\UseCases\LoginUserUseCase;
use App\Infrastructure\Persistence\MySqlUserRepository;
use App\Infrastructure\Database\DatabaseConnection;
use App\Domain\Services\AuthService;

class UserRoutes
{
    public static function configure($router, DatabaseConnection $databaseConnection)
    {
        // Crea el repositorio con la conexión a la base de datos
        $userRepository = new MySqlUserRepository($databaseConnection);

        // Crea el servicio, pasando el repositorio
        $userService = new UserService($userRepository);

        // Crea el caso de uso, pasando el servicio
        $getUsersUseCase = new GetUsersUseCase($userService);

        // Crea el responder
        $httpResponder = new HttpResponder();

        // Instancia el controlador, pasando el caso de uso y el responder
        $userController = new UserController($getUsersUseCase, $httpResponder);

        // Configura la ruta correctamente
        $router->get('/users', [$userController, 'getUsers']);

        // Crear las dependencias necesarias para el controlador de login
        $loginUserUseCase = new LoginUserUseCase($userRepository);
        $httpResponder = new HttpResponder();
        $authService = new AuthService();

        // Instanciar el controlador de Login
        $loginController = new LoginController($loginUserUseCase, $httpResponder, $authService);

        // Configurar la ruta de login
        $router->post('/login', [$loginController, 'login']);
    }
}
