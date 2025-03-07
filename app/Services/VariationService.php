<?php

namespace App\Services;

use App\DTO\VariationDTO;
use App\Models\Variation;
use App\Repositories\VariationRepository;

class VariationService
{
    public function __construct(
        private VariationRepository $variationRepository,
    )
    {
    }

    public function getAll(array $filters = [], int $perPage = 10, array $columns = ['*'])
    {
        $data = $this->variationRepository->getAll($filters, $perPage, $columns);

        $items = $data->getCollection()->map(function(Variation $variation) {
            return VariationDTO::fromModel($variation);
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
        $variation = $this->variationRepository->getOne($id);

        return VariationDTO::fromModel($variation)->toArray();
    }

    public function create(array $data)
    {
        $variation = $this->variationRepository->create($data);

        return VariationDTO::fromModel($variation);
    }

    public function update($id, array $data)
    {
        $variation = $this->variationRepository->update($id, $data);

        return VariationDTO::fromModel($variation);
    }

    public function delete($id)
    {
        $this->variationRepository->delete($id);
    }
}
