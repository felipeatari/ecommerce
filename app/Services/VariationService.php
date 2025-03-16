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

    public function getAll(array $filters = [], int $perPage = 10, array $columns = [])
    {
        try {
            $data = $this->variationRepository->getAll($filters, $perPage, $columns);

            $items = $data->getCollection()->map(fn (Product $product) => ProductDTO::fromModel($product));

            return [
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'total' => $data->total(),
                'per_page' => $data->perPage(),
                'links' => $data->appends(request()->query())->links(),
                'data' => $items
            ];
        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
            ];
        }
    }

    public function getOne(?int $id = null)
    {
        try {
            $data = $this->variationRepository->getOne($id);
            $item = ProductDTO::fromModel($data);

            return [
                'status' => 'success',
                'code' => 200,
                'data' => $item
            ];
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return [
                'status' => 'error',
                'code' => 404,
                'message' => 'Variação não encontrada',
            ];
        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
            ];
        }
    }

    public function create(array $data)
    {
        try {
            $data = $this->variationRepository->create($data);
            $item = ProductDTO::fromModel($data);

            return [
                'status' => 'success',
                'code' => 201,
                'message' => 'Variação criada com sucesso',
                'data' => $item
            ];
        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
            ];
        }
    }

    public function update($id, array $data)
    {
        try {
            $data = $this->variationRepository->update($id, $data);
            $item = ProductDTO::fromModel($data);

            return [
                'status' => 'success',
                'code' => 200,
                'message' => 'Variação criada com sucesso',
                'data' => $item
            ];
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return [
                'status' => 'error',
                'code' => 404,
                'message' => 'Variação não encontrada',
            ];
        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
            ];
        }
    }

    public function delete($id)
    {
        try {
            $this->variationRepository->delete($id);

            return [
                'status' => 'success',
                'code' => 200,
                'message' => 'Variação apagada com sucesso.',
            ];
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return [
                'status' => 'error',
                'code' => 404,
                'message' => 'Variação não encontrada',
            ];
        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
            ];
        }
    }
}
