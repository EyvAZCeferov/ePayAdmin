<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Customers;

class Products extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'picture',
        'names',
        'descriptors',
        'code',
        'barcode',
        'category',
        'price',
        'seo_urls',
        'customer_id',
        'enabled'
    ];

    protected $casts = [
        'names' => 'json',
        'descriptors' => 'json',
        'category' => 'json',
        'seo_urls' => 'json',
        'enabled' => 'boolean'
    ];

    public function customer()
    {
        return $this->belongsTo(Customers::class);
    }
}
