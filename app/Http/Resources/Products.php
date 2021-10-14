<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Products extends JsonResource
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
        $seoUrls = json_decode($this->seo_urls);
        $category = json_decode($this->category);

        return [
            'id' => $this->id,
            'picture' => $this->picture,
            'azName' => $names->az_name,
            'ruName' => $names->ru_name,
            'enName' => $names->en_name,
            'azDescription' => $descriptions->az_description,
            'ruDescription' => $descriptions->ru_description,
            'enDescription' => $descriptions->en_description,
            'code' => $this->code,
            'barcode' => $this->barcode,
            'homeCat' => $category->home_cat ?? '',
            'firstChildCat' => $category->first_child_cat ?? '',
            'secondChildCat' => $category->second_child_cat ?? '',
            'threeChildCat' => $category->three_child_cat ?? '',
            'price' => floatval($this->price),
            'qyt' => floatval($this->quantity),
            'azSeoUrl' => $seoUrls->az_seo_url,
            'ruSeoUrl' => $seoUrls->ru_seo_url,
            'enSeoUrl' => $seoUrls->en_seo_url,
            'customer' => new Customers($this->customer),
            'enabled' => $this->enabled,
            'views' => $this->views,

        ];
    }
}
