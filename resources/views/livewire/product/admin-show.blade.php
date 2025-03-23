<div class="w-full flex justify-center px-3">
    <div class="w-full bg-white px-10 py-5 shadow">
        <div class="w-full flex justify-between my-5">
            <a
                href="{{ route('admin.product.index') }}"
                class="w-8 h-8 flex items-center justify-center bg-gray-900 hover:bg-gray-700 rounded-full"
            >
                <x-icons.back />
            </a>

            <div>
                <a href="{{ route('admin.product.update', $product->id) }}">
                    <button class="bg-gray-900 hover:bg-gray-700 text-white px-3 py-1 rounded-md">
                        Editar
                    </button>
                </a>

                <button
                    type="button"
                    wire:click="modalDelete"
                    class="bg-gray-900 hover:bg-gray-700 text-white px-3 py-1 rounded-md"
                >
                    Apagar
                </button>

                @if ($statusModalDelete)
                <div class="absolute inset-0 w-full h-full bg-black bg-opacity-90">
                    <div class="bg-white w-[500px] min-h-[200px] p-3 flex flex-col items-center justify-center m-auto">
                        @error('db')
                        <div class="w-full border border-red-200 bg-red-100 text-red-600 px-2 py-1 my-5">{{ $message }}</div>
                        @enderror
                        <span class="text-xl">Excuir esse Produto?</span>
                        <div class="mt-10">
                            <button class="bg-gray-900 hover:bg-gray-700 text-white px-3 py-1" wire:click="destroy">Sim</button>
                            <button class="bg-gray-900 hover:bg-gray-700 text-white px-3 py-1" wire:click="modalDelete">Não</button>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <h1 class="font-bold my-10">Produto {{ $product->id }}</h1>

        <div class="flex my-10">
            <span class="px-2 py-1 font-semibold">Nome:</span>
            <div class="w-full px-2 py-1 border">{{ $product->name }}</div>
        </div>

        <div class="w-full flex items-center justify-between my-10">
            <div class="flex">
                <span class="px-2 py-1 font-semibold">Categoria:</span>
                <div class="w-[200px] px-2 py-1 border">{{ $category }}</div>
            </div>

            <div class="flex">
                <span class="px-2 py-1 font-semibold">Marca:</span>
                <div class="w-[200px] px-2 py-1 border">{{ $brand }}</div>
            </div>
        </div>

        <div class="my-5">
            <span class="px-2 py-1 font-semibold">Descrição: </span>
            <div class="w-full h-[200px] px-2 py-1 mt-1 border">{{ $product->description }}</div>
        </div>
    </div>
</div>
