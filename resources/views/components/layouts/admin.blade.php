<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/icon.png')}}" type="image/x-icon">
    @vite('resources/css/app.css')
    <title>{{ $title ?? config('app.name') }}</title>
</head>

<body>
    <div class="w-full h-screen flex">
        <div class="w-96 h-screen flex flex-col justify-between items-center p-2.5 border-r-2 bg-white text-gray-600"><!-- Coluna esquerda -->
            <div class="w-full"><!-- Menu -->
                <div class="flex flex-col justify-center items-center mb-5">
                    <a href="/admin">
                        <img class="w-[150px] my-4" src="{{ asset('assets/images/logo.png')}} " alt="">
                    </a>
                </div>

                @php
                    $routeName = Route::currentRouteName();

                    $products = [
                        'admin.category.index' => 'Categorias',
                        'admin.brand.index' => 'Marcas',
                        'admin.product.index' => 'Produtos',
                        'admin.variation.index' => 'Variações',
                        'admin.sku.index' => 'Skus',
                    ];

                    $orders = [
                        'admin.order.index' => 'Listar',
                    ];
                @endphp

                <fieldset class="px-2 my-2">
                    <legend class="w-full font-semibold cursor-pointer">Produto</legend>
                    <div class="w-full flex flex-col text-sm">
                        @foreach ($products as $route => $name)
                            <a
                                href="{{ route($route) }}"
                                @class([
                                    'w-full px-1 py-1',
                                    'hover:bg-gray-100',
                                    'bg-gray-300' => $routeName === $route
                                ])
                            >
                                {{ $name }}
                            </a>
                        @endforeach
                    </div>
                </fieldset>

                <fieldset class="px-2 my-2">
                    <legend class="w-full font-semibold">Pedido</legend>
                    <div class="w-full flex flex-col text-sm">
                        @foreach ($orders as $route => $name)
                            <a
                                href="{{ route($route) }}"
                                @class([
                                    'w-full px-1 py-1',
                                    'hover:bg-gray-100',
                                    'bg-gray-300' => $routeName === $route
                                ])
                            >
                                {{ $name }}
                            </a>
                        @endforeach
                    </div>
                </fieldset>

                <fieldset class="px-2 my-2">
                    <legend class="w-full font-semibold">Sincronizar Dados</legend>
                    <div class="w-full flex flex-col text-sm">
                        {{-- @foreach ($orders as $route => $name)
                            <a
                                href="{{ route($route) }}"
                                @class([
                                    'w-full px-1 py-1',
                                    'hover:bg-gray-100',
                                    'bg-gray-300' => $routeName === $route
                                ])
                            >
                                {{ $name }}
                            </a>
                        @endforeach --}}
                    </div>
                </fieldset>
            </div><!-- Menu -->

            <div class="w-full flex flex-col items-center p-1 text-xs text-gray-900"><!-- Rodapé -->
                <p>© Todos os direitos reservados</p>
                <p>CNPJ: 12.345.678/0001-10</p>
            </div><!-- Rodapé -->
        </div><!-- Coluna esquerda -->

        <div class="w-full h-screen flex flex-col bg-gray-100 overflow-auto pb-10"><!-- Coluna direita -->
            <div class="flex items-center justify-between bg-white m-3 p-3 shadow-sm">
                <span class="text-gray-900 font-semibold">Área Administrativa</span>
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
