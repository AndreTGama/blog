<?php

namespace App\Exceptions;

use App\Builder\ReturnMessage;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (NotFoundHttpException $e) {
            return ReturnMessage::message(
                true,
                'Route not found',
                $e->getMessage(),
                $e,
                [
                    'file' => $e->getFile(),
                    'message' => $e->getMessage(),
                    'code' => $e->getCode(),
                    'line' => $e->getLine()
                ],
            404);
        });

        $this->renderable(function (Exception $e) {
            return ReturnMessage::message(
                true,
                'An unexpected error occurred',
                $e->getMessage(),
                $e,
                [
                    'file' => $e->getFile(),
                    'message' => $e->getMessage(),
                    'code' => $e->getCode(),
                    'line' => $e->getLine()
                ],
            500);
        });

        $this->renderable(function (Throwable $e) {
            return ReturnMessage::message(
                true,
                'Something wrong',
                $e->getMessage(),
                null,null,
            500);
        });
    }
}
