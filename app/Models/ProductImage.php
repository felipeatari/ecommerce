<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductImage extends Model
{
    use SoftDeletes;

    const DELETED_AT = 'removed_at';

    protected $fillable = [
        'product_id',
        'variation_id',
        'image_1',
        'image_2',
        'image_3',
        'image_4',
        'image_5',
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

        static::deleting(function ($brand) {
            $brand->active = false;
            $brand->removed_by = auth()?->id();
            $brand->save();
        });
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
