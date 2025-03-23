<?php

namespace App\Services;

use App\DTO\BrandDTO;
use App\Models\Brand;
use App\Repositories\BrandRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use stdClass;

class BrandService
{
    public function __construct(
        private BrandRepository $brandRepository,
    )
    {
    }

    public function getAll(array $filters = [], int $perPage = 10, array $columns = [])
    {
        try {
            $data = $this->brandRepository->getAll($filters, $perPage, $columns);

            if (! $columns) {
                $items = $data->getCollection()->map(fn (Brand $brand) => BrandDTO::fromModel($brand));

                $data->setCollection($items);
            }

            return [
                'status' => 'success',
                'code' => 200,
                'data' => $data,
            ];
        } catch (ModelNotFoundException $exception) {
            return [
                'status' => 'error',
                'code' => 404,
                'message' => 'Marcas não encontradas.',
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
            $data = $this->brandRepository->getOne($id);
            $item = BrandDTO::fromModel($data);

            return [
                'status' => 'success',
                'code' => 200,
                'data' => $item
            ];
        } catch (ModelNotFoundException $exception) {
            return [
                'status' => 'error',
                'code' => 404,
                'message' => 'Marca não encontrada.',
            ];
        }
    }

    public function create(array $data): array
    {
        try {
            $data = $this->brandRepository->create($data);
            $item = BrandDTO::fromModel($data);

            return [
                'status' => 'success',
                'code' => 201,
                'message' => 'Marca criado com sucesso.',
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

    public function update(?int $id, array $data)
    {
        try {
            $data = $this->brandRepository->update($id, $data);
            $item = BrandDTO::fromModel($data);

            return [
                'status' => 'success',
                'code' => 200,
                'message' => 'Marca criado com sucesso.',
                'data' => $item
            ];
        } catch (ModelNotFoundException $exception) {
            return [
                'status' => 'error',
                'code' => 404,
                'message' => 'Marca não encontrada.',
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
            $this->brandRepository->remove($id);

            return [
                'status' => 'success',
                'code' => 200,
                'message' => 'Marca removida com sucesso.',
            ];
        } catch (ModelNotFoundException $exception) {
            return [
                'status' => 'error',
                'code' => 404,
                'message' => 'Marca não encontrada.',
            ];
        } catch (Exception $exception) {
            return [
                'status' => 'error',
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
            ];
        }
    }

    public function delete(?int $id = null)
    {
        try {
            $this->brandRepository->delete($id);

            return [
                'status' => 'success',
                'code' => 200,
                'message' => 'Marca apagado com sucesso.',
            ];
        } catch (ModelNotFoundException $exception) {
            return [
                'status' => 'error',
                'code' => 404,
                'message' => 'Marca não encontrada.',
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
