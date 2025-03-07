<?php

namespace App\DTO;

use App\Models\Variation;

class VariationDTO
{
    public ?int $id;
    public ?string $type;
    public ?string $value;
    public ?string $code;
    public ?string $extra;
    public ?bool $active;

    public function __construct(Variation $variation)
    {
        $this->id = $variation['id'];
        $this->type = $variation['type'];
        $this->value = $variation['value'];
        $this->code = $variation['code'];
        $this->extra = $variation['extra'];
        $this->active = $variation['active'];
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'value' => $this->value,
            'code' => $this->code,
            'extra' => $this->extra,
            'active' => $this->active,
        ];
    }

    public static function fromModel(Variation $variation)
    {
        return new self($variation);
    }
}
