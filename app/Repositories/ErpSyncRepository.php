<?php

namespace App\Repositories;

use App\Models\ErpSync;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ErpSyncRepository
{
    private array $alloweds = ['id', 'name', 'active'];

    private function filters(object $query, array $filters)
    {
        foreach ($filters as $key => $value):
            if (!in_array($key, $this->alloweds)) continue;

            if (is_array($value)) {
                $query->whereIn($key, $value);

                continue;
            }

            match ($key) {
                'id' => $query->where('id', $value),
                'name' => $query->where('name', 'like', "%$value%"),
                'active' => $query->where('active', $value),
                default => $query->where($key, $value),
            };
        endforeach;

        return $query;
    }

    public function getAll(array $filters = [], int $perPage = 10, array $columns = [])
    {
        try {
            $query = ErpSync::query()->orderByDesc('id');
            $query = $this->filters($query, $filters);

            if (! $columns) $columns = ['*'];

            $data = $query->paginate($perPage, $columns);

            if (! $data->count()) throw new ModelNotFoundException('Not Found', 404);

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
            return ErpSync::findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            Log::error($exception->getMessage());

            throw $exception;
        } catch (Exception $exception) {
            Log::error($exception->getMessage());

            throw $exception;
        }
    }

    public function create(array $data = [])
    {
        DB::beginTransaction();

        try {
            $model = ErpSync::create($data);

            DB::commit();

            return $model;
        } catch (Exception $exception) {
            DB::rollBack();

            Log::error($exception->getMessage());

            throw $exception;
        }
    }

    public function update(?int $id = null, array $data = [])
    {
        DB::beginTransaction();

        try {
            $model = $this->getOne($id);
            $model->update($data);

            DB::commit();

            return $model;
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
            $model = $this->getOne($id);

            $model->delete();

            DB::commit();

            return $model;
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
            $model = $this->getOne($id);

            $model->forceDelete();

            DB::commit();

            return $model;
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
