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
    public ?int $created_by;
    public ?int $updated_by;
    public ?int $deleted_by;
    public ?string $created_at;
    public ?string $updated_at;
    public ?string $deleted_at;

    public function __construct(Category $category)
    {
        $this->id = $category['id'];
        $this->name = $category['name'];
        $this->parent = $category['parent'];
        $this->brand = $category['brand'];
        $this->active = $category['active'];
        $this->created_by = $category['created_by'];
        $this->updated_by = $category['updated_by'];
        $this->deleted_by = $category['deleted_by'];
        $this->created_at = $category['created_at'];
        $this->updated_at = $category['updated_at'];
        $this->deleted_at = $category['deleted_at'];
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'parent' => $this->parent,
            'brand' => $this->brand,
            'active' => $this->active,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'deleted_by' => $this->deleted_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }

    public static function fromModel(Category $category)
    {
        return new self($category);
    }
}
