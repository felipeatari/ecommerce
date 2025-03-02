<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private array $rules = [
        'name' => 'required|string|unique:categories|max:255',
        'brand' => 'required|boolean|max:5',
    ];

    private array $messages = [
        'name.required' => 'Campo Nome obrigatório.',
        'name.string' => 'O Nome é inválido.',
        'name.unique' => 'Já existe uma Produto comesse nome.',
        'brand.required' => 'Campo Marca obrigatório.',
        'brand.boolean' => 'O Marca é inválido.',
    ];

    public function __construct(
        private ProductService $productService
    )
    {
    }

    public function index(Request $request)
    {
        try {
            $filters = $request->all();
            $perPage = $request->get('per_page', 10);

            $data = [
                'status' => 'success',
                'code' => 200,
            ];

            $data = array_merge($data, $this->productService->getAll($filters, $perPage));

            return response()->json($data);
        } catch (\Exception $exception) {
            $code = $exception->getCode();

            if ($code != 404) $code = 500;

            return response()->json([
                'status' => 'error',
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
            ], $code);
        }
    }

    public function show(int $id = null)
    {
        try {
            return response()->json($this->productService->getOne($id));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return response()->json([
                'status' => 'error',
                'code' => 404,
                'message' => 'Produto não encontrado',
            ], 404);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 'error',
                'code' => 500,
                'message' => $exception->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $data = $request->validate($this->rules, $this->messages);

            $this->productService->create($data);

            return response()->json([
                'status' => 'success',
                'code' => 201,
                'message' => 'Produto criado com Sucesso',
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $exception) {
            return response()->json([
                'status' => 'error',
                'code' => 400,
                'message' => $exception->errors(),
            ], 400);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 'error',
                'code' => 500,
                'message' => $exception->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            $data = $request->validate($this->rules, $this->messages);

            $this->productService->update($id, $data);

            return response()->json([
                'status' => 'success',
                'code' => 201,
                'message' => 'Produto atualizado com Sucesso',
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $exception) {
            return response()->json([
                'status' => 'error',
                'code' => 400,
                'errors' => $exception->errors(),
            ], 400);
        }  catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return response()->json([
                'status' => 'error',
                'code' => 404,
                'message' => 'Produto não encontrado',
            ], 404);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 'error',
                'code' => 500,
                'message' => $exception->getMessage(),
            ], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $this->productService->delete($id);

            return response()->json([
                'status' => 'success',
                'code' => 201,
                'message' => 'Produto apagado com sucesso.',
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $exception) {
            return response()->json([
                'status' => 'error',
                'code' => 400,
                'errors' => $exception->errors(),
            ], 400);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return response()->json([
                'status' => 'error',
                'code' => 404,
                'message' => 'Produto não encontrado',
            ], 404);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 'error',
                'code' => 500,
                'message' => $exception->getMessage(),
            ], 500);
        }
    }
}
