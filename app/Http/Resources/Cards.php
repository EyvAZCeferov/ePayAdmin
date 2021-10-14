<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User as UserRes;
use Carbon\Carbon;

class Cards extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        Carbon::setLocale('az');
        return [
            'id' => $this->id,
            'cardNumber' => $this->card_number,
            'cardType' => $this->card_type,
            'use' => $this->category,
            'expiryDate' => $this->expiry_date,
            'user' => new UserRes($this->user),
            'createdAt' => $this->created_at->toFormattedDateString(),
        ];
    }
}
