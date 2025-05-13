<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Exception;
use Illuminate\Support\Facades\Log;

class BlingService
{
    public function auth($enpoint = '', $headers = [], $body = [])
    {
        $client = new Client();

        try {
            $response = $client->post($enpoint, [
                'headers' => $headers,
                'form_params' => $body,
            ]);

            $response = $response->getBody();
            $data = json_decode($response, true);

            Log::debug('Token Bling', $data);

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
                'data' => [
                    'message' => 'Erro na requisição: ' . $e->getMessage(),
                ],
            ];
        }
    }

    public function refreshToken($enpoint = '', $headers = [], $body = [])
    {
        $client = new Client();

        try {
            $response = $client->post($enpoint, [
                'headers' => $headers,
                'form_params' => $body,
            ]);

            $response = $response->getBody();
            $data = json_decode($response, true);

            Log::debug('Token Bling', $data);

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
                'data' => [
                    'message' => 'Erro na requisição: ' . $e->getMessage(),
                ],
            ];
        }
    }
}
