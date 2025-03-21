<div class="w-full flex justify-center px-3">
    <form wire:submit.prevent="update" class="bg-white w-full px-10 py-5 shadow">
        <div class="w-full flex justify-between my-5">
            <a
                href="{{ route('admin.variation.show', $variation->id) }}"
                class="w-8 h-8 flex items-center justify-center bg-gray-900 hover:bg-gray-700 rounded-full"
            >
                <x-icons.back />
            </a>

            <button
                type="button"
                wire:click="update"
                class="bg-gray-900 hover:bg-gray-700 text-white px-3 py-1 rounded-md"
            >
                Salvar
            </button>
        </div>

        <h1 class="font-bold my-10">Editar Variação {{ $variation->id }}</h1>

        @if ($errors->any())
        <div class="w-full flex flex-col border border-red-200 bg-red-100 text-red-600 px-2 py-1 my-5">
        @foreach ($errors->all() as $error)
            <span>{{ $error }}</span>
        @endforeach
        </div>
        @endif

        <div class="w-full flex items-center justify-between my-10">
            <div class="flex">
                <span class="px-2 py-1 font-semibold">Tipo:</span>
                <select wire:model="type" class="w-[200px] px-2 py-1 border">
                    <option value="{{ null }}">selecionar</option>
                    <option value="size">Tamanho</option>
                    <option value="color">Cor</option>
                </select>
            </div>

            <div class="flex">
                <span class="px-2 py-1 font-semibold">Valor:</span>
                <input wire:model="value" class="w-[200px] px-2 py-1 border" type="text">
            </div>

            <div class="flex">
                <span class="px-2 py-1 font-semibold">Código:</span>
                <input wire:model="code" class="w-[200px] px-2 py-1 border" type="text">
            </div>
        </div>

        <div class="w-full my-5">
            <span class="px-2 py-1 font-semibold">Extra:</span>
            <textarea wire:model="extra" class="w-full h-[100px] px-2 py-1 mt-1 border" cols="30" rows="10"></textarea>
        </div>
    </form>
</div>
