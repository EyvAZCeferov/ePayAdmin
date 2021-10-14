<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Products;


class Comments extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'comment',
        'user_id',
        'rating',
    ];

    public function product()
    {
        return $this->belongsTo(Products::class);
    }

    public function user()
    {
        return $this->belongsTo(Users::class);
    }
}
