<?php

namespace App\Services;

use App\DTO\ProductDTO;
use App\Models\Product;
use App\Repositories\ProductRepository;

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
            $data = $this->productRepository->getOne($id);
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
                'message' => 'Produto não encontrado',
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
            $data = $this->productRepository->create($data);
            $item = ProductDTO::fromModel($data);

            return [
                'status' => 'success',
                'code' => 201,
                'message' => 'Produto criado com Sucesso',
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
            $data = $this->productRepository->update($id, $data);
            $item = ProductDTO::fromModel($data);

            return [
                'status' => 'success',
                'code' => 200,
                'message' => 'Produto criado com Sucesso',
                'data' => $item
            ];
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return [
                'status' => 'error',
                'code' => 404,
                'message' => 'Produto não encontrado',
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
            $this->productRepository->delete($id);

            return [
                'status' => 'success',
                'code' => 200,
                'message' => 'Produto apagado com sucesso.',
            ];
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return [
                'status' => 'error',
                'code' => 404,
                'message' => 'Produto não encontrado',
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
