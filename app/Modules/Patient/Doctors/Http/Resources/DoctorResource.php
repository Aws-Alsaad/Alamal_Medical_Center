<?php

namespace App\Modules\Patient\Doctors\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
        ];
    }
}
