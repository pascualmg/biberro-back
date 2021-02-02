<?php

namespace App\Infrastructure\UI\Http\Json;

use Symfony\Component\HttpFoundation\JsonResponse;

class HealthController
{
    public function __invoke(): JsonResponse
    {
        $foo = 'bar';
        return new JsonResponse("biberro back up!! , 8==D");
    }
}