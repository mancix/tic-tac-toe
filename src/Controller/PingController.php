<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class PingController extends AbstractController
{
    #[Route('/ping', name: 'app_ping')]
    public function index(): JsonResponse
    {
        return $this->json(['message' => 'pong']);
    }
}
