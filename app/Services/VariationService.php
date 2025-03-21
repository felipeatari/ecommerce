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

            if (! $columns) {
                $items = $data->getCollection()->map(fn (Variation $variation) => VariationDTO::fromModel($variation));

                $data->setCollection($items);
            }

            return [
                'status' => 'success',
                'code' => 201,
                'data' => $data,
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
            $item = VariationDTO::fromModel($data);

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
            $item = VariationDTO::fromModel($data);

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
            $item = VariationDTO::fromModel($data);

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
