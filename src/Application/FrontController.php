<?php

namespace App\Application;

use App\Application\Contract\RouterInterface;
use App\Application\Contract\HttpResponderInterface;

class FrontController
{
    private string $requestUri;
    private RouterInterface $apiRouter;
    private HttpResponderInterface $responder;

    public function __construct(
        string $requestUri,
        RouterInterface $apiRouter,
        HttpResponderInterface $responder
    ) {
        $this->requestUri = '/' . trim($requestUri, '/');
        $this->apiRouter = $apiRouter;
        $this->responder = $responder;
    }

    public function handleRequest(): void
    {
        // Intentamos hacer match con la URI
        $match = $this->apiRouter->match($this->requestUri);

        // Verifica que el match contenga los datos esperados
        if ($match && isset($match['routeInfo']['handler'][0], $match['routeInfo']['handler'][1])) {
            // Si encontramos una coincidencia, procesamos la respuesta
            $this->handleRouteMatch($match);
        } else {
            // Si no se encuentra una coincidencia, podemos devolver un error 404
            $this->responder->respondError('errorEndPoint', [], 404);
        }
    }

    private function handleRouteMatch(array $match): void
    {
        // Comprobamos que 'handler' tenga el controlador y el método
        if (isset($match['routeInfo']['handler'][0], $match['routeInfo']['handler'][1])) {
            $controller = $match['routeInfo']['handler'][0];  // El controlador (objeto)
            $method = $match['routeInfo']['handler'][1];      // El método a ejecutar
            $params = $match['params'];                        // Los parámetros de la ruta

            // Verifica que el controlador y método existen
            if (method_exists($controller, $method)) {
                // Ejecutamos el método en el controlador con los parámetros
                call_user_func_array([$controller, $method], $params);
            } else {
                // Si el método o controlador no existen, respondemos con un error 500
                $this->responder->respondError('errorBD', [], 500);
            }
        } else {
            // Si 'handler' no tiene los datos esperados, lanzamos un error 500
            $this->responder->respondError('errorEndPoint', [], 500);
        }
    }
}
