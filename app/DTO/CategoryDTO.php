<?php

namespace App\DTO;

use App\Models\Category;

class CategoryDTO
{
    public ?int $id;
    public ?string $name;
    public ?bool $parent;
    public ?bool $brand;
    public ?bool $active;

    public function __construct(Category $category)
    {
        $this->id = $category['id'];
        $this->name = $category['name'];
        $this->parent = $category['parent'];
        $this->brand = $category['brand'];
        $this->active = $category['active'];
    }

    public function toArray(array $columns = []): array
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'parent' => $this->parent,
            'brand' => $this->brand,
            'active' => $this->active,
        ];

        return $columns ? array_intersect_key($data, array_flip($columns)) : $data;
    }

    public static function fromModel(Category $category)
    {
        return new self($category);
    }
}
