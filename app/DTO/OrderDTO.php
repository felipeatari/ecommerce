<?php

namespace App\DTO;

use App\Models\Order;
use App\Models\User;

class OrderDTO
{
    public ?int $id;
    public ?int $user_id;
    public ?int $status;
    public ?int $subtotal;
    public ?int $discount;
    public ?int $total;
    public ?string $payment_gateway;
    public ?string $payment_type;
    public ?int $payment_installment;
    public ?string $shipping_name;
    public ?int $shipping_price;
    public ?int $shipping_delivery_time;
    public ?string $delivery_city;
    public ?string $delivery_state;
    public ?string $delivery_neighborhood;
    public ?string $delivery_address;
    public ?string $delivery_number;
    public ?string $delivery_complement;
    public ?string $delivery_country;
    public ?string $delivery_country_code;
    private ?User $user;

    public function __construct(Order $product)
    {
        $this->id = $product['id'];
        $this->user_id = $product['user_id'];
        $this->status = $product['status'];
        $this->subtotal = $product['subtotal'];
        $this->discount = $product['discount'];
        $this->total = $product['total'];
        $this->payment_gateway = $product['payment_gateway'];
        $this->payment_type = $product['payment_type'];
        $this->payment_installment = $product['payment_installment'];
        $this->shipping_name = $product['shipping_name'];
        $this->shipping_price = $product['shipping_price'];
        $this->shipping_delivery_time = $product['shipping_delivery_time'];
        $this->delivery_city = $product['delivery_city'];
        $this->delivery_state = $product['delivery_state'];
        $this->delivery_neighborhood = $product['delivery_neighborhood'];
        $this->delivery_address = $product['delivery_address'];
        $this->delivery_number = $product['delivery_number'];
        $this->delivery_complement = $product['delivery_complement'];
        $this->delivery_country = $product['delivery_country'];
        $this->delivery_country_code = $product['delivery_country_code'];
        $this->active = $product['active'];

        $this->setUser($product['user']);
    }

    private function setUser(?User $user = null)
    {
        $this->user = $user;
    }

    public function getUser($columns = [])
    {
        return $this->user;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'status' => $this->status;
            'subtotal' => $this->subtotal;
            'discount' => $this->discount;
            'total' => $this->total;
            'payment_gateway' => $this->payment_gateway;
            'payment_type' => $this->payment_type;
            'payment_installment' => $this->payment_installment;
            'shipping_name' => $this->shipping_name;
            'shipping_price' => $this->shipping_price;
            'shipping_delivery_time' => $this->shipping_delivery_time;
            'delivery_city' => $this->delivery_city;
            'delivery_state' => $this->delivery_state;
            'delivery_neighborhood' => $this->delivery_neighborhood;
            'delivery_address' => $this->delivery_address;
            'delivery_number' => $this->delivery_number;
            'delivery_complement' => $this->delivery_complement;
            'delivery_country' => $this->delivery_country;
            'delivery_country_code' => $this->delivery_country_code;
            'active' => $this->active,
        ];
    }

    public static function fromModel(Product $product)
    {
        return new self($product);
    }
}
