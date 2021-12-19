<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'            =>  $this->id,
            'order_id'      =>  $this->order_id,
            'product_id'    =>  $this->product_id,
            'product_name'  =>  $this->product->name??'',
            'price'         =>  $this->price,
            'quantity'      =>  $this->quantity,
            'sub_total'     =>  $this->sub_total,
        ];
    }
}
