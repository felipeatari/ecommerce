<?php

namespace App\Repositories;

use App\Models\ServiceToken;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ServiceTokenRepository
{
    private array $alloweds = ['id', 'service', 'access_token', 'refresh_token'];

    public function filters($query, array $filters)
    {
        foreach ($filters as $key => $value):
            if (!in_array($key, $this->alloweds)) continue;

            if (is_array($value)) {
                $query->whereIn($key, $value);
            } else {
                match ($key) {
                    'service' => $query->where('service', $value),
                    'access_token' => $query->where('access_token', $value),
                    'refresh_token' => $query->where('refresh_token', $value),
                    default => $query->where($key, $value),
                };
            }
        endforeach;

        return $query;
    }

    public function getAll(array $filters = [], int $perPage = 10, $columns = [])
    {
        try {
            $query = ServiceToken::query()->orderByDesc('id');
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

    public function getOne(array $filters = [])
    {
        try {
            $query = ServiceToken::query()->orderByDesc('id');
            $query = $this->filters($query, $filters, $this->alloweds);

            $data = $query->first();

            if (! $data) throw new \Exception('Not found', 404);

            return $data;
        } catch (ModelNotFoundException $exception) {
            Log::error($exception->getMessage());

            throw $exception;
        } catch (Exception $exception) {
            Log::error($exception->getMessage());

            throw $exception;
        }
    }

    public function getById(?int $id = null)
    {
        try {
            return ServiceToken::findOrFail($id);
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
            $serviceToken = ServiceToken::updateOrCreate(
                ['service' => $data['service']], $data
            );

            DB::commit();

            return $serviceToken;
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
            $serviceToken = $this->getOne($id);

            $serviceToken->forceDelete();

            DB::commit();

            return $serviceToken;
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
