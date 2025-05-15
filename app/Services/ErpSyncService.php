<?php

namespace App\Services;

use App\DTO\ErpSyncDTO;
use App\Models\ErpSync;
use App\Repositories\ErpSyncRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ErpSyncService
{
    public function __construct(
        private ErpSyncRepository $erpSyncRepository,
    )
    {
    }

    public function getAll(array $filters = [], int $perPage = 10, array $columns = [])
    {
        try {
            $data = $this->erpSyncRepository->getAll($filters, $perPage, $columns);

            if (! $columns) {
                $items = $data->getCollection()->map(fn (ErpSync $erpSync) => ErpSyncDTO::fromModel($erpSync));

                $data->setCollection($items);
            }

            return [
                'status' => 'success',
                'code' => 200,
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
            $data = $this->erpSyncRepository->getOne($id);
            $item = ErpSyncDTO::fromModel($data);

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
            $data = $this->erpSyncRepository->create($data);
            $item = ErpSyncDTO::fromModel($data);

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
            $data = $this->erpSyncRepository->update($id, $data);
            $item = ErpSyncDTO::fromModel($data);

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
            $this->erpSyncRepository->remove($id);

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
            $this->erpSyncRepository->delete($id);

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
