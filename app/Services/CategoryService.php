<?php

namespace App\Services;

use App\DTO\CategoryDTO;
use App\Models\Category;
use App\Repositories\CategoryRepository;

class CategoryService
{
    public function __construct(
        private CategoryRepository $categoryRepository,
    )
    {
    }

    public function getAll(array $filters = [], int $perPage = 10, array $columns = ['*'])
    {
        $data = $this->categoryRepository->getAll($filters, $perPage, $columns);

        $items = $data->getCollection()->map(function(Category $category) {
            return CategoryDTO::fromModel($category);
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
        $category = $this->categoryRepository->getOne($id);

        return CategoryDTO::fromModel($category)->toArray();
    }

    public function create(array $data)
    {
        $category = $this->categoryRepository->create($data);

        return CategoryDTO::fromModel($category);
    }

    public function update($id, array $data)
    {
        $category = $this->categoryRepository->update($id, $data);

        return CategoryDTO::fromModel($category);
    }

    public function delete($id)
    {
        $this->categoryRepository->delete($id);
    }
}
