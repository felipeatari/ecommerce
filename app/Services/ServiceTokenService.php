<?php

namespace App\Services;

use App\DTO\ServiceTokenDTO;
use App\Models\ServiceToken;
use App\Repositories\ServiceTokenRepository;

class ServiceTokenService
{
    public function __construct(
        private ServiceTokenRepository $serviceTokenRepository,
    )
    {
    }

    public function getAll(array $filters = [], int $perPage = 10, array $columns = [])
    {
        try {
            $data = $this->serviceTokenRepository->getAll($filters, $perPage, $columns);

            if (! $columns) {
                $items = $data->getCollection()->map(fn (ServiceToken $serviceToken) => ServiceTokenDTO::fromModel($serviceToken));

                $data->setCollection($items);
            }

            return [
                'status' => 'success',
                'code' => 201,
                'data' => $data,
            ];
        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
            ];
        }
    }

    public function getOne(array $filters = [])
    {
        try {
            $data = $this->serviceTokenRepository->getOne($filters);
            $item = ServiceTokenDTO::fromModel($data);

            return [
                'status' => 'success',
                'code' => 200,
                'data' => $item
            ];
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return [
                'status' => 'error',
                'code' => 404,
                'message' => 'Token do serviço não encontrada',
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
            $data = $this->serviceTokenRepository->create($data);
            $item = ServiceTokenDTO::fromModel($data);

            return [
                'status' => 'success',
                'code' => 201,
                'message' => 'Token do serviço criada com sucesso',
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

    public function delete($id)
    {
        try {
            $this->serviceTokenRepository->delete($id);

            return [
                'status' => 'success',
                'code' => 200,
                'message' => 'Token do serviço apagada com sucesso.',
            ];
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return [
                'status' => 'error',
                'code' => 404,
                'message' => 'Token do serviço não encontrada',
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
