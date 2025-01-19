<div class="w-full flex flex-col items-center mt-2 mx-2 bg-gray-50">
    <div class="w-[900px] max-[900px]:w-full flex flex-col items-center justify-between bg-white shadow py-2">
        <div class="w-full flex justify-between px-4 border-b mb-6">
            <h1 class="font-semibold pb-1">Cliente Luiz Felipe</h1>
            <a class="font-semibold" wire:navigate href="{{ route('logout') }}">logout</a>
        </div>

        <header class="w-full flex justify-evenly px-5 py-1 mb-5">
            <a class="font-semibold" wire:navigate href="{{ route('customer.index') }}">Pedidos</a>
            <a class="font-semibold" wire:navigate href="{{ route('customer.info') }}">Informações</a>
        </header>

        <div class="w-full px-2">
            Minhas informações
        </div>
    </div>
</div>
