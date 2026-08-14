<?php

namespace App\Modules\Patient\Doctors\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorWorkingHourResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [
            'day_of_week' => $this->resource->day_of_week,
            'start_time' => $this->resource->start_time,
            'end_time' => $this->resource->end_time,
        ];
    }
}
