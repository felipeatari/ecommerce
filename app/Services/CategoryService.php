<?php

namespace App\Services;

use App\DTO\CategoryDTO;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use stdClass;

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

            if (! $columns) {
                $items = $data->getCollection()->map(fn (Category $category) => CategoryDTO::fromModel($category));

                $data->setCollection($items);
            }

            return [
                'status' => 'success',
                'code' => 201,
                'data' => $data,
            ];
        } catch (ModelNotFoundException $exception) {
            return [
                'status' => 'error',
                'code' => 404,
                'message' => 'Categorias não encontradas.',
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
                'message' => 'Categoria não encontrada.',
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
                'message' => 'Categoria criado com sucesso.',
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

    public function update(?int $id = null, array $data = [])
    {
        try {
            $data = $this->categoryRepository->update($id, $data);
            $item = CategoryDTO::fromModel($data);

            return [
                'status' => 'success',
                'code' => 200,
                'message' => 'Categoria criado com sucesso.',
                'data' => $item
            ];
        } catch (ModelNotFoundException $exception) {
            return [
                'status' => 'error',
                'code' => 404,
                'message' => 'Categoria não encontrada.',
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
            $this->categoryRepository->remove($id);

            return [
                'status' => 'success',
                'code' => 200,
                'message' => 'Categoria removida com sucesso.',
            ];
        } catch (ModelNotFoundException $exception) {
            return [
                'status' => 'error',
                'code' => 404,
                'message' => 'Categoria não encontrada.',
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
            $this->categoryRepository->delete($id);

            return [
                'status' => 'success',
                'code' => 200,
                'message' => 'Categoria apagado com sucesso.',
            ];
        } catch (ModelNotFoundException $exception) {
            return [
                'status' => 'error',
                'code' => 404,
                'message' => 'Categoria não encontrada.',
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
