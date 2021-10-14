<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Customers;
use App\Models\Campaigns_Viewer;

class Campaigns extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'pictures',
        'names',
        'descriptors', 
        'dates',
        'seo_urls',
        'related_products',
        'prices',
        'notify',
        'customer_id',
    ];
    protected $casts = [
        'pictures' => 'json',
        'names' => 'json',
        'descriptors' => 'json',
        'dates' => 'json',
        'related_products' => 'json',
        'prices' => 'json',
        'notify' => 'boolean',
        'seo_urls' => 'json',
    ];

    public function customer()
    {
        return $this->belongsTo(Customers::class);
    }

    public function views()
    {
        return $this->hasMany(Campaigns_Viewer::class);
    }
}
