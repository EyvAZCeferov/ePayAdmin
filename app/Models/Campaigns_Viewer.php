<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Campaigns;


class Campaigns_Viewer extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "campaign_id",
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaigns::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
