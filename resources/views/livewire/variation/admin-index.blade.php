<div class="w-full flex items-center flex-col px-3">
    <div class="bg-white w-full px-8 py-6 shadow-sm">
        <div class="w-full flex items-center justify-between mb-6">
            <h1 class="font-semibold">Variações</h1>
            <a
                href="{{ route('admin.variation.create') }}"
                class="bg-gray-900 hover:bg-gray-700 text-white px-3 py-1 rounded-md"
            >
                Cadastar
            </a>
        </div>

        <div class="w-full min-h-[335px]">
            <table class="w-full table-auto text-center">
                <thead class="border-b-2">
                    <tr>
                        <th class="border py-2 w-[100px]">ID</th>
                        <th class="border py-2">Tipo</th>
                        <th class="border py-2">Valor</th>
                        <th class="border py-2 w-[100px]">Ver</th>
                    </tr>
                    <tr>
                        <td class="border p-1 w-[100px]">
                            <input type="number" min="1000" wire:model="searchByID" class="w-full px-2 py-1 border rounded-md">
                        </td>
                        <td class="border p-1">
                            <select wire:model.change="searchByType" class="w-full px-2 py-1 border rounded-md">
                                <option value="{{ null }}">Selecionar</option>
                                <option value="size">Tamanho</option>
                                <option value="color">Cor</option>
                            </select>
                        </td>
                        <td class="border p-1">
                            <input type="text" wire:model="searchByValue" class="w-full px-2 py-1 border rounded-md">
                        </td>
                        <td class="border p-1 w-[100px]">
                            <button wire:click="search">
                                <x-icons.search />
                            </button>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($variations as $variation)
                    <tr class="hover:bg-gray-100">
                        <td class="border p-3">{{ $variation->id }}</td>

                        @if ($variation->type === 'size')
                        <td class="border p-3">Tamanho</td>
                        @elseif($variation->type === 'color')
                        <td class="border p-3">Cor</td>
                        @endif

                        <td class="border p-3">{{ $variation->value }}</td>
                        <td class="border p-3">
                            <a
                                class=" flex items-center justify-center"
                                href="{{ route('admin.variation.show', $variation->id) }}"
                            >
                                <x-icons.show />
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr class="hover:bg-gray-100">
                        <td class="border p-3"> - </td>
                        <td class="border p-3"> - </td>
                        <td class="border p-3"> - </td>
                        <td class="border p-3"> - </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="w-full h-5 mt-4 flex items-center justify-between">
            <select wire:model.change="selectedPerPage" class="w-[150px] border px-2 py-1 rounded-md">
                <option value="5">5 por página</option>
                <option value="10">10 por página</option>
                <option value="50">50 por página</option>
            </select>

            @if ($variations and $variations->hasPages())
            <span>Página {{ $variations->currentPage() }}</span>

            <div>{{ $variations->links() }}</div>
            @endif
        </div>
    </div>
</div>
