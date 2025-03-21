<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Variation extends Model
{
    use HasFactory, SoftDeletes;

    const DELETED_AT = 'removed_at';

    protected $fillable = [
        'type',
        'value',
        'code',
        'extra',
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

        static::deleting(function ($product) {
            $product->active = false;
            $product->removed_by = auth()?->id();
            $product->save();
        });
    }
}
