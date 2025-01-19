<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Log;
use PagarmeApiSDKLib\Authentication\BasicAuthCredentialsBuilder;
use PagarmeApiSDKLib\PagarmeApiSDKClientBuilder;
use PagarmeApiSDKLib\Exceptions\ErrorException;

class PaymentPagarmeService
{
    private string $base;
    private string $user;
    private string $password;

    private readonly Client $client;

    public function __construct()
    {
        $this->base = 'https://api.pagar.me';
        $this->user = config('pagarme.private_key_sandbox');
        $this->password = '';

        $this->client = new Client([
            'base_uri' => $this->base,
            'timeout' => 15.0,
        ]);
    }

    public function cart(array $data = [])
    {
        dd($this->body($data));
        return $this->body($data);

        try {
            $client = $this->client->request('POST', '/core/v5/orders', [
                'headers' => [
                    'Authorization' => 'Basic ' . base64_encode($this->user . ':' . $this->password)
                ],
                'json' => $this->body($data)
            ]);

            $response = json_decode($client->getBody()->getContents(), true);

            return $response;
        } catch (ClientException $e) {
            Log::error('Error Pagarme', [
                'status_code' => $e->getResponse()->getStatusCode(),
                'contents' => json_decode($e->getResponse()->getBody()->getContents(), true),
            ]);

            return [];
        }
    }

    public function body(array $data = [])
    {
        $data['customer']['phone'] = preg_replace('/\D/', '', $data['customer']['phone']);
        // return $data;

        return [
            'closed' => false,
            'customer' => [
                'name' => $data['customer']['name'],
                'type' => 'individual',
                'email' => $data['customer']['email'],
                'document' => $data['customer']['cpf'],
                'address' => [
                    'street' => $data['customer']['address'],
                    'number' => $data['customer']['number'],
                    'complement' => $data['customer']['complement'],
                    'zip_code' => $data['customer']['zipCode'],
                    'neighborhood' => $data['customer']['neighborhood'],
                    'city' => $data['customer']['city'],
                    'state' => $data['customer']['state'],
                    'country' => 'BR'
                ],
                'phones' => [
                    'mobile_phone' => [
                        'country_code' => '55',
                        'area_code' => substr($data['customer']['phone'], 0, 2),
                        'number' => substr($data['customer']['phone'], 2),
                    ]
                ]
            ],
            'items' => [
                [
                    'amount' => 2990,
                    'description' => 'Chaveiro do Tesseract',
                    'quantity' => 1,
                    'code' => 123
                ]
            ],
            'payments' => [
                [
                    'payment_method' => 'credit_card',
                    'credit_card' => [
                        'operation_type' => 'auth_and_capture',
                        'installments' => 1,
                        'statement_descriptor' => 'MARIA JOAQUINA',
                        'card' => [
                            'number' => '5134213964238403',
                            'holder_name' => 'Tony Stark',
                            'exp_month' => 7,
                            'exp_year' => 26,
                            'cvv' => '215',
                            'billing_address' => [
                                'line_1' => $data['customer']['number'] ? $data['customer']['number'] . ', ' : null . $data['customer']['address'] . ', ' . $data['customer']['neighborhood'],
                                'line_2' => $data['customer']['complement'],
                                'zip_code' => $data['customer']['zipCode'],
                                'city' => $data['customer']['city'],
                                'state' => $data['customer']['state'],
                                'country' => 'BR'
                            ]
                        ]
                    ],
                    'manual_billing' => false,
                    'customer' => [
                        'name' => $data['customer']['name'],
                        'type' => 'individual',
                        'email' => $data['customer']['email'],
                        'document' => $data['customer']['cpf'],
                        'address' => [
                            'street' => $data['customer']['address'],
                            'number' => $data['customer']['number'],
                            'complement' => $data['customer']['complement'],
                            'zip_code' => $data['customer']['zipCode'],
                            'neighborhood' => $data['customer']['neighborhood'],
                            'city' => $data['customer']['city'],
                            'state' => $data['customer']['state'],
                            'country' => 'BR'
                        ],
                        'phones' => [
                            'mobile_phone' => [
                                'country_code' => '55',
                                'area_code' => substr($data['customer']['phone'], 0, 2),
                                'number' => substr($data['customer']['phone'], 2),
                            ]
                        ]
                    ],
                ]
            ]
        ];
    }
}
