<?php

namespace App\Http\Resources\Revenue;

use App\Http\Resources\Client\ClientResource;
use App\Http\Resources\Product\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RevenueResource extends JsonResource
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
            'id'      => $this->id,
            'client'  => ClientResource::make($this->whenLoaded('client')),
            'product' => ProductResource::make($this->whenLoaded('product')),
            'total'   => $this->total,
            'date'    => $this->date->format(config('app.date_format'))
        ];
    }
}
