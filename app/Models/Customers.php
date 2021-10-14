<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Campaigns;
use App\Models\Products;
use App\Models\Locations;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customers extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'customers';
    protected $fillable = [
        'id',
        'names',
        'descriptors',
        'logo',
        'urls',
        'seo_urls',
    ];
    protected $casts = [
        'names' => 'json',
        'descriptors' => 'json',
        'urls' => 'json',
        'seo_urls' => 'json',
    ];

    public function campaigns()
    {
        return $this->belongsTo(Campaigns::class);
    }

    public function products()
    {
        return $this->belongsTo(Products::class);
    }

    public function locations()
    {
        return $this->belongsTo(Locations::class, 'customers_id', 'id');
    }
}
