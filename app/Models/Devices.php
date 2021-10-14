<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devices extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'device',
        'browser',
        'ip_address'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
