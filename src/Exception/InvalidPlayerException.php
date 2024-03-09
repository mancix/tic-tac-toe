<?php

namespace App\Exception;

use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class InvalidPlayerException extends \Exception implements HttpExceptionInterface
{
    public const MESSAGE = 'The player must be 1 or 2';

    public function __construct()
    {
        parent::__construct(self::MESSAGE);
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
