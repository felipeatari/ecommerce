<div class="w-full block md:hidden"><!-- Bloco header mobile -->
    <div class="w-full flex flex-col items-center justify-center pt-2"><!-- Topo -->
        <div class="w-[200px] h-[100px] flex items-center justify-center">
            <a class="w-full" href="/">
                <img class="w-full" src="/assets/images/logo.png" alt="">
            </a>
        </div>

        <div class="w-full flex items-center justify-around my-6">
            <a href="">
                <x-icons.bars />
            </a>
            <a href="/login">
                <x-icons.account />
            </a>
            <a href="/carrinho" class="flex items-center">
                <x-icons.cart />

                @if (session()->exists('totalItemsCart'))
                <span id="total-items-cart" class="font-bold">{{ session('totalItemsCart') }}</span>
                @else
                <span id="total-items-cart" class="font-bold">0</span>
                @endif
            </a>
        </div>

        <div class="w-full flex items-center border rounded-md mx-4 pr-2">
            <input id="search" type="search" class="w-full px-2 py-4 rounded-md" placeholder="Buscar produto...">
            <button id="btn-search"><x-icons.search /></button>
        </div>
    </div><!-- Topo -->

    {{-- <div class="w-full flex items-center justify-center p-2"><!-- Menu -->
        <div class="w-[400px] flex items-center justify-evenly">
            <a href="/" class="item-menu-desktop item-princiapl-menu-desktop">
                Home
            </a>
        </div>
    </div><!-- Menu --> --}}
</div><!-- Bloco header mobile -->
