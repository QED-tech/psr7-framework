<?php

namespace App\Http\Actions;

use Laminas\Diactoros\Response\JsonResponse;

class AboutAction
{
    public function __invoke(): JsonResponse
    {
        return new JsonResponse(['page' => 'about page']);
    }
}
