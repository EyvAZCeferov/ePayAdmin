<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\LocationsCollection;

class Customers extends JsonResource
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
        $seoUrls = json_decode($this->seo_urls);
        return [
            'id' => $this->id,
            'azName' => $names->az_name,
            'ruName' => $names->ru_name,
            'enName' => $names->en_name,
            'azDescription' => $descriptions->az_description,
            'ruDescription' => $descriptions->ru_description,
            'enDescription' => $descriptions->en_description,
            'logo' => $this->logo,
            'site_url' => $urls->site ?? '',
            'facebook' => $urls->facebook ?? '',
            'instagram' => $urls->instagram ?? '',
            'telephone' => $urls->telephone ?? '',
            'whatsapp' => $urls->whatsapp ?? '',
            'email' => $this->urls->email ?? '',
            'cannonical' => $this->seo_url,
            'azSeoUrl' => $seoUrls->az_seo_url,
            'ruSeoUrl' => $seoUrls->ru_seo_url,
            'enSeoUrl' => $seoUrls->en_seo_url,
            'locations' => $this->locations
        ];
    }
}
