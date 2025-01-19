<div class="w-full flex flex-col">
    <h1 class="ml-4 mt-4 text-lg font-semibold">Lançamentos:</h1>
    <div class="w-full flex overflow-x-auto overflow-y-hidden scroll-smooth scrollbar px-2 pt-3 pb-4">
        @foreach ($products as $product)
            <a
            wire:navigate
            href="{{ route('home.show', [$product->product->slug]) }}?sku={{ $product->id }}&cor={{ $product->variation1->value }}&tam={{ $product->variation2->value }}"
            class="m-2"
            >
                <div class="w-[250px] h-[500px] max-[750px]:w-[200px] max-[750px]:h-[400px] max-[750px]:text-xs flex flex-col items-center justify-between border bg-white shadow-sm">
                    <div class="w-full h-[80%] flex items-center justify-center border">
                        @if ($product->productImage)
                        <img src="{{ asset($product->productImage) }}" alt="foto 4" class="h-full object-cover">
                        @else
                        Foto
                        @endif
                    </div>
                    <span class="w-full flex justify-center flex-wrap text-center font-semibold px-1">{{ $product->product->name }}</span>
                    <span class="mb-4">R$ {{ number_format($product->price, 2, ',') }}</span>
                </div>
            </a>
        @endforeach
    </div>
</div>
