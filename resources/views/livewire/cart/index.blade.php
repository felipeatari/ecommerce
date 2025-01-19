<div class="w-full flex-1 flex justify-center bg-white">
    <x-cart.modal-shipping-calculation :$modalShippingCalculation :$shippingCalculation :$zipCode />
    <x-cart.modal-account-customer :$modalAccountCustomer />

    @if ($itemsCart)
    <x-cart.items-cart :$itemsCart :$totalItems :$subtotal :$shippingCost :$shippingType :$total />
    @else
    <div class="w-full h-full flex justify-center bg-white">
        <span class="mt-10">O carrinho está vazio!</span>
    </div>
    @endif
</div>
