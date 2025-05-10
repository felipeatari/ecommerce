<div class="w-full flex justify-center px-3">
    <div class="w-full bg-white px-10 py-5 shadow">
        <h1 class="font-bold my-10">Pedido {{ $order->id }}</h1>

        <div class="flex my-10">
            <span class="px-2 py-1 font-semibold">Nome:</span>
            <div class="w-full px-2 py-1 border">{{ $order->name }}</div>
        </div>

        <div class="w-full flex items-center justify-between my-10">
            <div class="flex">
                <span class="px-2 py-1 font-semibold">Categoria:</span>
                <div class="min-w-[200px] px-2 py-1 border">
                    {{-- {{ formatCategoryTree(buildCategoryTree($order->category_id)) }} --}}
                </div>
            </div>

            <div class="flex">
                <span class="px-2 py-1 font-semibold">Marca:</span>
                {{-- <div class="w-[200px] px-2 py-1 border">{{ $brand }}</div> --}}
            </div>
        </div>

        <div class="my-5">
            <span class="px-2 py-1 font-semibold">Descrição: </span>
            <div class="w-full h-[200px] px-2 py-1 mt-1 border">{!! nl2br(e($order->description)) !!}</div>
        </div>
    </div>
</div>
