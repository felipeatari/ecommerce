@props(['modalShippingCalculation', 'shippingCalculation'])

@if ($modalShippingCalculation)
    <div class="w-full flex justify-center items-center fixed inset-0 bg-black bg-opacity-80">
        <div class="w-[600px] bg-white shadow-lg">
            <div class="flex justify-between border-b p-5">
                <h1 class="font-semibold text-2xl">Opções de frete e entrega</h1>
                <button wire:click="closeModalShippingCalculation" class="font-bold border px-3 py-1">X</button>
            </div>
            <ul class="w-full px-5">
                @foreach ($shippingCalculation as $i => $item)
                <li class="w-full flex flex-col border-b pb-2">
                    <span class="w-full pt-5 pb-5 font-semibold">{{ $item['name'] }}</span>
                    <div class="w-full flex justify-between">
                        <span>Prazo atá {{ $item['delivery_time'] }} dias</span>
                        <span class="font-semibold px-3 py-2 border">R$ {{ $item['price'] }}</span>
                    </div>
                </li>
                @endforeach
            </ul>
            <div class="m-5"><span class="bg-gray-200 text-sm px-2 py-1">Valores sujeito a alteção</span></div>
        </div>
    </div>
@endif
