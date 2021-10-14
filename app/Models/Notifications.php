<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\NotificationStatus;

class Notifications extends Model
{
    use HasFactory;

    protected $fillable = [
        'titles',
        'descriptors',
        'urls',
        'image',
        'user_id',
    ];

    protected $casts = [
        'titles' => 'json',
        'descriptors' => 'json',
        'urls' => 'json',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function notification_stat()
    {
        return $this->hasMany(NotificationStatus::class);
    }
}
