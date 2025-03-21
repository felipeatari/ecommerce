<div class="w-full flex justify-center px-3">
    <div class="w-full bg-white px-10 py-5 shadow">
        <div class="w-full flex justify-between my-5">
            <a
                href="{{ route('admin.variation.index') }}"
                class="w-8 h-8 flex items-center justify-center bg-gray-900 hover:bg-gray-700 rounded-full"
            >
                <x-icons.back />
            </a>

            <div>
                <a href="{{ route('admin.variation.update', $variation->id) }}">
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
                        <div class="w-full flex border border-red-200 bg-red-100 text-red-600 px-2 py-1 mb-2">{{ $message }}</div>
                        @enderror
                        <span class="text-xl">Excuir essa variacao?</span>
                        <div class="mt-10">
                            <button class="bg-gray-900 hover:bg-gray-700 text-white px-3 py-1" wire:click="destroy">Sim</button>
                            <button class="bg-gray-900 hover:bg-gray-700 text-white px-3 py-1" wire:click="modalDelete">Não</button>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <h1 class="font-bold my-10">Variação {{ $variation->id }}</h1>

        <div class="w-full flex items-center justify-between my-10">
            <div class="flex">
                <span class="px-2 py-1 font-semibold">Tipo:</span>
                <div class="w-[200px] px-2 py-1 border">
                    @if ($variation->type === 'size')
                        Tamanho
                        @elseif($variation->type === 'color')
                        Cor
                        @endif
                </div>
            </div>

            <div class="flex">
                <span class="px-2 py-1 font-semibold">Valor:</span>
                <div class="w-[200px] px-2 py-1 border">
                    {{ $variation->value }}
                </div>
            </div>

            <div class="flex">
                <span class="px-2 py-1 font-semibold">Código:</span>
                <div class="w-[200px] px-2 py-1 border">
                    {{ $variation->code }}
                </div>
            </div>
        </div>

        <div class="w-full my-5">
            <span class="px-2 py-1 font-semibold">Extra:</span>
            <div wire:model="extra" class="w-full h-[100px] px-2 py-1 mt-1 border"></div>
        </div>
    </div>
</div>
