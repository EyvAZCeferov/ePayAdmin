<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User;

class Notifications extends JsonResource
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
        $urls = json_decode($this->urls);

        return [
            'id' => $this->id,
            'azName' => $names->az_name,
            'ruName' => $names->ru_name,
            'enName' => $names->en_name,
            'azDescription' => $descriptions->az_description,
            'ruDescription' => $descriptions->ru_description,
            'enDescription' => $descriptions->en_description,
            'facebook' => $urls->facebook_url,
            'instagram' => $urls->instagram_url,
            'twitter' => $urls->twitter_url,
            'tiktok' => $urls->tiktok_url,
            'site' => $urls->website_url,
            'image' => $this->image,
            'user' => new User($this->user),
            'notificationStatus' => $this->notification_stat
        ];
    }
}
