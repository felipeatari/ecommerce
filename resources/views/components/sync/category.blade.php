@props(['modalSyncCategory', 'categoryId'])

@if ($modalSyncCategory)
    <div class="w-full flex justify-center items-center fixed inset-0 bg-black bg-opacity-95">
        <div class="w-[400px] max-[400px]:w-full bg-white shadow-lg mx-2">
            <div class="w-full flex justify-between border-b p-5">
                <h1 class="font-semibold text-xl">Sincroinizar Categoria {{ $categoryId }} com o Bling?</h1>
            </div>
            <div class="w-full py-5 flex justify-around">
                <button wire:click="actionModalSyncCategory" class="font-semibold px-3 py-2 bg-gray-900 text-white">Cancelar</button>
                <button wire:click="confirmSyncCategory" class="font-semibold px-3 py-2 bg-gray-900 text-white">Confirmar</button>
            </div>
        </div>
    </div>
@endif
