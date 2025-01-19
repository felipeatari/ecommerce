<div class="w-full flex-1 flex flex-col items-center justify-center">
    <form class="w-[400px] max-[500px]:w-full px-5 my-5 bg-white shadow relative" wire:submit.prevent="confirm">
        <div class="flex justify-between my-4 border-b">
            <div>
                <span>Carrinho:</span>
                <span>R$ {{ number_format(($cartTotal), 2, ',') }}</span>
            </div>
            <div>
                <span>Subtotal:</span>
                <span>R$ {{ number_format(($subtotal / 100), 2, ',') }}</span>
            </div>
        </div>

        <div class="w-full flex my-2">
            <select wire:model.live="installment" class="w-full border px-2 py-1">
                <option value="1">1x</option>
                <option value="2">2x</option>
                <option value="3">3x</option>
                <option value="4">4x</option>
                <option value="5">5x</option>
                <option value="6">6x</option>
                <option value="7">7x</option>
                <option value="8">8x</option>
                <option value="9">9x</option>
                <option value="10">10x</option>
                <option value="11">11x</option>
                <option value="12">12x</option>
            </select>

            <div class="w-full flex items-center px-2">
                <span>de R$ {{ number_format(($installmentValue / 100), 2, ',') }}</span>
            </div>
        </div>

        <div class="w-full flex items-center justify-between my-1">
            <input wire:model="number" class="w-full px-3 py-2 text-sm border rounded-md mr-2" placeholder="1234 1234 1234 1234" type="text">
            <div class="w-full flex justify-between mr-3">
                <img class="w-[30px]" src="https://pagarme-website-cms-images.pagar.me/master_6b35560030.svg?w=64&q=75" alt="Master Card">
                <img class="w-[30px]" src="https://pagarme-website-cms-images.pagar.me/visa_0a185400fc.svg?w=64&q=75" alt="Visa">
                <img class="w-[30px]" src="https://pagarme-website-cms-images.pagar.me/elo_18388e6630.svg?w=64&q=75" alt="ELO">
                <img class="w-[30px]" src="https://pagarme-website-cms-images.pagar.me/american_abf5672e02.svg?w=64&q=75" alt="AMERICAN EXPRESS">
                <img class="w-[30px]" src="https://pagarme-website-cms-images.pagar.me/hiper_cee4589c8f.svg?w=64&q=75" alt="HiperCard">
            </div>
        </div>

        <div class="w-full flex my-1">
            <input wire:model="date" class="w-full px-3 py-2 my-1 mr-1 text-sm border rounded-md" placeholder="MM/YY" type="text">
            <input wire:model="cvc" class="w-full px-3 py-2 my-1 ml-1 text-sm border rounded-md" placeholder="CVC" type="text">
        </div>

        <button type="button" wire:click="confirm" class="w-full px-3 py-2 mb-5 text-sm border rounded-md font-semibold bg-gray-700 hover:bg-gray-800 text-white">Confirmar</button>
    </form>
</div>
