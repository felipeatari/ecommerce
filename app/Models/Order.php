<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    const DELETED_AT = 'removed_at';

    protected $fillable = [
        'user_id',
        'status',
        'subtotal',
        'discount',
        'total',
        'payment_gateway',
        'payment_type',
        'payment_installment',
        'shipping_name',
        'shipping_price',
        'shipping_delivery_time',
        'delivery_city',
        'delivery_state',
        'delivery_neighborhood',
        'delivery_address',
        'delivery_number',
        'delivery_complement',
        'delivery_country',
        'delivery_country_code',
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
