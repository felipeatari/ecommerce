<div class="w-full flex items-center justify-center flex-col bg-white">
    <div class="flex max-[850px]:w-full max-[750px]:flex-col">
        <div class="flex items-center justify-center flex-col">
            <div class="w-[200px] h-full flex items-center justify-center border my-2 max-[750px]:h-[290px]">
                <img
                src="{{ asset($selectedImageURL) }}"
                alt="image_1"
                class="w-full object-cover cursor-pointer"
                >
            </div>

            <div class="w-[550px] flex justify-center mb-2 max-[480px]:w-full">
                @if ($productImage)
                    @foreach ($productImage as $item)
                        @if ($item->variation_id and $item->variation_id == $selectedColorId)
                            @if ($item->image_1)
                            <div class="border w-[100px] h-[150px] mx-1 max-[480px]:w-[60px] max-[480px]:h-[120px] max-[300px]:w-[40px] max-[300px]:h-[80px]">
                                <img
                                wire:click="selectImagem('{{ $item->image_1 }}')"
                                src="{{ asset($item->image_1) }}"
                                alt="image_1"
                                class="w-full h-full object-cover cursor-pointer"
                                >
                            </div>
                            @endif

                            @if ($item->image_2)
                            <div class="border w-[100px] h-[150px] mx-1 max-[480px]:w-[60px] max-[480px]:h-[120px] max-[300px]:w-[40px] max-[300px]:h-[80px]">
                                <img
                                wire:click="selectImagem('{{ $item->image_2 }}')"
                                src="{{ asset($item->image_2) }}"
                                alt="image_2"
                                class="w-full h-full object-cover cursor-pointer"
                                >
                            </div>
                            @endif

                            @if ($item->image_3)
                            <div class="border w-[100px] h-[150px] mx-1 max-[480px]:w-[60px] max-[480px]:h-[120px] max-[300px]:w-[40px] max-[300px]:h-[80px]">
                                <img
                                wire:click="selectImagem('{{ $item->image_3 }}')"
                                src="{{ asset($item->image_3) }}"
                                alt="image_3"
                                class="w-full h-full object-cover cursor-pointer"
                                >
                            </div>
                            @endif

                            @if ($item->image_4)
                            <div class="border w-[100px] h-[150px] mx-1 max-[480px]:w-[60px] max-[480px]:h-[120px] max-[300px]:w-[40px] max-[300px]:h-[80px]">
                                <img
                                wire:click="selectImagem('{{ $item->image_4 }}')"
                                src="{{ asset($item->image_4) }}"
                                alt="image_4"
                                class="w-full h-full object-cover cursor-pointer"
                                >
                            </div>
                            @endif

                            @if ($item->image_5)
                            <div class="border w-[100px] h-[150px] mx-1 max-[480px]:w-[60px] max-[480px]:h-[120px] max-[300px]:w-[40px] max-[300px]:h-[80px]">
                                <img
                                wire:click="selectImagem('{{ $item->image_5 }}')"
                                src="{{ asset($item->image_5) }}"
                                alt="image_5"
                                class="w-full h-full object-cover cursor-pointer"
                                >
                            </div>
                            @endif
                        @endif
                    @endforeach
                @endif
            </div>
        </div>

        <div class="w-[300px] px-4 flex flex-col justify-between max-[750px]:w-full max-[750px]:items-start max-[600px]:px-6">
            <div><!-- Nome e preço -->
                <h1 class="text-3xl mb-2">{{ $product->name }}</h1>
                <h1 class="text-xl font-semibold">R$ {{ number_format($productPrice, 2, ',') }}</h1>
            </div><!-- Nome e preço -->

            <div><!-- Seleção de cor e tamanho -->
                <div class="flex flex-col justify-center my-4">
                    <span class="text-xs text-gray-600 mb-2">Cor: {{ ucfirst($selectedColor) }}</span>
                    <div class="flex">
                    @foreach ($variations as $i => $variation)
                        <a
                        wire:key="{{ $i }}"
                        wire:click="selectColor({{ json_encode($variation) }})"
                        wire:navigate
                        href="{{ route('home.show', [$slug]) }}?sku={{ $variation[0]['sku_id'] }}&cor={{ $variation[0]['color'] }}&tam={{ $variation[0]['size'] }}"
                        @class([
                            'w-7 h-7 flex items-center justify-center border rounded-full text-xs text-gray-400 mr-2 cursor-pointer',
                            'border-2 border-gray-950' => $variation[0]['color'] === $selectedColor,
                        ])

                        >
                        <span class="w-full h-full rounded-full" style="background-color: {{ $variation[0]['codeColor'] }}"></span>
                        </a>
                    @endforeach
                    </div>
                </div>

                <div class="flex flex-col justify-center my-4">
                    <span class="text-xs text-gray-600 mb-2">Tamanho: {{ $selectedSize }}</span>
                    <div class="flex">
                        @foreach ($selecteSizes as $sizes)
                            @foreach ($sizes as $i => $size)
                                @if ($selectedColor === $size['color'])
                                <a
                                wire:key="{{ $i }}"
                                wire:click="selectSize('{{ $size['size'] }}')"
                                wire:navigate
                                href = "{{ route('home.show', [$slug]) }}?sku={{ $size['sku_id'] }}&cor={{ $size['color'] }}&tam={{ $size['size'] }}"
                                @class([
                                    'w-7 h-7 flex items-center justify-center border rounded-lg text-xs text-gray-400 mr-2 cursor-pointer',
                                    'border-2 border-gray-950' => $size['size'] === $selectedSize,
                                ])
                                >
                                    {{ $size['size'] }}
                                </a>
                                @endif
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div><!-- Seleção de cor e tamanho -->

            <div class="my-4"><!-- Informa o estoque -->
                <span
                @class([
                    'px-2 py-1 rounded-md text-sm border-2',
                    'border-green-600 bg-green-100 font-semibold text-green-600' => $stock > 0,
                    'border-red-600 bg-red-100 font-semibold text-red-600' => $stock < 1,
                ])
                >
                    @if ($stock > 0)
                    {{ $stock }} em estoque
                    @else
                    Sem estoque
                    @endif
                </span>
            </div><!-- Informa o estoque -->

            <!-- Calculo de frete -->
            <div class="w-full flex flex-col text-gray-700 my-4 text-sm">
                <span class="mb-1">Calcular Entrega</span>
                <input
                wire:model.live.debounce.1000ms="zipCode"
                class="w-full border px-3 py-2 mr-1 text-xs rounded-md"
                type="text" placeholder="Digite seu CEP">

                <x-product.show-modal-shipping-calculation :$modalShippingCalculation :$shippingCalculation />
            </div><!-- Calculo de frete -->

            <button
            wire:click="addItemCart()"
            class="flex items-center justify-center px-2 py-2 mt-4 bg-gray-950 hover:bg-gray-700 rounded text-white font-semibold"
            >
                Adicionar ao Carrinho
            </button>
        </div>
    </div>

    <div class="w-[900px] text-mb mt-20 mb-10 max-[1000px]:w-full max-[1000px]:px-2">
        <h1 class="text-xl font-semibold mb-2">Descrição:</h1>
        <span class="flex">{{ $product->description }}</span>
    </div>
</div>
