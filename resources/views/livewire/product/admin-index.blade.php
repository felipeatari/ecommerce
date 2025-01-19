<div class="w-full flex items-center flex-col px-3">
    <div class="bg-white w-full px-8 py-6 shadow-sm">
        <div class="w-full flex items-center justify-between mb-6">
            <h1 class="font-semibold">Produtos</h1>
            <a
            wire:navigate
            href="/admin/produto/cadastrar"
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
                    @if (! $products->count())
                    <tr class="hover:bg-gray-100">
                        <td class="border p-3"> - </td>
                        <td class="border p-3"> - </td>
                        <td class="border p-3"> - </td>
                        <td class="border p-3"> - </td>
                    </tr>
                    @endif

                    @foreach ($products as $product)
                    <tr class="hover:bg-gray-100">
                        <td class="border p-3">{{ $product->id }}</td>
                        <td class="border p-3">{{ $product->name }}</td>
                        <td class="border p-3">
                            <a
                            class=" flex items-center justify-center"
                            wire:navigate
                            href="/admin/produto/ver/{{ $product->id }}"
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
                @if ($products->hasPages())
                    @if ($products->onFirstPage())
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

                    <span>Página: {{ $products->currentPage() }}</span>

                    @if ($products->onLastPage())
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
