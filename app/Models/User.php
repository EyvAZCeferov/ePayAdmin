<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Models\Cards;
use App\Models\Devices;
use App\Models\Comments;
use App\Models\ShopBags;
use App\Models\Shoppings;
use App\Models\Notifications;
use App\Models\NotificationStatus;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'picture',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function cards()
    {
        return $this->hasMany(Cards::class);
    }

    public function devices()
    {
        return $this->hasMany(Devices::class);
    }

    public function comments()
    {
        return $this->hasMany(Comments::class);
    }

    public function bags()
    {
        return $this->hasMany(ShopBags::class);
    }

    public function shoppings()
    {
        return $this->hasMany(Shoppings::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notifications::class);
    }

    public function notification_stat()
    {
        return $this->hasMany(NotificationStatus::class);
    }
}
