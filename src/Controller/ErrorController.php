<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ErrorController extends AbstractController
{
    public function __construct(
        private ParameterBagInterface $parameterBag,
    ) {
    }

    public function handle(\Throwable $exception): JsonResponse
    {
        if ($exception instanceof HttpExceptionInterface) {
            return $this->json([
                'error' => $exception->getMessage(),
            ], $exception->getStatusCode());
        }

        $debug = $this->parameterBag->get('kernel.debug');

        return $this->json([
             'error' => $debug ? $exception->getMessage() : 'Internal Server Error',
         ], 500);
    }
}
