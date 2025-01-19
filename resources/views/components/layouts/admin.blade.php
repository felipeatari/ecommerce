<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/assets/images/icon.png" type="image/x-icon">
    @vite('resources/css/app.css')
    <title>{{ $title ?? config('app.name') }}</title>
</head>

<body>
    <div class="w-full h-screen flex">
        <div class="w-96 h-screen flex flex-col justify-between items-center p-2.5 border-r-2 bg-white text-gray-600"><!-- Coluna esquerda -->
            <div class="w-full"><!-- Menu -->
                <div class="flex flex-col justify-center items-center mb-5">
                    <a href="/admin">
                        <img class="w-[150px] my-4" src="/assets/images/logo.png" alt="">
                    </a>
                </div>

                <fieldset class="px-2 my-2">
                    <legend class="w-full font-semibold cursor-pointer">Produto</legend>
                    <div class="w-full flex flex-col text-sm">
                        <a wire:navigate href="/admin/categoria/listar" class="w-full hover:bg-gray-200 px-1 py-1">Categorias</a>
                        <a wire:navigate href="/admin/produto/listar" class="w-full hover:bg-gray-200 px-1 py-1">Produtos</a>
                        <a href="/admin/variacao/listar" class="w-full hover:bg-gray-200 px-1 py-1">Variações</a>
                        <a wire:navigate href="/admin/sku/listar" class="w-full hover:bg-gray-200 px-1 py-1">Skus</a>
                    </div>
                </fieldset>

                <fieldset class="px-2 my-2">
                    <legend class="w-full font-semibold">Pedido</legend>
                    {{-- <div class="w-full flex flex-col text-sm">
                        <a href="/admin/produto/listar" class="w-full hover:bg-gray-200 px-2 py-1">Produtos</a>
                        <a href="/admin/categoria/listar" class="w-full hover:bg-gray-200 px-2 py-1">Categorias</a>
                        <a href="#" class="w-full hover:bg-gray-200 px-2 py-1">Skus</a>
                        <a href="#" class="w-full hover:bg-gray-200 px-2 py-1">Variações</a>
                    </div> --}}
                </fieldset>
            </div><!-- Menu -->

            <div class="w-full flex flex-col items-center p-1 text-xs text-gray-900"><!-- Rodapé -->
                <p>© Todos os direitos reservados</p>
                <p>CNPJ: 12.345.678/0001-10</p>
            </div><!-- Rodapé -->
        </div><!-- Coluna esquerda -->

        <div class="w-full h-screen flex flex-col bg-gray-100 overflow-auto pb-10"><!-- Coluna direita -->
            <div class="flex items-center justify-between bg-white m-3 p-3 shadow-sm">
                <span class="text-gray-900 font-semibold">Dashboard</span>
                <div class="flex items-center">
                    <a wire:navigate class="mr-2" href="/logout">
                        <x-icons.logout />
                    </a>

                    <div class="rounded-full bg-gray-900 text-white w-10 h-10 flex items-center justify-center">
                        <span>LF</span>
                    </div>
                </div>
            </div>

            {{ $slot }}
        </div><!-- Coluna direita -->
    </div>
</body>

</html>
