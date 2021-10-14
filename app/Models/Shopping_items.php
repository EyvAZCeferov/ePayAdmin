<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Shoppings;
use App\Models\Products;

class Shopping_items extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shopping_id',
        'product_id',
        'name',
        'code',
        'barcode',
        'price',
        'qyt',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shopping()
    {
        return $this->belongsTo(Shoppings::class);
    }

    public function product()
    {
        return $this->belongsTo(Products::class);
    }
}
