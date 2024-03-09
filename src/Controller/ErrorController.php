<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class ErrorController extends AbstractController
{
    public function show(\Throwable $exception): JsonResponse
    {
        return $this->json([
             'error' => $exception->getMessage(),
         ], 500);
    }
}
