<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class InvalidPlayerMoveException extends \Exception implements HttpExceptionInterface
{
    public const MESSAGE = 'Invalid player move';

    public function __construct()
    {
        parent::__construct(self::MESSAGE);
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
