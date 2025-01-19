<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $fillable = [
        'user_id',
        'zip_code',
        'city',
        'state',
        'neighborhood',
        'address',
        'number',
        'complement',
    ];
}
