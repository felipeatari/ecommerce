<?php

namespace App\DTO;

use App\Models\Sku;

class SkuDTO
{
    public ?int $id;
    public ?int $product_id;
    public ?int $variation_id_1;
    public ?int $variation_id_2;
    public ?int $stock;
    public ?int $price;
    public ?int $cost_price;
    public ?int $discount_price;
    public ?float $weight;
    public ?float $width;
    public ?float $height;
    public ?float $length;
    public ?string $cover;
    public ?bool $active;

    public function __construct(Sku $sku)
    {
        $this->id = $sku['id'];
        $this->product_id = $sku['product_id'];
        $this->variation_id_1 = $sku['variation_id_1'];
        $this->variation_id_2 = $sku['variation_id_2'];
        $this->stock = $sku['stock'];
        $this->price = $sku['price'];
        $this->cost_price = $sku['cost_price'];
        $this->discount_price = $sku['discount_price'];
        $this->weight = $sku['weight'];
        $this->width = $sku['width'];
        $this->height = $sku['height'];
        $this->length = $sku['length'];
        $this->cover = $sku['cover'];
        $this->active = $sku['active'];
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'variation_id_1' => $this->variation_id_1,
            'variation_id_2' => $this->variation_id_2,
            'stock' => $this->stock,
            'price' => $this->price,
            'cost_price' => $this->cost_price,
            'discount_price' => $this->discount_price,
            'weight' => $this->weight,
            'width' => $this->width,
            'height' => $this->height,
            'length' => $this->length,
            'cover' => $this->cover,
            'active' => $this->active,
        ];
    }

    public static function fromModel(Sku $sku)
    {
        return new self($sku);
    }
}
