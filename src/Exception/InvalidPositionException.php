<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class InvalidPositionException extends \Exception implements HttpExceptionInterface
{
    public const MESSAGE = 'The position on the board must be between 0 and 8';

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
