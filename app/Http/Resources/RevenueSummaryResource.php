<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RevenueSummaryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray ($request)
    {
        return [
            'total' => $this->sum,
            'date'  => $this->date->format(config('app.date_format')),
        ];
    }
}
