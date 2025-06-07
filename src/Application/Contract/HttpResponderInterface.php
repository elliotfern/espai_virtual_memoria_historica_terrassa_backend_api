<?php

namespace App\Application\Contract;

interface HttpResponderInterface
{
    public function respondToApiRoute($routeInfo, array $params): void;
}
