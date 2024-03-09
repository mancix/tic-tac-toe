<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class SwaggerController extends AbstractController
{
    #[Route('/', name: 'swagger', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return $this->json(['swagger']);
    }
}
