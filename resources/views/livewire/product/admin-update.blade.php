<div class="w-full flex justify-center px-3">
    <form wire:submit.prevent="update" class="bg-white w-full px-10 py-5 shadow">
        <div class="w-full flex justify-between my-5">
            <a
                href="{{ route('admin.product.show', $product->id) }}"
                class="w-8 h-8 flex items-center justify-center bg-gray-900 hover:bg-gray-700 rounded-full"
            >
                <x-icons.back />
            </a>

            <button
                wire:click="update"
                class="bg-gray-900 hover:bg-gray-700 text-white px-3 py-1"
            >
                Salvar
            </button>
        </div>

        <h1 class="font-bold my-10">Editar Produto {{ $product->id }}</h1>

        @if ($errors->any())
        <div class="w-full flex flex-col border border-red-200 bg-red-100 text-red-600 px-2 py-1 my-5">
        @foreach ($errors->all() as $error)
            <span>{{ $error }}</span>
        @endforeach
        </div>
        @endif

        <div class="flex mt-5 mb-5">
            <span class="px-2 py-1 font-semibold">Nome:</span>
            <input wire:model="name" class="w-full px-2 py-1 border" type="text">
        </div>

        <div class="w-full flex items-center justify-between">
            <div class="flex mt-5 mb-5">
                <span class="px-2 py-1 font-semibold">Categoria:</span>
                <select wire:model="categoryId" class="w-[200px] border px-2 py-1">
                    <option value="{{ null }}">Selecionar</option>
                    @foreach ($category as $id => $name)
                    <option
                        value="{{ $id }}"
                        wire:key="{{ $id }}"
                    >
                        {{ $name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <span class="px-2 py-1 font-semibold">Marca:</span>
                <select wire:model="brandId" class="w-[200px] border px-2 py-1">
                    <option value="{{ null }}">Selecionar</option>
                    @foreach ($brand as $id => $name)
                    <option
                        value="{{ $id }}"
                        wire:key="{{ $id }}"
                    >
                        {{ $name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center">
                <span class="px-2 py-1 font-semibold">Ativo:</span>
                <input class="w-5 h-5" wire:model="active" type="checkbox">
            </div>
        </div>

        <div class="my-5">
            <span class="px-2 py-1 font-semibold">Descrição:</span>
            <textarea wire:model="description" class="w-full h-[200px] px-2 py-1 mt-1 border" cols="30" rows="10"></textarea>
        </div>
    </form>
</div>

