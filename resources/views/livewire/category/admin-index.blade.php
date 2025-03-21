<div class="w-full flex items-center flex-col px-3">
    <div class="w-full bg-white px-8 py-6 shadow-sm">
        <div class="w-full flex items-center justify-between mb-6">
            <h1 class="font-semibold">Categorias</h1>
            <a
                href="{{ route('admin.category.create') }}"
                class="bg-gray-900 hover:bg-gray-700 text-white px-3 py-1 rounded-md"
            >
                Cadastar
            </a>
        </div>

        <div class="w-full min-h-[325px]">
            <table class="w-full table-auto text-center">
                <thead class="border-b-2">
                    <tr>
                        <th class="border py-2 w-[100px]">ID</th>
                        <th class="border py-2">Nome</th>
                        <th class="border py-2 w-[100px]">Ações</th>
                    </tr>

                        <tr>
                            <td class="border p-1 w-[100px]">
                                <input type="number" min="1000" wire:model="searchByID" class="w-full px-2 py-1 border rounded-md">
                            </td>
                            <td class="border p-1">
                                <input type="text" wire:model="searchByName" class="w-full px-2 py-1 border rounded-md">
                            </td>
                            <td class="border p-1 w-[100px]">
                                <button wire:click="search">
                                    <x-icons.search />
                                </button>
                            </td>
                        </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                    <tr class="hover:bg-gray-100">
                        <td class="border p-3">
                            {{ $category->id }}
                        </td>
                        <td class="border p-3">
                            {{ $category->name }}
                        </td>
                        <td class="border p-3">
                            <a
                                class=" flex items-center justify-center"
                                href="{{ route('admin.category.show', $category->id) }}"
                            >
                                <x-icons.show />
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr class="hover:bg-gray-100">
                        <td class="border p-3" colspan="3">
                            Nenhum registro encontrado
                        </td>
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

            @if ($categories and $categories->hasPages())
            <span>Página {{ $categories->currentPage() }}</span>

            <div>{{ $categories->links() }}</div>
            @endif
        </div>
    </div>
</div>
