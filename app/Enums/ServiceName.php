<?php

namespace App\Enums;

enum ServiceName: string
{
    case BLING = 'bling';
    case MELHOR_ENVIO = 'melhor_envio';

    public function label(): string
    {
        return match ($this) {
            self::BLING => 'Bling',
            self::MELHOR_ENVIO => 'Melhor Envio'
        };
    }
}
