<?php

namespace App\Services;

use App\DTO\SkuDTO;
use App\Models\Sku;
use App\Repositories\SkuRepository;
use Exception;

class SkuService
{
    public function __construct(
        private SkuRepository $skuRepository,
    )
    {
    }

    public function getAll(array $filters = [], int $perPage = 10, array $columns = ['*'])
    {
        try {
            $data = $this->skuRepository->getAll($filters, $perPage, $columns);

            if (! $columns) {
                $items = $data->getCollection()->map(fn (Sku $sku) => SkuDTO::fromModel($sku));

                $data->setCollection($items);
            }

            return [
                'status' => 'success',
                'code' => 200,
                'data' => $data,
            ];
        } catch (Exception $exception) {
            return [
                'status' => 'error',
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
            ];
        }
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
