<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sku extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'variation_id_1',
        'variation_id_2',
        'stock',
        'price',
        'cost_price',
        'discount_price',
        'active',
        'weight',
        'width',
        'height',
        'length',
        'cover',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variation1()
    {
        return $this->belongsTo(Variation::class, 'variation_id_1');
    }

    public function variation2()
    {
        return $this->belongsTo(Variation::class, 'variation_id_2');
    }
}
