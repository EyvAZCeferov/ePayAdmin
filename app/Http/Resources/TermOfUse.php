<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TermOfUse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $names = json_decode($this->names);
        $descriptions = json_decode($this->descriptors);
        return [
            'id' => $this->id,
            'azName' => $names->az_name,
            'ruName' => $names->ru_name,
            'enName' => $names->en_name,
            'azDescription' => $descriptions->az_description,
            'ruDescription' => $descriptions->ru_description,
            'enDescription' => $descriptions->en_description,
        ];
    }
}
