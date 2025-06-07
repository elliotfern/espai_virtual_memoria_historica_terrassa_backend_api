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
        $requestUri = $this->requestUri;

        // Intentamos hacer match con la URI
        $match = $this->apiRouter->match($requestUri);

        if ($match) {
            // Si encontramos una coincidencia, procesamos la respuesta
            $this->responder->respondToApiRoute($match['routeInfo'], $match['params']);
        } else {
            // Si no se encuentra una coincidencia, respondemos con un error 404
            $this->responder->respondWithError(404, 'Ruta no encontrada');
        }
    }
}
