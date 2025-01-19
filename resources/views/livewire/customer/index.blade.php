<div class="w-full flex flex-col items-center mt-2 mx-2 bg-gray-50">
    <div class="w-[900px] max-[900px]:w-full flex flex-col items-center justify-between bg-white shadow py-2">
        <div class="w-full flex justify-between px-4 border-b mb-6">
            <h1 class="font-semibold pb-1">Cliente Luiz Felipe</h1>
            <a class="font-semibold" wire:navigate href="/logout">logout</a>
        </div>

        <header class="w-full flex justify-evenly px-5 py-1 mb-5">
            <a class="font-semibold" wire:navigate href="{{ route('customer.index') }}">Pedidos</a>
            <a class="font-semibold" wire:navigate href="{{ route('customer.info') }}">Informações</a>
        </header>

        <div class="w-full px-2">
            <table class="w-full text-center mt-2">
                <thead class="border-b-2">
                    <tr>
                        <th class="border py-1">Nº</th>
                        <th class="border py-1">Status</th>
                        <th class="border py-1">Data</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border py-1">1000</td>
                        <td class="border py-2 text-green-500 font-semibold">concluído</td>
                        <td class="border py-1">17/12/2024</td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- <span>Não há pedidios :)</span> --}}


        {{-- {{ Auth::user()->name }} --}}

        {{-- <img class="w-[150px] my-5" src="/assets/images/logo.png" alt="">

        <form class="px-8 my-5" @submit.prevent="login">
            <input class="w-full px-3 py-2 my-2 text-sm border rounded-md" placeholder="E-Mail" type="text">

            <input class="w-full px-3 py-2 my-2 text-sm border rounded-md" placeholder="Senha" type="password">

            <button class="w-full px-3 py-2 my-2 text-sm border rounded-md font-semibold bg-gray-700 hover:bg-gray-800 text-white">Login</button>
        </form>

        <span class="text-sm">Não tem uma conta? <a wire:navigate href="{{ route('account.register') }}" class="underline text-blue-900">Cadastre-se aqui</a></span> --}}
    </div>
</div>
