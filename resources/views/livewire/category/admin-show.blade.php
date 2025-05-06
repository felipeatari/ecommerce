<div class="w-full flex justify-center px-3">
    <div class="w-full bg-white px-10 py-5 shadow">
        <div class="w-full flex justify-between my-5">
            <a
                href="{{ route('admin.category.index') }}"
                class="w-8 h-8 flex items-center justify-center bg-gray-900 hover:bg-gray-700 rounded-full"
            >
                <x-icons.back />
            </a>

            <div>
                <a href="{{ route('admin.category.update', $category->id) }}">
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
                        <div class="w-full flex border border-red-200 bg-red-100 text-red-600 px-2 py-1 mb-2">{{ $message }}</div>
                        @enderror
                        <span class="text-xl">Excuir essa Categoria?</span>
                        <div class="mt-10">
                            <button class="bg-gray-900 hover:bg-gray-700 text-white px-3 py-1" wire:click="destroy">Sim</button>
                            <button class="bg-gray-900 hover:bg-gray-700 text-white px-3 py-1" wire:click="modalDelete">Não</button>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <h1 class="font-bold my-10">Vizualizar Categoria {{ $category->id }}</h1>

        <div class="w-full flex items-center justify-between my-5">
            <div class="w-full flex">
                <span class="px-2 py-1 font-semibold">Nome:</span>
                <div class="w-full px-2 py-1 border">
                    {{ $category->name }}
                </div>
            </div>

            <div class="w-full flex">
                <span class="px-2 py-1 font-semibold">Pertence:</span>
                <div class="min-w-[200px] px-2 py-1 border">
                    {{ formatCategoryTree(buildCategoryTree($category->id)) }}
                </div>
            </div>
        </div>
    </div>
</div>
