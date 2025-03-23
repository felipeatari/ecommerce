<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sku extends Model
{
    use HasFactory, SoftDeletes;

    const DELETED_AT = 'removed_at';

    protected $fillable = [
        'product_id',
        'variation_id_1',
        'variation_id_2',
        'stock',
        'price',
        'cost_price',
        'discount_price',
        'weight',
        'width',
        'height',
        'length',
        'cover',
        'active',
        'created_by',
        'updated_by',
        'removed_by',
    ];

    protected $dates = [
        'removed_at',
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
