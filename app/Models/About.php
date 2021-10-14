<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;
    protected $fillable = [
        "names",
        "descriptors",
    ];
    protected $casts = [
        "names" => 'json',
        "descriptors" => 'json',
    ];
}
