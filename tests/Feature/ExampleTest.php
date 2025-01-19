<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Enums\OrderStatus;
use App\Enums\UserLevel;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_order_status()
    {
        $result = match (2) {
            OrderStatus::Pending->value => 'Aguardando pagamento',
            OrderStatus::Confirmed->value => 'Pagamento confirmado',
            OrderStatus::Sent->value => 'Pedido enviado',
            OrderStatus::Completed->value => 'Pedido concluído',
            OrderStatus::Canceled->value => 'Pedido cancelado',
            default => 'Não informado'
        };

        dump($result);

        $this->assertTrue(true);
    }
}
