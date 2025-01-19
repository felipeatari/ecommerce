<div class="w-full flex flex-col justify-center px-3">
    <form wire:submit.prevent="store" class="bg-white w-full px-10 py-5 shadow">
        <div class="w-full flex justify-between my-5">
            <a
            wire:navigate
            class="w-8 h-8 flex items-center justify-center bg-gray-900 hover:bg-gray-700 rounded-full"
            href="/admin/sku/listar"
            >
                <x-icons.back />
            </a>
            <button type="button" class="bg-gray-900 hover:bg-gray-700 text-white px-3 py-1" wire:click="store">Salvar</button>
        </div>

        <h1 class="font-bold my-10">Cadastrar um Sku</h1>

        @if ($errors->any())
        <div class="w-full flex flex-col border border-red-200 bg-red-100 text-red-600 px-2 py-1 my-5">
        @foreach ($errors->all() as $error)
            <span>{{ $error }}</span>
        @endforeach
        </div>
        @endif

        <div class="w-full flex my-10">
            <div class="w-full flex">
                <span class="px-2 py-1 font-semibold">Produto:</span>
                <select wire:model.live="productId" class="w-full border px-2 py-1">
                    <option>Selecionar</option>
                    @foreach ($products as $product)
                    <option
                    value="{{ $product->id }}"
                    wire:key="{{ $product->id }}"
                    wire:model="{{ $product->id }}"
                    >
                        {{ $product->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <span class="w-[100px] px-2 py-1 font-semibold ml-5">ID: {{ $productId }}</span>
        </div>

        <div class="w-full flex items-center justify-between my-10">
            <div>
                <span class="px-2 py-1 font-semibold">Preço:</span>
                <input wire:model="price" type="number" class="w-[100px] border px-2 py-1" min="0">
            </div>

            <div>
                <span class="px-2 py-1 font-semibold">Preço de Custo:</span>
                <input wire:model="costPrice" type="number" class="w-[100px] border px-2 py-1" min="0">
            </div>

            <div>
                <span class="px-2 py-1 font-semibold">Preço Promocional:</span>
                <input wire:model="discountPrice" type="number" class="w-[100px] border px-2 py-1" min="0">
            </div>
        </div>

        <div class="w-full flex items-center justify-between my-10">
            <div>
                <span class="px-2 py-1 font-semibold">Cor:</span>
                <select wire:model="variationId1" class="min-w-[100px] border px-2 py-1">
                    <option>Selecionar</option>
                    @foreach ($colors as $color)
                    <option
                    value="{{ $color->id }}"
                    {{-- wire:key="{{ $color->id }}" --}}
                    wire:model="{{ $color->id }}"
                    >
                        {{ $color->value }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <span class="px-2 py-1 font-semibold">Tamanho:</span>
                <select wire:model="variationId2" class="min-w-[100px] border px-2 py-1">
                    <option>Selecionar</option>
                    @foreach ($sizes as $size)
                    <option
                    value="{{ $size->id }}"
                    {{-- wire:key="{{ $size->id }}" --}}
                    wire:model="{{ $size->id }}"
                    >
                        {{ $size->value }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <span class="px-2 py-1 font-semibold">Estoque:</span>
                <input wire:model="stock" type="number" class="w-[100px] border px-2 py-1" min="0">
            </div>

            <div class="flex items-center">
                <span class="px-2 py-1 font-semibold">Ativo:</span>
                <input class="w-5 h-5" wire:model="active" type="checkbox">
            </div>
        </div>

        <div class="w-full flex items-center justify-between my-10">
            <div>
                <span class="px-2 py-1 font-semibold">Largura:</span>
                <input wire:model="width" type="number" class="w-[100px] border px-2 py-1" min="0">
            </div>

            <div>
                <span class="px-2 py-1 font-semibold">Altura:</span>
                <input wire:model="height" type="number" class="w-[100px] border px-2 py-1" min="0">
            </div>

            <div>
                <span class="px-2 py-1 font-semibold">Profundidade:</span>
                <input wire:model="length" type="number" class="w-[100px] border px-2 py-1" min="0">
            </div>

            <div>
                <span class="px-2 py-1 font-semibold">Peso:</span>
                <input wire:model="weight" type="number" class="w-[100px] border px-2 py-1" min="0">
            </div>
        </div>

    </form>

    @if ($sku)
    <form wire:submit.prevent="storeImage" class="bg-white w-full px-10 py-5 mt-3 shadow">
        <h1 class="font-semibold">Adicionar imagens:</h1>
        <div class="w-full flex justify-between my-5">
            <div class="w-[200px] h-[300px] flex border">
                <label for="sku-image-1" class="w-full h-full flex items-center justify-center cursor-pointer">
                    @if ($image1)
                    <img id="preview-sku-image-1" class="h-full object-cover" src="{{ $image1->temporaryUrl() }}">
                    @else

                    @if ($image1Preview)
                    <img id="preview-sku-image-1" class="h-full object-cover" src="{{ asset($image1Preview) }}">
                    @else
                    <div class="flex flex-col">
                        <span class="mb-3">Adicionar Foto 1</span>
                        <x-icons.add />
                    </div>
                    @endif
                    @endif
                </label>
                <input wire:model="image1" type="file" id="sku-image-1" hidden>
            </div>

            <div class="w-[200px] h-[300px] flex border">
                <label for="sku-image-2" class="w-full h-full flex items-center justify-center cursor-pointer">
                    @if ($image2)
                    <img id="preview-sku-image-1" class="h-full object-cover" src="{{ $image2->temporaryUrl() }}">
                    @else
                    @if ($image2Preview)
                        <img id="preview-sku-image-1" class="h-full object-cover" src="{{ asset($image2Preview) }}">
                        @else
                        <div class="flex flex-col">
                            <span class="mb-3">Adicionar Foto 2</span>
                            <x-icons.add />
                        </div>
                        @endif
                    @endif
                </label>
                <input wire:model="image2" type="file" id="sku-image-2" hidden>
            </div>

            <div class="w-[200px] h-[300px] flex border">
                <label for="sku-image-3" class="w-full h-full flex items-center justify-center cursor-pointer">
                    @if ($image3)
                    <img id="preview-sku-image-1" class="h-full object-cover" src="{{ $image3->temporaryUrl() }}">
                    @else
                    @if ($image3Preview)
                        <img id="preview-sku-image-1" class="h-full object-cover" src="{{ asset($image3Preview) }}">
                        @else
                        <div class="flex flex-col">
                            <span class="mb-3">Adicionar Foto 3</span>
                            <x-icons.add />
                        </div>
                        @endif
                    @endif
                </label>
                <input wire:model="image3" type="file" id="sku-image-3" hidden>
            </div>

            <div class="w-[200px] h-[300px] flex border">
                <label for="sku-image-4" class="w-full h-full flex items-center justify-center cursor-pointer">
                    @if ($image4)
                    <img id="preview-sku-image-1" class="h-full object-cover" src="{{ $image4->temporaryUrl() }}">
                    @else
                    @if ($image4Preview)
                        <img id="preview-sku-image-1" class="h-full object-cover" src="{{ asset($image4Preview) }}">
                        @else
                        <div class="flex flex-col">
                            <span class="mb-3">Adicionar Foto 4</span>
                            <x-icons.add />
                        </div>
                        @endif
                    @endif
                </label>
                <input wire:model="image4" type="file" id="sku-image-4" hidden>
            </div>

            <div class="w-[200px] h-[300px] flex border">
                <label for="sku-image-5" class="w-full h-full flex items-center justify-center cursor-pointer">
                    @if ($image5)
                    <img id="preview-sku-image-1" class="h-full object-cover" src="{{ $image5->temporaryUrl() }}">
                    @else
                    @if ($image5Preview)
                        <img id="preview-sku-image-1" class="h-full object-cover" src="{{ asset($image5Preview) }}">
                        @else
                        <div class="flex flex-col">
                            <span class="mb-3">Adicionar Foto 5</span>
                            <x-icons.add />
                        </div>
                        @endif
                    @endif
                </label>
                <input wire:model="image5" type="file" id="sku-image-5" hidden>
            </div>
        </div>

        <button type="button" class="bg-gray-900 hover:bg-gray-700 text-white px-3 py-1" wire:click="storeImage">Salvar</button>
    </form>
    @endif
</div>
