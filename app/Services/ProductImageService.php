<?php

namespace App\Services;

use App\DTO\ProductImageDTO;
use App\Models\Product;
use App\Models\ProductImage;
use App\Repositories\ProductImageRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductImageService
{
    public function __construct(
        private ProductImageRepository $productImageRepository,
    )
    {
    }

    public function getAll(array $filters = [], int $perPage = 10, array $columns = [])
    {
        try {
            $data = $this->productImageRepository->getAll($filters, $perPage, $columns);

            if (! $columns) {
                $items = $data->getCollection()->map(fn (ProductImage $productImage) => ProductImageDTO::fromModel($productImage));

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
            $data = $this->productImageRepository->getOne($id);
            $item = ProductImageDTO::fromModel($data);

            return [
                'status' => 'success',
                'code' => 200,
                'data' => $item
            ];
        } catch (ModelNotFoundException $exception) {
            return [
                'status' => 'error',
                'code' => 404,
                'message' => 'Imagem do produto não encontrado.',
            ];
        } catch (Exception $exception) {
            return [
                'status' => 'error',
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
            ];
        }
    }

    public function getFirst(array $filters = [])
    {
        try {
            $data = $this->productImageRepository->getFirst($filters);

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

    public function create(array $data)
    {
        try {
            $data = $this->productImageRepository->create($data);
            $item = ProductImageDTO::fromModel($data);

            return [
                'status' => 'success',
                'code' => 201,
                'message' => 'Imagem do produto criado com sucesso.',
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
            $data = $this->productImageRepository->update($id, $data);
            $item = ProductImageDTO::fromModel($data);

            return [
                'status' => 'success',
                'code' => 200,
                'message' => 'Imagem do produto editado com sucesso.',
                'data' => $item
            ];
        } catch (ModelNotFoundException $exception) {
            return [
                'status' => 'error',
                'code' => 404,
                'message' => 'Imagem do produto não encontrado.',
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
                'message' => 'Imagem do produto removido com sucesso.',
            ];
        } catch (ModelNotFoundException $exception) {
            return [
                'status' => 'error',
                'code' => 404,
                'message' => 'Imagem do produto não encontrado.',
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
            $this->productImageRepository->delete($id);

            return [
                'status' => 'success',
                'code' => 200,
                'message' => 'Imagem do produto apagado com sucesso.',
            ];
        } catch (ModelNotFoundException $exception) {
            return [
                'status' => 'error',
                'code' => 404,
                'message' => 'Imagem do produto não encontrado.',
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
