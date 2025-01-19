<div class="w-full flex justify-center">
    <div class="w-[800px] max-[800px]:full flex flex-col m-5 mx-5 px-5 max-[800px]:mx-1 max-[800px]:px-0 max-[800px]:my-2 text-sm text-gray-800 bg-white shadow">
        <a
        class="w-[75px] h-5 flex items-center justify-between mt-5"
        wire:navigate
        href="{{ route('cart.customer') }}"
        >
            <span class="w-8 h-8 flex items-center justify-center bg-gray-700 font-semibold text-white rounded-full shadow">
                <x-icons.back />
            </span>
        </a>

        <h1 class="my-5 font-semibold text-xl">Verifique as Informações</h1>

        <div class="w-full px-2 mb-2 rounded border-2">
            @foreach ($product as $item)
            <div class="w-full min-h-36 flex items-center border- ">
                <div class="w-28 h-full flex items-center justify-center mr-2">
                    <img
                    src="{{ asset($item['image']) }}"
                    alt="image_1"
                    class="h-full object-cover cursor-pointer"
                    >
                </div>
                <div class="w-full h-full flex pl-3">
                    <div class="h-full flex flex-col justify-between">
                        <div class="flex">
                            <span class="font-semibold mr-1">Código:</span>
                            <span>{{ $item['code'] }}</span>
                        </div>
                        <div class="flex">
                            <span class="font-semibold mr-1">Nome:</span>
                            <span>{{ $item['name'] }}</span>
                        </div>
                        {{-- <div class="flex flex-wrap">
                            <span class="font-semibold mr-1">Sku:</span>
                            <span>{{ $item['sku_id'] }}</span>
                            <span class="font-semibold ml-5 mr-1">Produto:</span>
                            <span>{{ $item['id'] }}</span>
                        </div> --}}
                        <div class="flex">
                            <span class="font-semibold mr-1">Cor:</span>
                            <span>{{ $item['color'] }}</span>
                            <span class="font-semibold mr-1 ml-5">Tamanho:</span>
                            <span>{{ $item['size'] }}</span>
                        </div>
                        <div class="flex">
                            <span class="font-semibold mr-1">Quantidade:</span>
                            <span>{{ $item['quantity'] }} un</span>
                        </div>
                        <div class="flex flex-col">
                            <div class="flex">
                                <span class="font-semibold mr-1">Preço Un: </span>
                                <span>R$ {{ number_format($item['price'], 2, ',') }}</span>
                            </div>
                            <div class="flex">
                                <span class="font-semibold mr-1">Preço Total: </span>
                                <span>R$ {{ number_format($item['price_cart'], 2, ',') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="w-full flex flex-col">
            <div class="w-full flex flex-col mb-2 border-2 p-2 rounded">
                <span class="font-bold text-base">Dados do Cliente</span>
                <div class="flex">
                    <span class="font-semibold mr-1">Nome:</span><span>{{ $customer['name'] }}</span>
                </div>
                <div class="flex">
                    <span class="font-semibold mr-1">CPF:</span><span>{{ $customer['cpf'] }}</span>
                </div>
                <div class="flex">
                    <span class="font-semibold mr-1">E-Mail:</span><span>{{ $customer['email'] }}</span>
                </div>
                <div class="flex">
                    <span class="font-semibold mr-1">Celular:</span><span>{{ $customer['phone'] }}</span>
                </div>
            </div>

            <div class="flex flex-col mb-2 border-2 p-2 rounded">
                <span class="font-bold text-base">Endereço de Entrega</span>
                <div class="flex">
                    <span class="font-semibold mr-1">CEP:</span><span>{{ $customer['zipCode'] }}</span>
                </div>

                <div class="flex">
                    <span class="font-semibold mr-1">Estado: </span><span>{{ $customer['state'] }}</span>
                </div>

                <div class="flex">
                    <span class="font-semibold mr-1">Cidade: </span><span>{{ $customer['city'] }}</span>
                </div>

                <div class="flex">
                    <span class="font-semibold mr-1">Bairro: </span><span>{{ $customer['neighborhood'] }}</span>
                </div>

                <div class="flex">
                    <span class="font-semibold mr-1">Endereço: </span><span>{{ $customer['address'] }}</span>
                </div>

                <div class="flex">
                    <span class="font-semibold mr-1">Número: </span><span>{{ $customer['number'] }}</span>
                </div>

                <div class="flex">
                    <span class="font-semibold mr-1">Complemento: </span><span>{{ $customer['complement'] }}</span>
                </div>

                <div class="flex flex-col">
                    <span class="font-semibold mr-1">Observações: </span>
                    <span class="w-full min-h-[100px] border rounded">{{ $customer['note'] }}</span>
                </div>
            </div>

            @empty(!$shipping)
            <div class="flex flex-col mb-2 border-2 p-2 rounded">
                <span class="font-bold text-base">Frete</span>
                <div class="flex">
                    <span class="font-semibold mr-1">Nome:</span><span>{{ $shipping['name'] }}</span>
                </div>
                <div class="flex">
                    <span class="font-semibold mr-1">Preço:</span><span>R$ {{ number_format($shipping['price'], 2, ',') }}</span>
                </div>
                <div class="flex">
                    <span class="font-semibold mr-1">Prazo:</span>
                    @if ($shipping['delivery_time'] == 1)
                    <span>1 dia</span>
                    @else
                    <span>{{ $shipping['delivery_time'] }} dias</span>
                    @endif
                </div>
            </div>
            @endempty

            <div class="flex flex-col mb-2 p-2 border-2 rounded">
                <span class="font-semibold text-base">Qual o Meio de Pagamento?</span>
                <div class="flex mt-3">
                    <div class="flex">
                        <span class="font-semibold mr-1">Pix:</span>
                        <div class="w-5 h-5 p-[1.5px] flex items-center justify-center border border-gray-400 rounded-full">
                            <input class="w-full h-full appearance-none checked:bg-gray-400 rounded-full" type="radio" wire:model.live="payment" value="1">
                        </div>
                    </div>
                    <div class="flex ml-5">
                        <span class="font-semibold mr-1">Cartão:</span>
                        <div class="w-5 h-5 p-[1.5px] flex items-center justify-center border border-gray-400 rounded-full">
                            <input class="w-full h-full appearance-none checked:bg-gray-400 rounded-full" type="radio" wire:model.live="payment" value="2">
                        </div>
                    </div>
                </div>
                <select wire:model="installment" class="w-[100px] border px-2 py-1 mt-2">
                    @if ($payment != 0)
                        <option value="1">1x</option>
                        @if ($payment == 2)
                        <option value="2">2x</option>
                        <option value="3">3x</option>
                        <option value="4">4x</option>
                        <option value="5">5x</option>
                        @endif
                    @endif
                </select>
            </div>

            <div class="flex mb-2 p-2 border-2 rounded">
                <div class="flex flex-col">
                    <span class="font-semibold text-base">Subtotal:</span>
                    <span>R$ {{ number_format(session()->get('cart.subtotal'), 2, ',') }}</span>
                </div>
                <div class="flex flex-col ml-5">
                    <span class="font-semibold text-base">Desconto:</span>
                    {{-- <span>R$ {{ number_format(session()->get('cart.subtotal'), 2, ',') }}</span> --}}
                    <span>R$ {{ number_format(0, 2, ',') }}</span>
                </div>
                <div class="flex flex-col ml-5">
                    <span class="font-semibold text-base">Total:</span>
                    <span>R$ {{ number_format(session()->get('cart.total'), 2, ',') }}</span>
                </div>
            </div>
        </div>

        <button type="button" wire:click="checkout" class="w-[120px] flex items-center justify-center px-2 py-2 my-3 bg-gray-700 font-semibold text-white rounded">Fechar Pedido</button>
    </div>
</div>
