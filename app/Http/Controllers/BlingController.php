<?php

namespace App\Http\Controllers;

use App\Models\ServiceToken;
use App\Services\ServiceTokenService;
use App\Services\BlingService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BlingController extends Controller
{
    public function __construct(
        private ?string $clientId,
        private ?string $clientSecret,
        private ?string $baseUrl,
        private BlingService $blingService,
        private ServiceTokenService $serviceTokenService,
    )
    {
        $this->clientId = config('bling.client_id');
        $this->clientSecret = config('bling.client_secret');
        $this->baseUrl = config('bling.base_url');
    }

    public function auth(Request $request)
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept' => '1.0',
            'Authorization' => 'Basic ' . base64_encode($this->clientId . ':' . $this->clientSecret),
        ];

        $body = [
            'grant_type' => 'authorization_code',
            'code' => $request->input('code'),
        ];

        $endpoint = $this->baseUrl . '/oauth/token';

        $blingAuth = $this->blingService->auth($endpoint, $headers, $body);

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
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept' => '1.0',
            'Authorization' => 'Basic ' . base64_encode($this->clientId . ':' . $this->clientSecret),
        ];

        $serviceToken = $this->serviceTokenService->getOne(['service' => 'Bling']);

        if ($serviceToken['status'] === 'error') {
            return response()->json(['error' => 'Não existe token']);
        }

        $refreshToken = $serviceToken['data']?->refresh_token ?? null;

        $body = [
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
        ];

        $endpoint = $this->baseUrl . '/oauth/token';

        $blingRefreshToken = $this->blingService->auth($endpoint, $headers, $body);

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

    public function syncCategoria(Request $request)
    {
    }
}
