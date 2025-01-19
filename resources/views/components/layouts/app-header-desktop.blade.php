<div class="w-full hidden md:block mt-8 mb-4"><!-- Bloco Header Desktop -->
    <div class="w-full flex items-center justify-around py-2"><!-- Topo -->
        <div class="w-[140px] flex items-center justify-center">
            <a class="w-full" href="/">
                <img class="w-full" src="/assets/images/logo.png" alt="">
            </a>
        </div>

        <div class="w-[550px] flex items-center border rounded-md mx-4 pr-2">
            <input id="search" type="search" class="w-full px-2 py-1 mr-2" placeholder="Buscar produto...">
            <button id="btn-search"><x-icons.search /></button>
        </div>

        <div class="flex items-center justify-evenly">
            <a wire:navigate href="{{ route('customer.index') }}" class=" mr-4">
                <x-icons.account />
            </a>
            <a wire:navigate href="/carrinho" class="flex items-center">
                <x-icons.cart />

                @if (session()->exists('totalItemsCart'))
                <span id="total-items-cart" class="font-bold">{{ session('totalItemsCart') }}</span>
                @else
                <span id="total-items-cart" class="font-bold">0</span>
                @endif
            </a>
        </div>
    </div><!-- Topo -->

    <div class="w-full flex items-center justify-center"><!-- Menu -->
        <div class="w-[400px] flex items-center justify-evenly font-semibold">
            <a wire:navigate href="/" class="item-menu-desktop item-princiapl-menu-desktop">
                Home
            </a>
        </div>
    </div><!-- Menu -->
</div><!-- Bloco Header Desktop -->
