<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id',
        'variation_id',
        'image_1',
        'image_2',
        'image_3',
        'image_4',
        'image_5',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
