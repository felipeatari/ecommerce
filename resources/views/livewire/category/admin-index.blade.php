<div class="w-full flex items-center flex-col px-3">
    <div class="w-full bg-white px-8 py-6 shadow-sm">
        <div class="w-full flex items-center justify-between mb-6">
            <h1 class="font-semibold">Categorias</h1>
            <a
            wire:navigate
            href="/admin/categoria/cadastrar"
            class="bg-gray-900 hover:bg-gray-700 text-white px-3 py-1"
            >
                Cadastar
            </a>
        </div>

        <div class="w-full h-[280px]">
            <table class="w-full table-auto text-center">
                <thead class="border-b-2">
                    <tr>
                        <th class="border py-2 w-[100px]">ID</th>
                        <th class="border py-2">Nome</th>
                        <th class="border py-2 w-[100px]">Ver</th>
                    </tr>
                </thead>
                <tbody>
                    @if (! $categories->count())
                    <tr class="hover:bg-gray-100">
                        <td class="border p-3"> - </td>
                        <td class="border p-3"> - </td>
                        <td class="border p-3"> - </td>
                    </tr>
                    @endif

                    @foreach ($categories as $category)
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
                            wire:navigate
                            href="/admin/categoria/ver/{{ $category->id }}"
                            >
                                <x-icons.show />
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="w-full flex justify-center mt-8">
            <div class="w-[300px] h-5 flex items-center justify-between">
                @if ($categories->hasPages())
                    @if ($categories->onFirstPage())
                        <span class="border px-3 py-1 font-semibold text-gray-400">Previous</span>
                    @else
                        <button
                        class="border px-3 py-1 font-semibold"
                        wire:click="previousPage"
                        wire:loading.attr="disabled"
                        rel="prev"
                        >
                            Previous
                        </button>
                    @endif

                    <span>Página: {{ $categories->currentPage() }}</span>

                    @if ($categories->onLastPage())
                        <span class="border px-3 py-1 font-semibold text-gray-400">Next</span>
                    @else
                        <button
                        class="border px-3 py-1 font-semibold"
                        wire:click="nextPage"
                        wire:loading.attr="disabled"
                        rel="next">Next</button>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
