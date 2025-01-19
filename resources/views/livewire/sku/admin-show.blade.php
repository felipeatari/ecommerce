<div class="w-full flex justify-center px-3">
    <div class="w-full bg-white px-10 py-5 shadow">
        <div class="w-full flex justify-between my-5">
            <a
            wire:navigate
            class="w-8 h-8 flex items-center justify-center bg-gray-900 hover:bg-gray-700 rounded-full"
            href="/admin/sku/listar"
            >
                <x-icons.back />
            </a>

            <div>
                <a wire:navigate href="/admin/sku/editar/{{ $sku->id }}" >
                    <button class="bg-gray-900 hover:bg-gray-700 text-white px-3 py-1">
                        Editar
                    </button>
                </a>

                <button
                wire:click="modalDelete"
                class="bg-gray-900 hover:bg-gray-700 text-white px-3 py-1"
                >
                    Apagar
                </button>

                @if ($statusModalDelete)
                <div class="absolute inset-0 w-full h-full bg-black bg-opacity-90">
                    <div class="bg-white w-[500px] min-h-[200px] p-3 flex flex-col items-center justify-center m-auto">
                        @error('db')
                        <div class="w-full border border-red-200 bg-red-100 text-red-600 px-2 py-1 my-5">{{ $message }}</div>
                        @enderror
                        <span class="text-xl">Excuir esse Sku?</span>
                        <div class="mt-10">
                            <button class="bg-gray-900 hover:bg-gray-700 text-white px-3 py-1" wire:click="destroy">Sim</button>
                            <button class="bg-gray-900 hover:bg-gray-700 text-white px-3 py-1" wire:click="modalDelete">Não</button>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <h1 class="font-bold my-10">Sku {{ $sku->id }} - Produto {{ $sku->product_id }}</h1>

        <div class="flex my-10">
            <span class="px-2 py-1 font-semibold">Nome:</span>
            <div class="w-full px-2 py-1 border">{{ $sku->product->name }}</div>
        </div>

        <div class="w-full flex items-center justify-between my-10">
            <div class="flex">
                <span class="px-2 py-1 font-semibold">Preço:</span>
                <div class="w-[100px] px-2 py-1 border">{{ number_format(($sku->price / 100), 2, ',', '.') }}</div>
            </div>

            <div class="flex">
                <span class="px-2 py-1 font-semibold">Preço de Custo:</span>
                <div class="w-[100px] px-2 py-1 border">{{ number_format(($sku->cost_price / 100), 2, ',', '.') }}</div>
            </div>

            <div class="flex">
                <span class="px-2 py-1 font-semibold">Preço Promocional:</span>
                <div class="w-[100px] px-2 py-1 border">{{ number_format(($sku->discount_price / 100), 2, ',', '.') }}</div>
            </div>
        </div>

        <div class="w-full flex items-center justify-between my-10">
            <div class="flex">
                <span class="px-2 py-1 font-semibold">Cor:</span>
                <div class="min-w-[100px] px-2 py-1 border">{{ $sku->variation1->value }}</div>
            </div>

            <div class="flex">
                <span class="px-2 py-1 font-semibold">Tamanho:</span>
                <div class="w-[100px] px-2 py-1 border">{{ $sku->variation2->value }}</div>
            </div>

            <div class="flex">
                <span class="px-2 py-1 font-semibold">Estoque:</span>
                <div class="w-[100px] px-2 py-1 border">{{ $sku->stock }}</div>
            </div>

            <div class="flex">
                <span class="px-2 py-1 font-semibold">Ativo:</span>
                @if ($sku->active)
                <div class="w-[100px] px-2 py-1 border">Sim</div>
                @else
                <div class="w-[100px] px-2 py-1 border">Não</div>
                @endif
            </div>
        </div>

        <div class="w-full flex items-center justify-between my-10">
            <div class="flex">
                <span class="px-2 py-1 font-semibold">Largura:</span>
                <div class="w-[100px] px-2 py-1 border">{{ $sku->width }}</div>
            </div>

            <div class="flex">
                <span class="px-2 py-1 font-semibold">Altura:</span>
                <div class="w-[100px] px-2 py-1 border">{{ $sku->height }}</div>
            </div>

            <div class="flex">
                <span class="px-2 py-1 font-semibold">Profundidade:</span>
                <div class="w-[100px] px-2 py-1 border">{{ $sku->length }}</div>
            </div>

            <div class="flex">
                <span class="px-2 py-1 font-semibold">Peso:</span>
                <div class="w-[100px] px-2 py-1 border">{{ $sku->weight }}</div>
            </div>
        </div>

        <div class="w-full flex justify-between my-5">
            <div class="w-[200px] h-[300px] flex items-center justify-center border">
                @if ($productImage and $productImage->image_1)
                <img src="{{ asset($productImage?->image_1) }}" alt="foto 1" class="h-full object-cover">
                @else
                Foto 1
                @endif
            </div>

            <div class="w-[200px] h-[300px] flex items-center justify-center border">
                @if ($productImage and $productImage->image_2)
                <img src="{{ asset($productImage?->image_2) }}" alt="foto 2" class="h-full object-cover">
                @else
                Foto 2
                @endif
            </div>

            <div class="w-[200px] h-[300px] flex items-center justify-center border">
                @if ($productImage and $productImage->image_3)
                <img src="{{ asset($productImage?->image_3) }}" alt="foto 3" class="h-full object-cover">
                @else
                Foto 3
                @endif
            </div>

            <div class="w-[200px] h-[300px] flex items-center justify-center border">
                @if ($productImage and $productImage->image_4)
                <img src="{{ asset($productImage?->image_4) }}" alt="foto 4" class="h-full object-cover">
                @else
                Foto 4
                @endif
            </div>

            <div class="w-[200px] h-[300px] flex items-center justify-center border">
                @if ($productImage and $productImage->image_5)
                <img src="{{ asset($productImage?->image_5) }}" alt="foto 5" class="h-full object-cover">
                @else
                Foto 5
                @endif
            </div>
        </div>
    </div>
</div>
