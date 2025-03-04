<?php

namespace App\DTO;

use App\Models\Category;
use App\Models\Product;

class ProductDTO
{
    public ?int $id;
    public ?int $category_id;
    public ?int $brand_id;
    public ?string $name;
    public ?string $description;
    public ?string $slug;
    public ?bool $active;
    private ?Category $category;

    public function __construct(Product $product)
    {
        $this->id = $product['id'];
        $this->category_id = $product['category_id'];
        $this->brand_id = $product['brand_id'];
        $this->name = $product['name'];
        $this->description = $product['description'];
        $this->slug = $product['slug'];
        $this->active = $product['active'];

        $this->setCategory($product['category']);
    }

    private function setCategory(?Category $category = null)
    {
        $this->category = $category;
    }

    public function getCategory($columns = [])
    {
        return $this->category;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'brand_id' => $this->brand_id,
            'name' => $this->name,
            'description' => $this->description,
            'slug' => $this->slug,
            'active' => $this->active,
        ];
    }

    public static function fromModel(Product $product)
    {
        return new self($product);
    }
}
