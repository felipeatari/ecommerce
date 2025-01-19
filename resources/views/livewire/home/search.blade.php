<div class="w-full flex flex-col items-center">
    <h1>Página Categorias</h1>
    <div class="w-full flex flex-wrap">
        @foreach ($products as $product)
            <a
            wire:navigate
            href="{{ route('home.show', [$product->product->slug]) }}?sku={{ $product->id }}&cor={{ $product->variation1->value }}"
            class="m-2"
            >
                <div class="w-[250px] h-[450px] flex flex-col items-center justify-between border bg-white shadow-sm">
                    <div class="w-full h-[80%] flex items-center justify-center border">
                        @if ($product->productImage)
                        <img src="{{ asset($product->productImage) }}" alt="foto 4" class="h-full object-cover">
                        @else
                        Foto
                        @endif
                    </div>
                    <span class="w-full flex justify-center flex-wrap text-center font-semibold">{{ $product->product->name }}</span>
                    <span class="mb-4">R$ {{ number_format($product->price, 2, ',') }}</span>
                </div>
            </a>
        @endforeach
    </div>
</div>
