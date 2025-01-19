<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'slug',
        'brand',
        'active',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Category::class, 'brand');
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
