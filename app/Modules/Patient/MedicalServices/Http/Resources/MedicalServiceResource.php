<?php

namespace App\Modules\Patient\MedicalServices\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MedicalServiceResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'cost' => $this->resource->cost,
        ];
    }
}
