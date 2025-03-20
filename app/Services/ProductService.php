<?php

namespace App\Services;

use App\DTO\ProductDTO;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductService
{
    public function __construct(
        private ProductRepository $productRepository,
    )
    {
    }

    public function getAll(array $filters = [], int $perPage = 10, array $columns = [])
    {
        try {
            $data = $this->productRepository->getAll($filters, $perPage, $columns);

            if (! $columns) {
                $items = $data->getCollection()->map(fn (Product $product) => ProductDTO::fromModel($product));

                $data->setCollection($items);
            }

            return [
                'status' => 'success',
                'code' => 201,
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
            $data = $this->productRepository->getOne($id);
            $item = ProductDTO::fromModel($data);

            return [
                'status' => 'success',
                'code' => 200,
                'data' => $item
            ];
        } catch (ModelNotFoundException $exception) {
            return [
                'status' => 'error',
                'code' => 404,
                'message' => 'Produto não encontrado.',
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
            $data = $this->productRepository->create($data);
            $item = ProductDTO::fromModel($data);

            return [
                'status' => 'success',
                'code' => 201,
                'message' => 'Produto criado com sucesso.',
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

    public function update($id, array $data)
    {
        try {
            $data = $this->productRepository->update($id, $data);
            $item = ProductDTO::fromModel($data);

            return [
                'status' => 'success',
                'code' => 200,
                'message' => 'Produto criado com sucesso.',
                'data' => $item
            ];
        } catch (ModelNotFoundException $exception) {
            return [
                'status' => 'error',
                'code' => 404,
                'message' => 'Produto não encontrado.',
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
                'message' => 'Produto removido com sucesso.',
            ];
        } catch (ModelNotFoundException $exception) {
            return [
                'status' => 'error',
                'code' => 404,
                'message' => 'Produto não encontrado.',
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
            $this->productRepository->delete($id);

            return [
                'status' => 'success',
                'code' => 200,
                'message' => 'Produto apagado com sucesso.',
            ];
        } catch (ModelNotFoundException $exception) {
            return [
                'status' => 'error',
                'code' => 404,
                'message' => 'Produto não encontrado.',
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
