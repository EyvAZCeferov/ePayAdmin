<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email ?? '',
            'phone' => $this->phone,
            'picture' => $this->picture,
            'createdAt' => $this->created_at->toFormattedDateString(),
            // 'cards' => new CardsCollection($this->cards),
            // 'devices' => $this->device,
        ];
    }
}
