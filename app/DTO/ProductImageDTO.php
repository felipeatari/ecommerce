<?php

namespace App\DTO;

use App\Models\Product;
use App\Models\Variation;

class ProductImageDTO
{
    public ?int $id;
    public ?int $product_id;
    public ?int $variation_id;
    public ?int $image_1;
    public ?int $image_2;
    public ?int $image_3;
    public ?int $image_4;
    public ?int $image_5;
    public ?bool $active;
    private ?Product $product;
    private ?Variation $variation;

    public function __construct(Product $product)
    {
        $this->id = $product['id'];
        $this->product_id = $product['product_id'];
        $this->variation_id = $product['variation_id'];
        $this->image_1 = $product['image_1'];
        $this->image_2 = $product['image_2'];
        $this->image_3 = $product['image_3'];
        $this->image_5 = $product['image_5'];
        $this->active = $product['active'];

        $this->setProduct($product['product']);
        $this->setVariation($product['variation']);
    }

    private function setProduct(?Product $product = null)
    {
        $this->product = $product;
    }

    public function getProduct($columns = [])
    {
        return $this->product;
    }

    private function setVariation(?Variation $variation = null)
    {
        $this->variation = $variation;
    }

    public function getVariation($columns = [])
    {
        return $this->variation;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'variation_id' => $this->variation_id,
            'image_1' => $this->image_1,
            'image_2' => $this->image_2,
            'image_3' => $this->image_3,
            'image_4' => $this->image_4,
            'image_5' => $this->image_5,
            'active' => $this->active,
        ];
    }

    public static function fromModel(Product $product)
    {
        return new self($product);
    }
}
