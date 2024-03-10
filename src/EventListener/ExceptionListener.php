<?php

namespace App\EventListener;

use App\Exception\TicTacToeServiceException\TicTacToeServiceExceptionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $response = new JsonResponse();
        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
            $message = $exception->getMessage();
        } elseif ($exception instanceof TicTacToeServiceExceptionInterface) {
            $response->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
            $message = $exception->getMessage();
        } else {
            $message = 'Internal Server Error';
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $response->setData([
            'error' => $message,
        ]);

        $event->setResponse($response);
    }
}
