<?php

use App\Shared\Support\Http\ApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request): bool => $request->is('api/*') || $request->expectsJson(),
        );

        $exceptions->render(function (Throwable $exception, Request $request): ?JsonResponse {
            if (! $request->is('api/*') && ! $request->expectsJson()) {
                return null;
            }

            $httpStatus = $exception instanceof HttpExceptionInterface
                ? $exception->getStatusCode()
                : null;

            return match (true) {
                $exception instanceof ValidationException => ApiResponse::error(
                    message: 'The provided data is invalid.',
                    errorCode: 'VALIDATION_ERROR',
                    status: 422,
                    errors: $exception->errors(),
                ),
                $exception instanceof AuthenticationException, $httpStatus === 401 => ApiResponse::error(
                    message: 'Authentication is required.',
                    errorCode: 'UNAUTHENTICATED',
                    status: 401,
                ),
                $httpStatus === 403 => ApiResponse::error(
                    message: 'You are not authorized to perform this action.',
                    errorCode: 'FORBIDDEN',
                    status: 403,
                ),
                $httpStatus === 404 => ApiResponse::error(
                    message: 'The requested resource was not found.',
                    errorCode: 'RESOURCE_NOT_FOUND',
                    status: 404,
                ),
                $httpStatus === 429 => ApiResponse::error(
                    message: 'Too many requests. Please try again later.',
                    errorCode: 'TOO_MANY_REQUESTS',
                    status: 429,
                ),
                default => ApiResponse::error(
                    message: 'An unexpected server error occurred.',
                    errorCode: 'INTERNAL_SERVER_ERROR',
                    status: 500,
                ),
            };
        });
    })->create();
