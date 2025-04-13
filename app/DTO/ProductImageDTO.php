<?php

namespace App\DTO;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Variation;

class ProductImageDTO
{
    public ?int $id;
    public ?int $product_id;
    public ?int $variation_id;
    public ?string $image_1;
    public ?string $image_2;
    public ?string $image_3;
    public ?string $image_4;
    public ?string $image_5;
    public ?bool $active;
    private ?Product $product;
    private ?Variation $variation;

    public function __construct(ProductImage $productImage)
    {
        $this->id = $productImage['id'];
        $this->product_id = $productImage['product_id'];
        $this->variation_id = $productImage['variation_id'];
        $this->image_1 = $productImage['image_1'];
        $this->image_2 = $productImage['image_2'];
        $this->image_3 = $productImage['image_3'];
        $this->image_5 = $productImage['image_5'];
        $this->active = $productImage['active'];

        $this->setProduct($productImage['product']);
        $this->setVariation($productImage['variation']);
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

    public static function fromModel(ProductImage $productImage)
    {
        return new self($productImage);
    }
}
