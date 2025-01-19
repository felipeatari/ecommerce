<?php

namespace App\Livewire\Cart;

use App\Enums\OrderStatus as OrderStatusEnum;
use App\Enums\PaymentType;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderStatus;
use App\Services\PaymentPagarmeService;
use Illuminate\Support\Facades\Auth;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Stripe\StripeClient;
use Livewire\Component;

class Confirm extends Component
{
    public array $customer = [];
    public array $shipping = [];
    public array $product = [];

    public int $payment = 0;
    public int $installment = 0;

    public function mount()
    {
        if (! Auth::id()) {
            return $this->redirect(route('login'));
        }

        if (! session()->exists('cart.product') or ! session()->get('cart.product')) {
            $this->redirect(route('cart.index'));
        }

        $this->product = session()->get('cart.product');

        if (! session()->exists('cart.customer')) {
            return $this->redirect(route('cart.index'));
        }

        if (session()->exists('cart.customer')) {
            $this->customer = session()->get('cart.customer');
        }

        if (session()->exists('cart.shipping')) {
            $this->shipping = session()->get('cart.shipping');
        }
    }

    public function checkout()
    {
        if (! $this->payment) {
            return $this->js('alert("Escolha um método de pagamento.")');
        }

        $paymentType = match ($this->payment) {
            PaymentType::Pix->value => 'Pix',
            PaymentType::Cart->value => 'Cartão de Crédito',
        };

        $cart = session()->get('cart');

        // return (new PaymentPagarmeService)->cart($cart);

        $orderStatus = OrderStatusEnum::Pending->value;

        $order = Order::create([
            'user_id' => Auth::id(),
            'name' => $cart['customer']['name'],
            'email' => $cart['customer']['email'],
            'phone' => $cart['customer']['phone'],
            'cpf' => $cart['customer']['cpf'],
            'status' => $orderStatus,
            'subtotal' => $cart['subtotal'],
            'discount' => 0,
            'total' => $cart['total'],
            'payment_gateway' => 'Pagar.me',
            'payment_type' => $paymentType,
            'payment_installment' => $this->installment,
            'shipping_name' => $cart['shipping']['name'],
            'shipping_price' => $cart['shipping']['price'],
            'shipping_delivery_time' => $cart['shipping']['delivery_time'],
            'delivery_city' => $cart['customer']['city'],
            'delivery_state' => $cart['customer']['state'],
            'delivery_neighborhood' => $cart['customer']['neighborhood'],
            'delivery_address' => $cart['customer']['address'],
            'delivery_number' => $cart['customer']['number'],
            'delivery_complement' => $cart['customer']['complement'],
            'delivery_note' => $cart['customer']['note'],
        ]);

        OrderStatus::create([
            'order_id' => $order->id,
            'status' => $orderStatus,
        ]);

        // foreach ($cart['product'] as $product):
        //     OrderProduct::create([
        //         'order_id' => $order->id,
        //         'product_id' => $product['id'],
        //         'sku_id' => $product['sku_id'],
        //         'name' => $product['name'],
        //         'price_un' => $product['price'] * 100,
        //         'price_total' => ($product['price'] * $product['quantity']) * 100,
        //         'quantity' => $product['quantity'],
        //         'color' => $product['color'],
        //         'size' => $product['size'],
        //         'image' => $product['image'],
        //     ]);
        // endforeach;

        return $this->redirect(route('cart.payment'));
    }

    public function render()
    {
        return view('livewire.cart.confirm');
    }
}
