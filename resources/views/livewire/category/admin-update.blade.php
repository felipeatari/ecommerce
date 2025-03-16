<div class="w-full flex justify-center px-3">
    <form wire:submit.prevent="update" class="bg-white w-full px-10 py-5 shadow">
        <div class="w-full flex justify-between my-5">
            <a
                href="{{ route('admin.category.show', ['category' => $category->id]) }}"
            >
                <button
                    class="w-8 h-8 flex items-center justify-center bg-gray-900 hover:bg-gray-700 rounded-full"
                    onclick="window.history.back()"
                >
                    <x-icons.back />
                </button>
            </a>

            <div>
                <button
                    wire:click="update"
                    class="bg-gray-900 hover:bg-gray-700 text-white px-3 py-1"
                >
                    Salvar
                </button>
            </div>
        </div>

        <h1 class="font-bold my-10">Editar Categoria {{ $category->id }}</h1>

        @if ($errors->any())
        <div class="w-full flex flex-col border border-red-200 bg-red-100 text-red-600 px-2 py-1 my-5">
        @foreach ($errors->all() as $error)
            <span>{{ $error }}</span>
        @endforeach
        </div>
        @endif

        <div class="w-full flex items-center justify-between my-5">
            <input type="hidden" wire:model="id" value="{{ $category->id }}">

            <div class="w-full flex">
                <span class="px-2 py-1 font-semibold">Nome:</span>
                <input wire:model="name" class="w-full px-2 py-1 border" type="text">
            </div>

            <div class="flex">
                <span class="px-2 py-1 font-semibold">Pertence:</span>
                <select wire:model="parent" class="w-[200px] px-2 py-1 border">
                    <option value="0">selecionar</option>
                    @foreach ($categories as $categoryItem)
                    <option
                        value="{{ $categoryItem->id }}"
                        wire:key="{{ $categoryItem->id }}"
                    >
                        {{ $categoryItem->name }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>
</div>
