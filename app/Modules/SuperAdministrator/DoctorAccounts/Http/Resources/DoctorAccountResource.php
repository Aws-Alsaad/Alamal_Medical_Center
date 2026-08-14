<?php

namespace App\Modules\SuperAdministrator\DoctorAccounts\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorAccountResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'email' => $this->resource->email,
            'role' => $this->resource->role->value,
        ];
    }
}
