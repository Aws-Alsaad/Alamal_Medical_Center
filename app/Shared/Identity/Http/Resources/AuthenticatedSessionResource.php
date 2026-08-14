<?php

namespace App\Shared\Identity\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthenticatedSessionResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [
            'user' => [
                'id' => $this->resource['user']->id,
                'name' => $this->resource['user']->name,
                'role' => $this->resource['user']->role->value,
            ],
            'token' => $this->resource['token'],
            'token_type' => 'Bearer',
        ];
    }
}
