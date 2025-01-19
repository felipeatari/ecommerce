<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
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
    ];
}
