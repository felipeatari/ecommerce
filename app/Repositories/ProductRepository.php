<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductRepository
{
    private array $alloweds = ['name'];

    public function filters($query, array $filters)
    {
        foreach ($filters as $key => $value):
            if (!in_array($key, $this->alloweds)) continue;

            if (is_array($value)) {
                $query->whereIn($key, $value);

                continue;
            }

            match ($key) {
                'name' => $query->where('name', 'like', "%$value%"),
                default => $query->where($key, $value),
            };
        endforeach;

        return $query;
    }

    public function getAll(array $filters = [], int $perPage = 10, $columns = [])
    {
        try {
            $query = Product::query();
            $query = $this->filters($query, $filters);

            if (! $columns) {
                $columns = ['*'];
            }

            $data = $query->paginate($perPage, $columns);

            if (! $data->count()) throw new \Exception('Produtos não encontrados', 404);

            return $data;
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            throw $exception;
        }
    }

    public function getOne(?int $id = null)
    {
        try {
            return Product::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {

            throw $exception;
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            throw $exception;
        }
    }

    public function create(array $data)
    {
        DB::beginTransaction();

        try {
            $product = Product::create($data);

            DB::commit();

            return $product;
        } catch (\Exception $exception) {
            DB::rollBack();

            Log::error($exception->getMessage());

            throw $exception;
        }
    }

    public function update(?int $id = null, array $data)
    {
        DB::beginTransaction();

        try {
            $product = $this->getOne($id);
            $product->update($data);

            DB::commit();

            return $product;
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            DB::rollBack();

            Log::error($exception->getMessage());

            throw $exception;
        } catch (\Exception $exception) {
            DB::rollBack();

            Log::error($exception->getMessage());

            throw $exception;
        }
    }

    public function delete(?int $id = null)
    {
        DB::beginTransaction();

        try {
            $product = $this->getOne($id);

            $product->delete();

            DB::commit();

            return $product;
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            DB::rollBack();

            Log::error($exception->getMessage());

            throw $exception;
        } catch (\Exception $exception) {
            DB::rollBack();

            Log::error($exception->getMessage());

            throw $exception;
        }
    }
}
