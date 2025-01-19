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
    <div class="w-full min-h-screen flex flex-col bg-gray-50">
        <header class="w-full border-b flex flex-col bg-white text-gray-800">
            <x-layouts.app-header-desktop />

            <x-layouts.app-header-mobile />
        </header>

        <section class="w-full flex flex-grow">
            {{ $slot }}
        </section>

        <footer class="w-full flex items-center justify-center flex-col py-8 bg-white">
            <span class="font-semibold mb-1">Lucky Store Oficial</span>
            {{-- <span class="my-1 text-sm">© Todos os direitos reservados</span> --}}
            <span class="text-xs mt-1"><b>CNPJ:</b> 12.345.678/0001-10</span>
        </footer>

        <script>
            document.addEventListener('livewire:init', () => {
                Livewire.on('add-cart', (event) => {
                    document.querySelector('#total-items-cart').textContent = event[0]
                });

                Livewire.on('clean-cart', (event) => {
                    document.querySelector('#total-items-cart').textContent = 0
                });
            });

            document.querySelector('#btn-search').addEventListener('click', ()=> {
                if (! document.querySelector('#search').value) return

                window.location.href = `{{ route('home.search') }}?q=${document.querySelector('#search').value}`
            })
        </script>
    </div>
</body>
</html>
