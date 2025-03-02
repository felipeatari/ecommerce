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

    public function getAll(array $filters = [], int $perPage = 10, array $columns = ['*'])
    {
        $data = $this->productRepository->getAll($filters, $perPage, $columns);

        $items = $data->getCollection()->map(function(Product $product) {
            return ProductDTO::fromModel($product);
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
        $product = $this->productRepository->getOne($id);

        return ProductDTO::fromModel($product)->toArray();
    }

    public function create(array $data)
    {
        $product = $this->productRepository->create($data);
        return ProductDTO::fromModel($product);
    }

    public function update($id, array $data)
    {
        $product = $this->productRepository->update($id, $data);
        return ProductDTO::fromModel($product);
    }

    public function delete($id)
    {
        $this->productRepository->delete($id);
    }
}
