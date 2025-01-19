@props(['modalShippingCalculation', 'shippingCalculation', 'zipCode'])

@if ($modalShippingCalculation)
    <div class="w-full flex justify-center items-center fixed inset-0 bg-black bg-opacity-95">
        <div class="w-[600px] bg-white shadow-lg">
            <div class="flex justify-between border-b p-5">
                <h1 class="font-semibold text-2xl">Opções de frete e entrega</h1>
                <button wire:click="closeModalShippingCalculation" class="font-bold border px-3 py-1">X</button>
            </div>
            <ul class="w-full px-5">
                @if ($zipCode !== '62580000')
                @foreach ($shippingCalculation as $i => $item)
                <li class="w-full flex flex-col border-b pb-2">
                    <span class="w-full pt-5 pb-5 font-semibold">{{ $item['name'] }}</span>
                    <div class="w-full flex justify-between">
                        <span>Prazo de até {{ $item['delivery_time'] }} dias</span>
                        <button wire:click="selectedShipping({{ json_encode($item) }})" class="w-20 font-semibold px-3 py-2 bg-gray-900 text-white">R$ {{ $item['price'] }}</button>
                    </div>
                </li>
                @endforeach
                @elseif($zipCode === '62580000')
                <li class="w-full flex flex-col border-b pb-2">
                    <span class="w-full pt-5 pb-5 font-semibold">Centro de Acaraú-CE</span>
                    <div class="w-full flex justify-between">
                        <span>Prazo de até 1 dia</span>
                        <button wire:click="selectedShipping2('free')" class="w-20 font-semibold px-3 py-2 bg-gray-900 text-white">Grátis</button>
                    </div>
                </li>

                <li class="w-full flex flex-col border-b pb-2">
                    <span class="w-full pt-5 pb-5 font-semibold">Regiões de Acaraú-CE</span>
                    <div class="w-full flex justify-between">
                        <span>Prazo de até 3 dias</span>
                        <button wire:click="selectedShipping2('region')" class="w-20 font-semibold px-3 py-2 bg-gray-900 text-white">R$ 20</button>
                    </div>
                </li>
                @endif

                <li class="w-full flex flex-col border-b pb-2">
                    <span class="w-full pt-5 pb-5 font-semibold">Retirar na Loja - Vila Progresso, Macajuba, Acaraú-CE, N 123</span>
                    <div class="w-full flex justify-between">
                        <span>Prazo Inderterminado</span>
                        <button wire:click="selectedShipping2('no')" class="w-20 font-semibold px-3 py-2 bg-gray-900 text-white">Retirada</button>
                    </div>
                </li>
            </ul>
            <div class="m-5"><span class="bg-gray-200 text-sm px-2 py-1">Valores sujeito a alteção</span></div>
        </div>
    </div>
@endif
