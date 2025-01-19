<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
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
    ];
}
