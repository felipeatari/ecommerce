<?php

namespace App\Services;

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

            $response = $response->getBody();
            $data = json_decode($response, true);

            return [
                'status' => 'success',
                'data' => $data,
            ];
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse()->getBody();
                $data = json_decode($response, true);
            } else {
                $data = [
                    'message' => 'Erro na requisição: ' . $e->getMessage(),
                ];
            }

            return [
                'status' => 'error',
                'data' => $data,
            ];
        }  catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
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

    public function syncCategoria(?int $categoryId)
    {
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
