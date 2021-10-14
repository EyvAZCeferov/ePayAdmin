<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customers;

class Locations extends Model
{
    use HasFactory;

    protected $fillable = [
        'names',
        'descriptors',
        'geolocations',
        'pictures',
        'customers_id',
        'address'
    ];

    protected $casts = [
        'names' => 'json',
        'descriptors' => 'json',
        'geolocations' => 'json',
        'pictures' => 'json',
    ];

    public function customer()
    {
        return $this->belongsTo(Customers::class, 'customers_id', 'id');
    }
}
