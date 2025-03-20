<div class="w-full flex justify-center px-3">
    <form wire:submit.prevent="store" class="bg-white w-full px-10 py-5 shadow">
        <div class="w-full flex justify-between my-5">
            <a
                href="{{ route('admin.category.index') }}"
                class="w-8 h-8 flex items-center justify-center bg-gray-900 hover:bg-gray-700 rounded-full"
             >
                <x-icons.back />
            </a>

            <button
                type="button"
                wire:click="store"
                class="bg-gray-900 hover:bg-gray-700 text-white px-3 py-1"
            >
                Salvar
            </button>
        </div>

        <h1 class="font-bold my-10">Cadastrar uma Categoria</h1>

        @if ($errors->any())
        <div class="w-full flex flex-col border border-red-200 bg-red-100 text-red-600 px-2 py-1 my-5">
        @foreach ($errors->all() as $error)
            <span>{{ $error }}</span>
        @endforeach
        </div>
        @endif

        <div class="w-full flex items-center justify-between my-5">
            <div class="w-full flex">
                <span class="px-2 py-1 font-semibold">Nome:</span>
                <input wire:model="name" class="w-full px-2 py-1 border" type="text">
            </div>

            <div class="flex mx-10">
                <span class="px-2 py-1 font-semibold">Pertence:</span>
                <select wire:model="parent" class="w-[200px] px-2 py-1 border">
                    <option value="0">selecionar</option>
                    @foreach ($categories as $category)
                    <option
                        value="{{ $category->id }}"
                        wire:key="{{ $category->id }}"
                    >
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center">
                <span class="px-2 py-1 font-semibold">Ativo:</span>
                <input class="w-5 h-5" wire:model="active" type="checkbox">
            </div>
        </div>
    </form>
</div>

