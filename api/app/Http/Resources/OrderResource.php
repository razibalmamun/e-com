<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\OrderDetailsResource;

class OrderResource extends JsonResource
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
            'user_id'       =>  $this->user_id,
            'customer_name' =>  $this->user->name,
            'order_total'   =>  $this->order_total,
            'order_status'  =>  $this->order_status,
            'details'       =>  OrderDetailsResource::collection($this->details),
            'created_at'    =>  date('d/m/Y H:i:s', strtotime($this->created_at)),
        ];
    }
}
