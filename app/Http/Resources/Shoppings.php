<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Shoppings extends JsonResource
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
            'id' => $this->id,
            'type' => $this->type,
            'payed' => $this->payed,
            'shippingAddress' => $this->shipping_address ?? '',
            'payType' => $this->pay_type,
            'qrcode' => $this->qrcode,
            'barcode' => $this->barcode,
            'user' => new User($this->user),
            'customer' => new Customers($this->customer),
            'location' => new Locations($this->locations),
            'card' => new Cards($this->cards),
        ];
    }
}
