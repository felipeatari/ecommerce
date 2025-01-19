<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Message;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Psr\Http\Message\RequestInterface;
class ShippingMelhorEnvioService
{
    private string $base;
    private string $token;
    private string $cepFrom;

    private readonly Client $client;

    public function __construct()
    {
        $this->base = 'https://www.melhorenvio.com.br';
        $this->token = config('melhorenvio.token');
        $this->cepFrom = config('melhorenvio.cep');

        $this->client = new Client([
            'base_uri' => $this->base,
            'timeout' => 15.0,
        ]);
    }

    public function calculate(string $cepTo = '', array $product = [])
    {
        $shipping = [];
        $products = [];
        $errorMessage = '';
        $errorContext = [];

        foreach ($product as $productItem):
            $products[] = [
                'id' => $productItem['id'],
                'width' => (float) $productItem['width'],
                'height' => (float) $productItem['height'],
                'length' => (float) $productItem['length'],
                'weight' => (float) $productItem['weight'],
                'insurance_value' => (float) $productItem['price_cart'],
                'quantity' => (int) $productItem['quantity'],
            ];
        endforeach;

        $body = [
            'from' => [
                'postal_code' => $this->cepFrom,
            ],
            'to' => [
                'postal_code' => $cepTo
            ],
            'products' => $products,
            'options' => [
                'receipt' => false,
                'own_hand' => false
            ],
            'services' => '1,2' // Pac e Sedex
        ];

        try {
            $response = $this->client->post('/api/v2/me/shipment/calculate', [
                'json' => $body,
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->token,
                    'User-Agent' => 'cricode@suporte.com.br',
                ],
            ]);

            $response = $response->getBody()->getContents();
            $response = json_decode($response, true);

            $responseErrors = [];
            foreach ($response as $item):
                if (isset($item['error']) and $item['error']) {
                    $responseErrors[] = $item;
                    continue;
                }

                $shipping[] = [
                    'title' => 'Melhor Envio - ' . $item['name'],
                    'slug' => Str::slug('Melhor Envio ' . $item['name']),
                    'name' => $item['name'],
                    'company' => $item['company']['name'],
                    'send_by' => 'Melhor Envio',
                    'price' => $item['price'],
                    'delivery_time' => $item['delivery_time'],
                ];
            endforeach;

            if (! $shipping) {
                throw new \Exception(json_encode($responseErrors));
            }
        } catch (ClientException $e) {
            $errorMessage = 'Melhor Envio - Calcular';
            $errorContext = json_decode($e->getResponse()->getBody()->getContents(), true);
        } catch (\Exception $e) {
            $errorMessage = 'Melhor Envio - Calcular';
            $errorContext = json_decode($e->getMessage(), true);
        }

        if ($errorMessage) {
            Log::error($errorMessage, $errorContext);
        }

        return $shipping;
    }
}
