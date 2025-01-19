<div class="w-full flex flex-col items-center my-10 max-[500px]:mt-2 max-[500px]:mb-10 bg-gray-50 max-[450px]:mx-2">
    <div class="w-[300px] max-[450px]:w-full flex flex-col items-center justify-between bg-white shadow pt-10 pb-5">
        <img class="w-[100px] mb-5" src="/assets/images/logo3.png" alt="">

        <form class="px-4 my-2" wire:submit.prevent="access">
            @if ($errors->any())
            <div class="w-full flex flex-col border border-red-200 bg-red-100 text-red-600 px-2 py-1 my-5">
            @foreach ($errors->all() as $error)
                <span>{{ $error }}</span>
            @endforeach
            </div>
            @endif

            <input wire:model="login" class="w-full px-3 py-2 my-1 text-sm border rounded-md" placeholder="E-Mail ou WhatsApp" type="text">

            <input wire:model="password" class="w-full px-3 py-2 my-2 text-sm border rounded-md" placeholder="Senha" type="password">

            <button wire:click="access" class="w-full px-3 py-2 mt-2 text-sm border rounded-md font-semibold bg-gray-700 hover:bg-gray-800 text-white">Login</button>
        </form>

        <span class="text-sm mt-6">Não tem uma conta? <a wire:navigate href="{{ route('register') }}" class="underline text-blue-900">Cadastre-se aqui</a></span>
    </div>
</div>
