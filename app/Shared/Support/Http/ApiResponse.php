<?php

namespace App\Shared\Support\Http;

use Illuminate\Http\JsonResponse;

final class ApiResponse
{
    public static function success(
        mixed $data = [],
        string $message = 'Request completed successfully.',
        int $status = 200,
    ): JsonResponse {
        return response()->json([
            'success' => true,
            'status_code' => $status,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    /**
     * @param  array<string, mixed>|null  $errors
     */
    public static function error(
        string $message,
        string $errorCode,
        int $status,
        ?array $errors = null,
    ): JsonResponse {
        $payload = [
            'success' => false,
            'status_code' => $status,
            'message' => $message,
            'error_code' => $errorCode,
        ];

        if ($errors !== null) {
            $payload['errors'] = $errors;
        }

        return response()->json($payload, $status);
    }
}
