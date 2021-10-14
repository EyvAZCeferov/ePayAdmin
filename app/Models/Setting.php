<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo',
        'project_name',
        'site_url',
        'site_admin_url',
        'site_descriptors',
        'social_media'
    ];

    protected $casts = [
        'site_descriptors' => 'json',
        'social_media' => 'json'
    ];
}
