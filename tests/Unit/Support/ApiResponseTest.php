<?php

namespace Tests\Unit\Support;

use App\Shared\Support\Http\ApiResponse;
use Tests\TestCase;

class ApiResponseTest extends TestCase
{
    public function test_it_produces_the_approved_success_envelope(): void {
        $response = ApiResponse::success();

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame([
            'success' => true,
            'status_code' => 200,
            'message' => 'Request completed successfully.',
            'data' => [],
        ], $response->getData(true));
    }

    public function test_it_produces_the_approved_error_envelope(): void {
        $errors = [
            'email' => ['The email field is required.'],
        ];

        $response = ApiResponse::error(
            message: 'The provided data is invalid.',
            errorCode: 'VALIDATION_ERROR',
            status: 422,
            errors: $errors,
        );

        $this->assertSame(422, $response->getStatusCode());
        $this->assertSame([
            'success' => false,
            'status_code' => 422,
            'message' => 'The provided data is invalid.',
            'error_code' => 'VALIDATION_ERROR',
            'errors' => $errors,
        ], $response->getData(true));
    }

    public function test_it_omits_errors_when_no_field_level_details_are_relevant(): void {
        $response = ApiResponse::error(
            message: 'Authentication is required.',
            errorCode: 'UNAUTHENTICATED',
            status: 401,
        );

        $this->assertSame([
            'success' => false,
            'status_code' => 401,
            'message' => 'Authentication is required.',
            'error_code' => 'UNAUTHENTICATED',
        ], $response->getData(true));
    }
}
