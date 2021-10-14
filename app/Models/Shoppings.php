<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Cards;
use App\Models\Customers;
use App\Models\Locations;
use App\Models\Shopping_items;

class Shoppings extends Model
{
    use HasFactory, SoftDeletes;


    protected $fillable = [
        'type',
        'payed',
        'shopping_address',
        'pay_type',
        'qrcode',
        'barcode',
        'user_id',
        'customer_id',
        'location_id',
        'card_id',

    ];

    protected $casts = [
        'type' => 'integer',
        'payed' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customers::class);
    }

    public function location()
    {
        return $this->belongsTo(Locations::class);
    }

    public function card()
    {
        return $this->belongsTo(Cards::class);
    }

    public function products(){
        return $this->hasMany(Shopping_items::class);
    }
}
