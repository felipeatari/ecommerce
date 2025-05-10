<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderProduct extends Model
{
    use SoftDeletes;

    const DELETED_AT = 'removed_at';

    protected $fillable = [
        'order_id',
        'product_id',
        'sku_id',
        'name',
        'price_un',
        'price_total',
        'color',
        'size',
        'image',
        'quantity',
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

        static::deleting(function ($order) {
            $order->active = false;
            $order->removed_by = auth()?->id();
            $order->save();
        });
    }
}
