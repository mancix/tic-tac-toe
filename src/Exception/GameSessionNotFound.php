<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GameSessionNotFound extends NotFoundHttpException
{
    public const MESSAGE = 'Game session not found';

    public function __construct()
    {
        parent::__construct(self::MESSAGE);
    }

    public function getStatusCode(): int
    {
        return Response::HTTP_NOT_FOUND;
    }

    /**
     * @return array<void>
     */
    public function getHeaders(): array
    {
        return [];
    }
}
