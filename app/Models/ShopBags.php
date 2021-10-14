<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopBags extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'product_id',
        'qyt'
    ];

    protected $casts = [
        'type' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function product()
    {
        return $this->belongsTo(Products::class);
    }
}
