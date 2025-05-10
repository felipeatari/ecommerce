<?php

namespace App\DTO;

use App\Models\ServiceToken;

class ServiceTokenDTO
{
    public ?int $id;
    public ?string $service;
    public ?string $access_token;
    public ?string $refresh_token;
    public ?string $expires_at;

    public function __construct(ServiceToken $serviceToken)
    {
        $this->id = $serviceToken['id'];
        $this->service = $serviceToken['service'];
        $this->access_token = $serviceToken['access_token'];
        $this->refresh_token = $serviceToken['refresh_token'];
        $this->expires_at = $serviceToken['expires_at'];
    }

    public function toArray(array $columns = []): array
    {
        $data = [
            'id' => $this->id,
            'service' => $this->service,
            'access_token' => $this->access_token,
            'refresh_token' => $this->refresh_token,
            'expires_at' => $this->expires_at,
        ];

        return $columns ? array_intersect_key($data, array_flip($columns)) : $data;
    }

    public static function fromModel(ServiceToken $serviceToken)
    {
        return new self($serviceToken);
    }
}
