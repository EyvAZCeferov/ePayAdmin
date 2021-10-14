<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Notifications;

class NotificationStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'notification_id',
        'user_id',
    ];

    public function notification()
    {
        return $this->belongsTo(Notifications::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
