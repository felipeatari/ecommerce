@props(['itemsCart', 'totalItems', 'subtotal', 'shippingCost', 'shippingType', 'total'])

<div class="w-[1000px] max-[850px]:w-full flex justify-between max-[650px]:flex-wrap my-5">
    <div class="w-full">
        <ul class="w-full justify-between px-2 max-[650px]:overflow-auto max-[650px]:border">
            @foreach ($itemsCart as $i => $item)
            <li @class([
                'w-full py-2 bg-white',
                'border-t pt-4' => $i > 0
            ])
            >
                <div class="flex">
                    <div class="w-32 h-32 border flex items-center justify-center mr-4">
                        <img
                        src="{{ asset($item['image']) }}"
                        alt="image_1"
                        class="h-full object-cover cursor-pointer"
                        >
                    </div>

                    <div class="flex flex-col justify-between p-2">
                        <div class="flex flex-col ">
                            <span class="text-sm font-semibold mb-2">{{ ucfirst($item['name']) }} - {{ strtoupper($item['color']) }} {{ $item['size'] }}</span>
                            <span>R$ {{ number_format($item['price_cart'], 2, ',') }}</span>
                        </div>

                        <div>
                            <button wire:click="remCart({{ json_encode($item) }})" class="border px-3">-</button>
                            <span class="mr-4 ml-4">{{ $item['quantity'] }}</span>
                            <button wire:click="addCart({{ json_encode($item) }})" class="border px-3">+</button>
                        </div>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>

    <div class="w-[500px] h-[280px] flex flex-col items-center justify-between border ml-8 p-2 max-[650px]:ml-0 max-[650px]:mt-10">
        <div class="w-full flex flex-col">
            <span class="mt-4 mb-4 border-b">Subtotal: R$ {{ number_format($subtotal, 2, ',') }}</span>

            <div class="mt-2 mb-2 border-b pb-2">
                @if ($shippingType === 'free')
                <span>Frete Grátis</span>
                @elseif ($shippingType === 'region')
                <span>Frete: R$ 20,00</span>
                @elseif ($shippingType === 'no')
                <span>Retirar na Loja</span>
                @else
                <span>Frete: R$ {{ number_format($shippingCost, 2, ',') }}</span>
                @endif
                <div class="w-full flex">
                    <input wire:model.live="zipCode" class="w-full border px-2 py-1 h-8 rounded-md" type="text" placeholder="Digite seu CEP">
                    <button wire:click.prevent="calculateShipping" class="font-semibold bg-gray-900 text-white text-sm ml-2 px-2 h-8 rounded-md">Calcular</button>
                </div>
            </div>

            <span class="mt-4">Total: R$ {{ number_format($total, 2, ',') }}</span>
        </div>

        <button wire:click="checkout" class="w-full py-2 font-semibold bg-gray-900 text-white rounded-md">Checkout</button>
    </div>
</div>
