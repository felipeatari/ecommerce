@props(['modalAccountCustomer'])

@if ($modalAccountCustomer)
    <div class="w-full flex justify-center items-center fixed inset-0 bg-black bg-opacity-95">
        <div class="w-[400px] max-[400px]:w-full bg-white shadow-lg mx-2">
            <div class="w-full flex justify-between border-b p-5">
                <h1 class="font-semibold text-xl">Você não está logado!</h1>
                <button wire:click="closemodalAccountCustomer" class="font-bold border px-3 py-1">X</button>
            </div>
            <div class="w-full py-5 flex justify-around">
                <a href="{{ route('login') }}" class="font-semibold px-3 py-2 bg-gray-900 text-white">Logar</a>
                <a href="{{ route('register') }}" class="font-semibold px-3 py-2 bg-gray-900 text-white">Cadastrar</a>
            </div>
        </div>
    </div>
@endif
