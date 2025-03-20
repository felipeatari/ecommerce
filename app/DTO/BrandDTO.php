<?php

namespace App\DTO;

use App\Models\Brand;

class BrandDTO
{
    public ?int $id;
    public ?string $name;
    public ?bool $active;

    public function __construct(Brand $brand)
    {
        $this->id = $brand['id'];
        $this->name = $brand['name'];
        $this->active = $brand['active'];
    }

    public function toArray(array $columns = []): array
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'active' => $this->active,
        ];

        return $columns ? array_intersect_key($data, array_flip($columns)) : $data;
    }

    public static function fromModel(Brand $brand)
    {
        return new self($brand);
    }
}
