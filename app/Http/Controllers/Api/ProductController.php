<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private array $rules = [
        'name' => 'required|string|max:255',
        'category_id' => 'required|integer|min:1000',
        // 'brand' => 'required|boolean|max:5',
    ];

    private array $messages = [
        'name.required' => 'Campo Nome obrigatório.',
        'name.string' => 'O Nome é inválido.',
    ];

    public function __construct(
        private ProductService $productService
    )
    {
    }

    public function index(Request $request): JsonResponse
    {
        $filters = $request->all();
        $perPage = $request->get('per_page', 10);
        $columns = $request->get('columns') ? explode(',', $request->get('columns')) : [];

        $data = $this->productService->getAll($filters, $perPage, $columns);

        if ($data['status'] === 'error') {
            $data['code'] = httpStatusCodeError($data['code']);
        }

        return response()->json($data, $data['code']);
    }

    public function show(int $id = null): JsonResponse
    {
        $data = $this->productService->getOne($id);

        if ($data['status'] === 'error') {
            $data['code'] = httpStatusCodeError($data['code']);
        }

        return response()->json($data, $data['code']);
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $inputs = $request->validate($this->rules, $this->messages);

            $data = $this->productService->create($inputs);

            if ($data['status'] === 'error') {
                $data['code'] = httpStatusCodeError($data['code']);
            }

            return response()->json($data, $data['code']);
        } catch (\Illuminate\Validation\ValidationException $exception) {
            return response()->json([
                'status' => 'error',
                'code' => 400,
                'message' => $exception->errors(),
            ], 400);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            $inputs = $request->validate($this->rules, $this->messages);

            $data = $this->productService->update($id, $inputs);

            if ($data['status'] === 'error') {
                $data['code'] = httpStatusCodeError($data['code']);
            }

            return response()->json($data, $data['code']);
        } catch (\Illuminate\Validation\ValidationException $exception) {
            return response()->json([
                'status' => 'error',
                'code' => 400,
                'errors' => $exception->errors(),
            ], 400);
        }
    }

    public function destroy($id): JsonResponse
    {
        $data = $this->productService->delete($id);

        if ($data['status'] === 'error') {
            $data['code'] = httpStatusCodeError($data['code']);
        }

        return response()->json($data, $data['code']);
    }
}
