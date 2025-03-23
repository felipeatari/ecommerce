<?php

namespace App\Repositories;

use App\Models\Sku;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SkuRepository
{
    private array $alloweds = ['id', 'product', 'variation_1', 'variation_2'];

    public function filters($query, array $filters)
    {
        foreach ($filters as $key => $value):
            if (!in_array($key, $this->alloweds)) continue;

            if (is_array($value)) {
                $query->whereIn($key, $value);

                continue;
            }

            match ($key) {
                'id' => $query->where('id', $value),
                'product' => $query->whereHas('product', fn ($product) => $product->where('name', 'like', "%$value%")),
                'variation_1' => $query->whereHas('variation1', fn ($variation) => $variation->where('value', 'like', "%$value%")),
                'variation_2' => $query->whereHas('variation2', fn ($variation) => $variation->where('value', 'like', "%$value%")),
                default => $query->where($key, $value),
            };
        endforeach;

        return $query;
    }

    public function getAll(array $filters = [], int $perPage = 10, $columns = [])
    {
        try {
            $query = Sku::query()->orderByDesc('id');
            $query = $this->filters($query, $filters);

            if (! $columns) $columns = ['*'];

            $data = $query->paginate($perPage, $columns);

            if (! $data->count()) throw new Exception('Not found', 404);

            return $data;
        } catch (Exception $exception) {
            Log::error($exception->getMessage());

            throw $exception;
        }
    }

    public function getOne(?int $id = null)
    {
        try {
            return Sku::findOrFail($id);
        } catch (ModelNotFoundException $exception) {

            throw $exception;
        } catch (Exception $exception) {
            Log::error($exception->getMessage());

            throw $exception;
        }
    }

    public function create(array $data)
    {
        DB::beginTransaction();

        try {
            $sku = Sku::create($data);

            DB::commit();

            return $sku;
        } catch (Exception $exception) {
            DB::rollBack();

            Log::error($exception->getMessage());

            throw $exception;
        }
    }

    public function update(?int $id = null, array $data)
    {
        DB::beginTransaction();

        try {
            $sku = $this->getOne($id);

            $sku->update($data);

            DB::commit();

            return $sku;
        } catch (ModelNotFoundException $exception) {
            DB::rollBack();

            Log::error($exception->getMessage());

            throw $exception;
        } catch (Exception $exception) {
            DB::rollBack();

            Log::error($exception->getMessage());

            throw $exception;
        }
    }

    public function remove(?int $id = null)
    {
        DB::beginTransaction();

        try {
            $sku = $this->getOne($id);

            $sku->delete();

            DB::commit();

            return $sku;
        } catch (ModelNotFoundException $exception) {
            DB::rollBack();

            Log::error($exception->getMessage());

            throw $exception;
        } catch (Exception $exception) {
            DB::rollBack();

            Log::error($exception->getMessage());

            throw $exception;
        }
    }

    public function delete(?int $id = null)
    {
        DB::beginTransaction();
        try {
            $sku = $this->getOne($id);

            $sku->delete();

            DB::commit();

            return $sku;
        } catch (ModelNotFoundException $exception) {
            DB::rollBack();

            Log::error($exception->getMessage());

            throw $exception;
        } catch (Exception $exception) {
            DB::rollBack();

            Log::error($exception->getMessage());

            throw $exception;
        }
    }
}
