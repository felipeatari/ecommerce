<?php

namespace App\Services;

use App\DTO\CategoryDTO;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryService
{
    public function __construct(
        private CategoryRepository $categoryRepository,
    )
    {
    }

    public function getAll(array $filters = [], int $perPage = 10, array $columns = [])
    {
        try {
            $data = $this->categoryRepository->getAll($filters, $perPage, $columns);

            $items = $data->getCollection()->map(function (Category $category) use($columns) {
                return CategoryDTO::fromModel($category, $columns);
            });

            return [
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'total' => $data->total(),
                'per_page' => $data->perPage(),
                'links' => $data->appends(request()->query())->links(),
                'data' => $items
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
            $data = $this->categoryRepository->getOne($id);
            $item = CategoryDTO::fromModel($data);

            return [
                'status' => 'success',
                'code' => 200,
                'data' => $item
            ];
        } catch (ModelNotFoundException $exception) {
            return [
                'status' => 'error',
                'code' => 404,
                'message' => 'Produto não encontrado',
            ];
        } catch (Exception $exception) {
            return [
                'status' => 'error',
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
            ];
        }
    }

    public function create(array $data): array
    {
        try {
            $data = $this->categoryRepository->create($data);
            $item = CategoryDTO::fromModel($data);

            return [
                'status' => 'success',
                'code' => 201,
                'message' => 'Produto criado com sucesso',
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
            $data = $this->categoryRepository->update($id, $data);
            $item = CategoryDTO::fromModel($data);

            return [
                'status' => 'success',
                'code' => 200,
                'message' => 'Categoria criado com sucesso',
                'data' => $item
            ];
        } catch (ModelNotFoundException $exception) {
            return [
                'status' => 'error',
                'code' => 404,
                'message' => 'Categoria não encontrado',
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
            $this->categoryRepository->delete($id);

            return [
                'status' => 'success',
                'code' => 200,
                'message' => 'Produto apagado com sucesso.',
            ];
        } catch (ModelNotFoundException $exception) {
            return [
                'status' => 'error',
                'code' => 404,
                'message' => 'Produto não encontrado',
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
