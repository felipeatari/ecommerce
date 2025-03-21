<?php

namespace App\Repositories;

use App\Models\Variation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VariationRepository
{
    private array $alloweds = ['id', 'type', 'value', 'active'];

    public function filters($query, array $filters)
    {
        foreach ($filters as $key => $value):
            if (!in_array($key, $this->alloweds)) continue;

            if (is_array($value)) {
                $query->whereIn($key, $value);
            } else {
                match ($key) {
                    'type' => $query->where('type', $value),
                    'value' => $query->where('value', 'like', "%$value%"),
                    default => $query->where($key, $value),
                };
            }
        endforeach;

        return $query;
    }

    public function getAll(array $filters = [], int $perPage = 10, $columns = [])
    {
        try {
            $query = Variation::query()->orderByDesc('id');
            $query = $this->filters($query, $filters, $this->alloweds);

            if (! $columns) $columns = ['*'];

            $data = $query->paginate($perPage, $columns, 'pagina');

            if (! $data->count()) throw new \Exception('Not found', 404);

            return $data;
        } catch (ModelNotFoundException $exception) {
            Log::error($exception->getMessage());

            throw $exception;
        } catch (Exception $exception) {
            Log::error($exception->getMessage());

            throw $exception;
        }
    }

    public function getOne(?int $id = null)
    {
        try {
            return Variation::findOrFail($id);
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
            $variation = Variation::create($data);

            DB::commit();

            return $variation;
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
            $variation = $this->getOne($id);
            $variation->update($data);

            DB::commit();

            return $variation;
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

    public function remove(?int $id = null)
    {
        DB::beginTransaction();

        try {
            $variation = $this->getOne($id);

            $variation->delete();

            DB::commit();

            return $variation;
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
            $variation = $this->getOne($id);

            $variation->forceDelete();

            DB::commit();

            return $variation;
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
