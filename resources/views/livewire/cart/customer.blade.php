<div class="w-full flex-1 flex flex-col items-center justify-center">
    <form class="w-[500px] max-[500px]:w-full px-5 my-5 bg-white shadow relative" wire:submit.prevent="confirm">
        <a
        class="w-[75px] h-5 flex items-center justify-between mt-7"
        wire:navigate
        href="{{ route('cart.index') }}"
        >
            <span class="w-8 h-8 flex items-center justify-center bg-gray-700 font-semibold text-white rounded-full shadow">
                <x-icons.back />
            </span>
        </a>

        <h1 class="w-full text-xl text-center font-semibold my-5">Dados do Cliente</h1>

        @if ($errors->any())
        <div class="w-[460px] flex flex-col m-auto top-1">
        @foreach ($errors->all() as $error)
            <div class="flex justify-between bg-red-100 text-red-600 px-2 py-1 shadow my-1">
                <span>{{ $error }}</span>
            </div>
        @endforeach
        </div>
        @endif

        <div class="my-5">
            <span>Seus Dados</span>
            <input wire:model="name" class="w-full px-3 py-2 my-1 text-sm border rounded-md" placeholder="Nome" type="text">
            <input wire:model="cpf" class="w-full px-3 py-2 my-1 text-sm border rounded-md" placeholder="CPF" type="text">
        </div>

        <div class="my-5">
            <span>Contato</span>
            <input wire:model="email" class="w-full px-3 py-2 my-1 text-sm border rounded-md" placeholder="E-mail" type="text">
            <input wire:model="phone" class="w-full px-3 py-2 my-1 text-sm border rounded-md" placeholder="Celular" type="text">
        </div>

        <div class="my-5">
            <span>Endereço de Entrega</span>

            <div class="w-full flex">
                <input wire:model.live.debounce.500ms="zipCode" class="w-full px-3 py-2 my-1 mr-1 text-sm border rounded-md" placeholder="CEP" type="text">
                <input wire:model="state" class="w-full px-3 py-2 my-1 ml-1 text-sm border rounded-md" placeholder="Estado" type="text">
            </div>

            <div class="w-full flex">
                <input wire:model="city" class="w-full px-3 py-2 my-1 mr-1 text-sm border rounded-md" placeholder="Cidade" type="text">
                <input wire:model="neighborhood" class="w-full px-3 py-2 my-1 ml-1 text-sm border rounded-md" placeholder="Bairro" type="text">
            </div>

            <input wire:model="address" class="w-full px-3 py-2 my-1 text-sm border rounded-md" placeholder="Endereço" type="text">

            <div class="w-full flex">
                <input wire:model="number" class="w-[100px] px-3 py-2 my-1 mr-1 text-sm border rounded-md" placeholder="Número" type="number" min="0">
                <input wire:model="complement" class="w-full px-3 py-2 my-1 ml-1 text-sm border rounded-md" placeholder="Complemento (opcional)" type="text">
            </div>
        </div>

        <div>
            <span>Observação: (opcional)</span>
            <textarea wire:model="description" class="w-full h-[100px] px-2 py-1 mt-1 mb-5 border rounded-md" cols="30" rows="10"></textarea>
        </div>

        <button type="button" wire:click="confirm" class="w-full px-3 py-2 mb-5 text-sm border rounded-md font-semibold bg-gray-700 hover:bg-gray-800 text-white">Confirmar</button>
    </form>
</div>
