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

        if (str_starts_with($requestUri, '/')) {
            $match = $this->apiRouter->match($requestUri);
            $this->responder->respondToApiRoute($match['routeInfo'] ?? null, $match['params'] ?? []);
        }
    }
}
