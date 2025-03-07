<?php

namespace App\Services;

use App\DTO\SkuDTO;
use App\Models\Sku;
use App\Repositories\SkuRepository;

class SkuService
{
    public function __construct(
        private SkuRepository $skuRepository,
    )
    {
    }

    public function getAll(array $filters = [], int $perPage = 10, array $columns = ['*'])
    {
        $data = $this->skuRepository->getAll($filters, $perPage, $columns);

        $items = $data->getCollection()->map(function(Sku $sku) {
            return SkuDTO::fromModel($sku);
        });

        return [
            'current_page' => $data->currentPage(),
            'last_page' => $data->lastPage(),
            'total' => $data->total(),
            'per_page' => $data->perPage(),
            'links' => $data->appends(request()->query())->links(),
            'data' => $items
        ];
    }

    public function getOne(?int $id = null)
    {
        $sku = $this->skuRepository->getOne($id);

        return SkuDTO::fromModel($sku)->toArray();
    }

    public function create(array $data)
    {
        $sku = $this->skuRepository->create($data);

        return SkuDTO::fromModel($sku);
    }

    public function update($id, array $data)
    {
        $sku = $this->skuRepository->update($id, $data);

        return SkuDTO::fromModel($sku);
    }

    public function delete($id)
    {
        $this->skuRepository->delete($id);
    }
}
