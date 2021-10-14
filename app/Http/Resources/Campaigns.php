<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Campaigns extends JsonResource
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
        $dates = json_decode($this->dates);
        $seoUrls = json_decode($this->seo_urls);
        $relatedProducts = json_decode($this->related_products);
        $prices = json_decode($this->prices);
        $pictures = json_decode($this->pictures);

        return [
            'id' => $this->id,
            'azName' => $names->az_name,
            'ruName' => $names->ru_name,
            'enName' => $names->en_name,
            'azDescription' => $descriptions->az_description,
            'ruDescription' => $descriptions->ru_description,
            'enDescription' => $descriptions->en_description,
            'startDate' => $dates->start_date,
            'endDate' => $dates->end_date,
            'azSeoUrl' => $seoUrls->az_seo_url,
            'ruSeoUrl' => $seoUrls->ru_seo_url,
            'enSeoUrl' => $seoUrls->en_seo_url,
            'relatedProducts' => $relatedProducts,
            'oldPrice' => $prices->old_price,
            'newPrice' => $prices->new_price,
            'notify' => $this->notify,
            'customer' => new Customers($this->customer),
            'picture' => $pictures,
            'views' => $this->views,
            'customer' => new Customers($this->customer)
        ];
    }
}
