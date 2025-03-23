<div class="w-full flex items-center flex-col px-3">
    <div class="bg-white w-full px-8 py-6 shadow-sm">
        <div class="w-full flex items-center justify-between mb-6">
            <h1 class="font-semibold">Skus</h1>
            <a
                href="{{ route('admin.sku.create') }}"
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
                        <th class="border py-2">Produto</th>
                        <th class="border py-2">Variação 1</th>
                        <th class="border py-2">Variação 2</th>
                        <th class="border py-2 w-[100px]">Ver</th>
                    </tr>
                    <tr>
                        <td class="border p-1 w-[100px]">
                            <input type="number" min="1000" wire:model="searchByID" class="w-full px-2 py-1 border rounded-md">
                        </td>
                        <td class="border p-1">
                            <input type="text" wire:model="searchByProduct" class="w-full px-2 py-1 border rounded-md">
                        </td>
                        <td class="border p-1">
                            <input type="text" wire:model="searchByVariation1" class="w-full px-2 py-1 border rounded-md">
                        </td>
                        <td class="border p-1">
                            <input type="text" wire:model="searchByVariation2" class="w-full px-2 py-1 border rounded-md">
                        </td>
                        <td class="border p-1 w-[100px]">
                            <button wire:click="search">
                                <x-icons.search />
                            </button>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($skus as $sku)
                    <tr class="hover:bg-gray-100">
                        <td class="border p-3">{{ $sku->id }}</td>
                        <td class="border p-3">{{ $sku->getProduct()?->name }}</td>
                        <td class="border p-3"> {{ $sku->getVariation1()?->value }}</td>
                        <td class="border p-3"> {{ $sku->getVariation2()?->value }}</td>
                        <td class="border p-3">
                            <a
                                class=" flex items-center justify-center"
                                href="{{ route('admin.sku.show', $sku->id) }}"
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

            @if ($skus and $skus->hasPages())
            <span>Página {{ $skus->currentPage() }}</span>

            <div>{{ $skus->links() }}</div>
            @endif
        </div>
    </div>
</div>
