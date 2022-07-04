<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'product_name' => $this->product_name,
            'price' => number_format($this->price, 2),
            'profit' => number_format($this->profit, 2),
            'thumbnail' => $this->thumbnail,
            'store' => $this->store,
            'status' => $this->status,
            'store' => number_format($this->regular_price, 2),
        ];
    }
}
