<?php

namespace App\DTO;

use App\Models\ErpSync;

class ErpSyncDTO
{
    public ?int $id;
    public ?string $name;
    public ?bool $active;

    public function __construct(ErpSync $erpSync)
    {
        $this->id = $erpSync['id'];
        $this->name = $erpSync['name'];
        $this->active = $erpSync['active'];
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

    public static function fromModel(ErpSync $erpSync)
    {
        return new self($erpSync);
    }
}
