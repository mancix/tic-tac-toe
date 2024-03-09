<?php

namespace App\Exception;

use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class AlreadyTakenPositionException extends \Exception implements HttpExceptionInterface
{
    public function __construct()
    {
        parent::__construct('Position already taken');
    }

    public function getStatusCode(): int
    {
        return 422;
    }

    public function getHeaders(): array
    {
        return [];
    }
}
