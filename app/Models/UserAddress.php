<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAddress extends Model
{
    use SoftDeletes;

    const DELETED_AT = 'removed_at';

    protected $fillable = [
        'user_id',
        'zip_code',
        'city',
        'state',
        'neighborhood',
        'address',
        'number',
        'complement',
        'active',
        'created_by',
        'updated_by',
        'removed_by',
    ];

    protected $dates = [
        'removed_at',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($userAddress) {
            $userAddress->active = false;
            $userAddress->removed_by = auth()?->id();
            $userAddress->save();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
