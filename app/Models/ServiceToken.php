<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceToken extends Model
{
    protected $fillable = [
        'service',
        'access_token',
        'refresh_token',
        'expires_at',
        'meta',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'meta' => 'array',
    ];
}
