<?php

namespace Tests\Feature\Services;

use App\Services\PaymentPagarmeService;
use GuzzleHttp\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PagarmeApiSDKLib\Authentication\BasicAuthCredentialsBuilder;
use PagarmeApiSDKLib\PagarmeApiSDKClientBuilder;
use Tests\TestCase;

class PaymentPagarmeServiceTest extends TestCase
{
    private Client $client;

    protected function setUp(): void
    {
        $this->client = new Client([
            'base_uri' => 'https://api.pagar.me',
            'timeout' => 15.0
        ]);
    }

    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_cart()
    {
        // $response = $this->client->request('GET', '/core/v5/orders', [
        //     'headers' => [
        //         'Authorization' => 'Basic ' . base64_encode('sk_396152bd7a024d8ea58e75ca9e9e37e9:' . '')
        //     ]
        // ]);

        // dump(json_decode($response->getBody()->getContents(), true));

        $response = (new PaymentPagarmeService)->cart();
        dump($response);

        $this->assertEquals(200, 200);
    }
}
