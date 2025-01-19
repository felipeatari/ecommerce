<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Message;

class ApiViaCepService
{
    private readonly Client $client;

    public function __construct()
    {
        $this->base = 'https://viacep.com.br';

        $this->client = new Client([
            'base_uri' => $this->base,
            'timeout' => 15.0,
        ]);
    }

    public function search(string $cep = '')
    {
        $response = [];

        try {
            $response =  $this->client->get('/ws/' . $cep . '/json/');
            $response = $response->getBody()->getContents();
            $response = json_decode($response, true);
        } catch (ClientException $e) {
            $response = [];
        }

        return $response;
    }
}
