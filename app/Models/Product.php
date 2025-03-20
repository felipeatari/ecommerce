<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'brand_id',
        'name',
        'description',
        'slug',
        'active',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $dates = [
        'deleted_at',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function skus()
    {
       return $this->hasMany(Sku::class);
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }
}
