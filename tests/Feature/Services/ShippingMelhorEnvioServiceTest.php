<?php

namespace Tests\Feature\Services;

use App\Services\ShippingMelhorEnvioService;
use GuzzleHttp\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShippingMelhorEnvioServiceTest extends TestCase
{
    public function test_api(): void
    {
        $response = json_decode((new Client())->get('viacep.com.br/ws/01001000/json/')->getBody()->getContents(), true);

        dump($response);

        $this->assertTrue(true);
    }

    public function test_calculate(): void
    {
        $response = (new ShippingMelhorEnvioService)->calculate('01018020');

        dump($response);

        $this->assertTrue(true);

        // $this->assertEquals(['status' => 'error'], $response);
    }
}
