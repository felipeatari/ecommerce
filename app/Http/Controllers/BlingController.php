<?php

namespace App\Http\Controllers;

use App\Services\ServiceTokenService;
use App\Services\BlingService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BlingController extends Controller
{
    public function __construct(
        private BlingService $blingService,
        private ServiceTokenService $serviceTokenService,
    )
    {
    }

    public function auth(Request $request)
    {
        $code = $request->input('code');

        $blingAuth = $this->blingService->auth($code);

        if ($blingAuth['status'] === 'error') {
            return response()->json($blingAuth);
        }

        $data = $this->serviceTokenService->create([
            'service' => 'Bling',
            'access_token' => $blingAuth['data']['access_token'],
            'refresh_token' => $blingAuth['data']['refresh_token'],
            'expires_at' => Carbon::now()->addSeconds($blingAuth['data']['expires_in']),
            'meta' => [],
        ]);

        return response()->json($data);
    }

    public function refreshToken(Request $request)
    {
        $blingRefreshToken = $this->blingService->refreshToken();

        if ($blingRefreshToken['status'] === 'error') {
            return response()->json($blingRefreshToken);
        }

        $data = $this->serviceTokenService->create([
            'service' => 'Bling',
            'access_token' => $blingRefreshToken['data']['access_token'],
            'refresh_token' => $blingRefreshToken['data']['refresh_token'],
            'expires_at' => Carbon::now()->addSeconds($blingRefreshToken['data']['expires_in']),
            'meta' => [],
        ]);

        return response()->json($data);
    }

    public function syncCategoria(?int $categoryId)
    {
        $syncCategoria = $this->blingService->syncCategoria($categoryId);
        dd($syncCategoria);
    }
}
