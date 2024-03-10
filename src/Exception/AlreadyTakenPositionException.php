<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class AlreadyTakenPositionException extends \Exception implements HttpExceptionInterface
{
    public function __construct()
    {
        parent::__construct('Position already taken');
    }

    public function getStatusCode(): int
    {
        return Response::HTTP_UNPROCESSABLE_ENTITY;
    }

    /**
     * @return array<void>
     */
    public function getHeaders(): array
    {
        return [];
    }
}
