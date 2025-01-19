<div class="w-full">
    <x-product.index-banner/>

    <div class="w-full flex flex-col">
        <h1 class="ml-4 mt-4 text-lg font-semibold">Categorias:</h1>
        <div class="w-full flex justify-around overflow-x-auto scrollbar py-8 px-5">
            <div class="flex space-x-5">
                <div class="w-52 h-52 flex items-center justify-center bg-gray-950 text-white text-xl font-semibold rounded-full">
                    Camiseta
                </div>

                <div class="w-52 h-52 flex items-center justify-center bg-gray-950 text-white text-xl font-semibold rounded-full">
                    Camisa
                </div>

                <div class="w-52 h-52 flex items-center justify-center bg-gray-950 text-white text-xl font-semibold rounded-full">
                    Short
                </div>

                <div class="w-52 h-52 flex items-center justify-center bg-gray-950 text-white text-xl font-semibold rounded-full">
                    Bermuda
                </div>

                <div class="w-52 h-52 flex items-center justify-center bg-gray-950 text-white text-xl font-semibold rounded-full">
                    Calça
                </div>
            </div>
        </div>
    </div>

    <div class="w-full h-[300px] my-10 hidden md:block">
        <img class="w-full h-full object-cover object-center" src="/assets/images/banner-desktop-2.png" alt="">
    </div>

    <div class="w-full h-[300px] my-10 block md:hidden">
        <img class="w-full h-full object-cover object-center" src="/assets/images/banner-mobile-2.png" alt="">
    </div>

    @if ($products)
    <x-product.index-products :$products />
    @else
    <div class="w-full flex justify-center bg-white py-20">
        <span class="text-2xl font-semibold">Não há produtos :(</span>
    </div>
    @endif
</div>
