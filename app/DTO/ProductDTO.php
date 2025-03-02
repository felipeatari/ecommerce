<?php

namespace App\DTO;

use App\Models\Product;

class ProductDTO
{
    public ?int $id;
    public ?int $category_id;
    public ?string $name;
    public ?string $description;
    public ?string $slug;
    public ?int $brand;
    public ?bool $active;

    public function __construct(Product $product)
    {
        $this->id = $product['id'];
        $this->category_id = $product['category_id'];
        $this->name = $product['name'];
        $this->description = $product['description'];
        $this->slug = $product['slug'];
        $this->brand = $product['brand'];
        $this->active = $product['active'];
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'name' => $this->name,
            'description' => $this->description,
            'slug' => $this->slug,
            'brand' => $this->brand,
            'active' => $this->active,
        ];
    }

    public static function fromModel(Product $product)
    {
        return new self($data);
    }
}
