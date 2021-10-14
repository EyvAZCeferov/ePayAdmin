<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Setting extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $descriptions = json_decode($this->site_descriptors);
        $socialM = json_decode($this->social_media);

        return [
            'id' => $this->id,
            'logo' => $this->logo,
            'projectName' => $this->project_name,
            'siteUrl' => $this->site_url,
            'siteAdminUrl' => $this->site_admin_url,
            'azDescription' => $descriptions->az_description,
            'ruDescription' => $descriptions->ru_description,
            'enDescription' => $descriptions->en_description,
            'facebook' => $socialM->facebook,
            'instagram' => $socialM->instagram,
            'twitter' => $socialM->twitter,
            'youtube' => $socialM->youtube,
            'email' => $socialM->email,
            'phone' => $socialM->phone,
        ];
    }
}
