<?php

namespace App\Livewire\Cart;

use App\Livewire\Product\Index as ProductIndex;
use App\Services\ShippingMelhorEnvioService;
use Attribute;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Index extends Component
{
    // Carrinho
    public int $totalItems = 0;
    public int|float $total = 0;
    public int|float $subtotal = 0;
    public array $cart = [];
    public int $incrementItemCart = 0;
    public string $zipCode = '';

    // Frete
    public array $shippingCalculation = [];
    public bool $modalShippingCalculation = false;
    public bool $modalAccountCustomer = false;
    public int|float $shippingCost = 0;
    public string $shippingType = '';

    public function itemsCard()
    {
        $itemsCart = [];

        $this->totalItems = 0;
        $this->shippingCost = 0;
        $this->total = 0;
        $this->subtotal = 0;

        if (session()->exists('cart.product')) {
            foreach (session('cart.product') as $key => $itemCart):
                $itemsCart[$key]['id'] = $itemCart['id'];
                $itemsCart[$key]['sku_id'] = $itemCart['sku_id'];
                $itemsCart[$key]['code'] = $itemCart['code'];
                $itemsCart[$key]['name'] = $itemCart['name'];
                $itemsCart[$key]['price'] = $itemCart['price'];
                $itemsCart[$key]['price_cart'] = $itemCart['price_cart'];
                $itemsCart[$key]['stock'] = $itemCart['stock'];
                $itemsCart[$key]['quantity'] = $itemCart['quantity'];
                $itemsCart[$key]['weight'] = $itemCart['weight'];
                $itemsCart[$key]['width'] = $itemCart['width'];
                $itemsCart[$key]['height'] = $itemCart['height'];
                $itemsCart[$key]['length'] = $itemCart['length'];
                $itemsCart[$key]['color'] = $itemCart['color'];
                $itemsCart[$key]['size'] = $itemCart['size'];
                $itemsCart[$key]['image'] = $itemCart['image'];
            endforeach;
        }

        foreach ($itemsCart as $itemCart):
            $this->totalItems += $itemCart['quantity'];
            $this->subtotal += $itemCart['price_cart'];
        endforeach;

        if (session()->exists('cart.shipping')) {
            $this->shippingCost = session('cart.shipping.price');
        }

        if (session()->exists('cart.total')) {
            session()->forget('cart.total');
        }

        if (session()->exists('cart.subtotal')) {
            session()->forget('cart.subtotal');
        }

        if (session()->exists('cart.shipping.type')) {
            $this->shippingType = session()->get('cart.shipping.type');
        }

        $this->total = $this->subtotal + $this->shippingCost;

        session()->put('cart.subtotal', $this->subtotal);
        session()->put('cart.total', $this->total);

        return $itemsCart;
    }

    public function addCart(array $product)
    {
        $code = '';
        $code .= $product['id'];
        $code .= '-' . $product['sku_id'];
        $code .= '-' . $product['color'];
        $code .= '-' . $product['size'];
        $code = mb_strtoupper($code);

        $product['code'] = $code;

        $this->cart = [];

        $keyUpdateCart = null;

        if (session()->exists('cart.product')) {
            $itemsCart = [];
            foreach (session('cart.product') ?? null as $keyCart => $cartItem):
                if (isset($cartItem['code']) and $cartItem['code'] === $product['code']) {
                    $keyUpdateCart = $keyCart;
                    $itemsCart['quantity'] = $cartItem['quantity'];
                    break;
                }
            endforeach;

            if (isset($itemsCart['quantity']) and $itemsCart['quantity'] >= $product['stock']) return;
        }

        if (! is_null($keyUpdateCart)) {
            $quantityItem = session()->get('cart.product.' . $keyUpdateCart . '.quantity');
            $priceItem = session()->get('cart.product.' . $keyUpdateCart . '.price_cart');
            $quantityItem++;
            $priceItem += $product['price'];
            session()->put('cart.product.' . $keyUpdateCart . '.quantity', $quantityItem);
            session()->put('cart.product.' . $keyUpdateCart . '.price_cart', $priceItem);
        } else {
            $this->cart = [
                'id' => $product['id'],
                'sku_id' => $product['sku_id'],
                'code' => $product['code'],
                'name' => $product['name'],
                'price' => $product['price'],
                'price_cart' => $product['price'],
                'stock' => $product['stock'],
                'weight' => $product['weight'],
                'width' => $product['width'],
                'height' => $product['height'],
                'length' => $product['length'],
                'color' => $product['color'],
                'size' => $product['size'],
                'image' => $product['image'],
                'quantity' => 1,
            ];

            session()->push('cart.product', $this->cart);
        }

        if (session()->exists('totalItemsCart')) {
            session()->increment('totalItemsCart');
        } else {
            $this->incrementItemCart++;
            session()->put('totalItemsCart', $this->incrementItemCart);
        }

        if (session()->exists('cart.shipping')) {
            session()->forget('cart.shipping');
            $this->shippingCost = 0;
        }

        $this->dispatch('add-cart', session('totalItemsCart'));
    }

    public function remCart(array $product)
    {
        $keyRemoveCart = null;
        if (session()->exists('cart.product')) {
            foreach (session('cart.product') as $keyCart => $cartItem):
                if (isset($cartItem['code']) and $cartItem['code'] === $product['code']) {
                    $keyRemoveCart = $keyCart;
                    break;
                }
            endforeach;
        }

        if (! is_null($keyRemoveCart)) {
            $quantityItem = session()->get('cart.product.' . $keyRemoveCart . '.quantity');
            $quantityItem--;

            if ($quantityItem > 0) {
                $priceItem = session()->get('cart.product.' . $keyRemoveCart . '.price_cart');
                $priceItem -= $product['price'];

                session()->put('cart.product.' . $keyRemoveCart . '.quantity', $quantityItem);
                session()->put('cart.product.' . $keyRemoveCart . '.price_cart', $priceItem);
            } else {
                session()->forget('cart.product.' . $keyRemoveCart);
            }

            if (session('totalItemsCart') < 0) {
                session()->put('totalItemsCart', 0);
            } else {
                session()->decrement('totalItemsCart');
            }

            if (session()->exists('cart.shipping')) {
                session()->forget('cart.shipping');
                $this->shippingCost = 0;
            }

            $this->dispatch('add-cart', session('totalItemsCart'));
        }
    }

    public function calculateShipping()
    {
        if (! $this->zipCode) {
            $this->js('alert("Necessário informar um CEP")');

            return;
        }

        if (! preg_match('/^[\d]{8}$/', $this->zipCode) and ! preg_match('/^[\d]{5}-[\d]{3}$/', $this->zipCode)) {
            $this->js('alert("CEP inválido")');

            return;
        }

        if (! session()->exists('cart.product')) return;

        if ($this->zipCode != '62580000') {
            $this->shippingCalculation = [];

            $shipping = (new ShippingMelhorEnvioService)->calculate($this->zipCode, session('cart.product'));

            foreach ($shipping as $item):
                if (isset($item['error']) and $item['error']) continue;

                $this->shippingCalculation[] = [
                    'name' => $item['title'],
                    'price' => $item['price'],
                    'delivery_time' => $item['delivery_time']
                ];
            endforeach;

            if (! $this->shippingCalculation) {
                $this->js('alert("Ocorreu um erro ao calcular o frete")');

                return;
            }
        }

        $this->modalShippingCalculation = true;
    }

    public function selectedShipping(array $shipping)
    {
        if (session()->exists('cart.shipping')) {
            if (session('cart.shipping.name') == $shipping['name']) {
                return;
            }

            session()->forget('cart.shipping');
        }

        session()->put('cart.shipping', $shipping);

        $this->modalShippingCalculation = false;
        $this->shippingCalculation = [];
    }

    public function selectedShipping2(string $type)
    {
        $shipping = [];

        if ($type === 'free') {
            $shipping['type'] = 'free';
            $shipping['name'] = 'Grátis';
            $shipping['price'] = 0;
            $shipping['delivery_time'] = 1;
        } elseif ($type === 'region') {
            $shipping['type'] = 'region';
            $shipping['name'] = 'Loja';
            $shipping['price'] = 20;
            $shipping['delivery_time'] = 3;
        } else {
            $shipping['type'] = 'no';
            $shipping['name'] = 'Retirada';
            $shipping['price'] = 0;
            $shipping['delivery_time'] = 0;
        }

        $this->shippingType = $type;

        if (session()->exists('cart.shipping')) {
            if (session('cart.shipping.name') == $shipping['name']) {
                return;
            }

            session()->forget('cart.shipping');
        }

        session()->put('cart.shipping', $shipping);

        $this->modalShippingCalculation = false;
        $this->shippingCalculation = [];
    }

    public function closeModalShippingCalculation()
    {
        $this->modalShippingCalculation = false;
    }

    public function closeModalAccountCustomer()
    {
        $this->modalAccountCustomer = false;
    }

    public function checkout()
    {
        if (! Auth::id()) {
            $this->modalAccountCustomer = true;

            session()->put('cart.back_cart', true);

            return;
        }

        if (! session()->exists('cart.shipping')) {
            $this->js('alert("Verifique o Frete.")');

            return;
        }

        return $this->redirect(route('cart.customer'));
    }

    public function render()
    {
        return view('livewire.cart.index', [
            'itemsCart' => $this->itemsCard(),
        ]);
    }
}
