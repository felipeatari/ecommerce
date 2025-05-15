<?php

namespace App\Services;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Exception;
use Illuminate\Support\Facades\Log;

class BlingService
{
    public function __construct(
        private ?string $clientId,
        private ?string $clientSecret,
        private ?string $baseUrl,
        private Client $client,
        private ServiceTokenService $serviceTokenService,
    )
    {
        $this->clientId = config('bling.client_id');
        $this->clientSecret = config('bling.client_secret');
        $this->baseUrl = config('bling.base_url');
    }

    public function req($enpoint = '', $options = [], $method = '')
    {
        try {
            if ($method === 'get') {
                $response = $this->client->get($enpoint, $options);
            }
            elseif ($method === 'post') {
                $response = $this->client->post($enpoint, $options);
            }
            elseif ($method === 'put') {
                $response = $this->client->put($enpoint, $options);
            }
            elseif ($method === 'patch') {
                $response = $this->client->patch($enpoint, $options);
            }
            elseif ($method === 'delete') {
                $response = $this->client->delete($enpoint, $options);
            }
            else {
                throw new Exception('Método HTTP não informado', 400);
            }

            $statusCode = $response->getStatusCode();
            $body = $response->getBody();
            $data = json_decode($body, true);

            return [
                'status' => 'success',
                'code' => $statusCode,
                'data' => $data,
            ];
        } catch (RequestException $exception) {
            $error = ['status' => 'error'];

            if ($exception->hasResponse()) {
                $body = $exception->getResponse()->getBody();
                $data = json_decode($body, true);

                $error['code'] = httpStatusCodeError($exception->getCode());
                $error['message'] = '';
                $error['errors'] = $data['error'] ?? $data;
            } else {
                $error['code'] = httpStatusCodeError($exception->getCode());
                $error['message'] = 'Erro na requisição: ' . $exception->getMessage();
                $error['errors'] = [];
            }

            return $error;
        }  catch (Exception $exception) {
            return [
                'status' => 'error',
                'code' => httpStatusCodeError($exception->getCode()),
                'message' => $exception->getMessage(),
                'errors' => [],
            ];
        }
    }

    public function auth($code = '')
    {
        $endpoint = $this->baseUrl . '/oauth/token';

        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept' => '1.0',
            'Authorization' => 'Basic ' . base64_encode($this->clientId . ':' . $this->clientSecret),
        ];

        $body = [
            'grant_type' => 'authorization_code',
            'code' => $code,
        ];

        $options = [
            'headers' => $headers,
            'form_params' => $body,
        ];

        return $this->req($endpoint, $options, 'post');
    }

    public function refreshToken(string $refreshToken = '')
    {
        if (! $refreshToken) {
            $serviceToken = $this->serviceTokenService->getOne(['service' => 'Bling']);

            if ($serviceToken['status'] === 'error') {
                return [
                    'status' => 'error',
                    'message' => 'Não existe token',
                ];
            }

            $refreshToken = $serviceToken['data']?->refresh_token ?? null;
        }

        $endpoint = $this->baseUrl . '/oauth/token';

        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept' => '1.0',
            'Authorization' => 'Basic ' . base64_encode($this->clientId . ':' . $this->clientSecret),
        ];

        $body = [
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
        ];

        $options = [
            'headers' => $headers,
            'form_params' => $body,
        ];

        return $this->req($endpoint, $options, 'post');
    }

    private function verifyToken()
    {
        $serviceToken = $this->serviceTokenService->getOne(['service' => 'Bling']);

        if ($serviceToken['status'] === 'error') {
            return false;
        }

        $expiresAt = $serviceToken['data']->expires_at;
        $date = Carbon::parse($expiresAt);

        if ($date->isPast()) {
            $refreshToken = $serviceToken['data']?->refresh_token;

            $blingRefreshToken = $this->refreshToken($refreshToken);

            if ($blingRefreshToken['status'] === 'error') {
                return false;
            }

            $serviceToken = $this->serviceTokenService->create([
                'service' => 'Bling',
                'access_token' => $blingRefreshToken['data']['access_token'],
                'refresh_token' => $blingRefreshToken['data']['refresh_token'],
                'expires_at' => Carbon::now()->addSeconds($blingRefreshToken['data']['expires_in']),
                'meta' => [],
            ]);

            $accessToken = $serviceToken['data']->access_token;
        } else {
            $accessToken = $serviceToken['data']->access_token;
        }

        return $accessToken;
    }

    public function syncCategoria(?int $categoryId)
    {
        $token = $this->verifyToken();
        dd($token);

        $endpoint = $this->baseUrl . '/categorias/produtos';

        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . base64_encode($this->clientId . ':' . $this->clientSecret),
        ];

        $body = [
            'descricao' => 'Eletrônicos',
        ];

        $options = [
            'headers' => $headers,
            'form_params' => $body,
        ];

        dd($body);

        return $this->req($endpoint, $options, 'post');
    }
}
