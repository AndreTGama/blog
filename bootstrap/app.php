<?php

use App\Responses\ApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth' => \App\Http\Middleware\AuthenticateApi::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Throwable $e, Request $request) {
            if ($e instanceof ValidationException) {
                return ApiResponse::error(
                    message: 'Validation failed.',
                    exception: $e->getMessage(),
                    data: [
                        'errors' => $e->validator->errors(),
                    ],
                    status: 422
                );
            }

            if ($e instanceof AuthenticationException) {
                return ApiResponse::error(
                    message: 'You are not logged in.',
                    exception: $e->getMessage(),
                    data: [],
                    status: 401
                );
            }

            if ($e instanceof QueryException) {
                return ApiResponse::error(
                    message: 'Database error occurred.',
                    exception: $e->getMessage(),
                    data: [],
                    status: 500
                );
            }

            if ($e instanceof RouteNotFoundException) {
                return ApiResponse::error(
                    message: 'Page not found.',
                    exception: $e->getMessage(),
                    data: [],
                    status: 404
                );
            }
            if ($e instanceof AccessDeniedHttpException) {
                return ApiResponse::error(
                    message: 'You are not authorized to access this resource.',
                    exception: $e->getMessage(),
                    data: [],
                    status: 403
                );
            }
            return ApiResponse::error(
                message: 'An unexpected error occurred.',
                exception: $e->getMessage(),
                data: [],
                status: 500
            );
        });
    })->create();
