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
        try {
            $data = $this->skuRepository->getOne($id);
            $item = SkuDTO::fromModel($sku);

            return [
                'status' => 'success',
                'code' => 200,
                'data' => $item
            ];
        } catch (ModelNotFoundException $exception) {
            return [
                'status' => 'error',
                'code' => 404,
                'message' => 'Sku não encontrado.',
            ];
        } catch (Exception $exception) {
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
            $data = $this->skuRepository->create($data);
            $item = SkuDTO::fromModel($data);

            return [
                'status' => 'success',
                'code' => 201,
                'message' => 'Sku criado com sucesso.',
                'data' => $item
            ];
        } catch (Exception $exception) {
            return [
                'status' => 'error',
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
            ];
        }
    }

    public function update(?int $id = null, array $data)
    {
        try {
            $data = $this->skuRepository->update($id, $data);
            $item = SkuDTO::fromModel($data);

            return [
                'status' => 'success',
                'code' => 200,
                'message' => 'Sku editado com sucesso.',
                'data' => $item
            ];
        } catch (ModelNotFoundException $exception) {
            return [
                'status' => 'error',
                'code' => 404,
                'message' => 'Sku não encontrado.',
            ];
        } catch (Exception $exception) {
            return [
                'status' => 'error',
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
            ];
        }
    }

    public function remove(?int $id = null)
    {
        try {
            $this->skuRepository->remove($id);

            return [
                'status' => 'success',
                'code' => 200,
                'message' => 'Sku removido com sucesso.',
            ];
        } catch (ModelNotFoundException $exception) {
            return [
                'status' => 'error',
                'code' => 404,
                'message' => 'Sku não encontrado.',
            ];
        } catch (Exception $exception) {
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
            $this->skuRepository->delete($id);

            return [
                'status' => 'success',
                'code' => 200,
                'message' => 'Sku apagado com sucesso.',
            ];
        } catch (ModelNotFoundException $exception) {
            return [
                'status' => 'error',
                'code' => 404,
                'message' => 'Sku não encontrado.',
            ];
        } catch (Exception $exception) {
            return [
                'status' => 'error',
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
            ];
        }
    }
}
