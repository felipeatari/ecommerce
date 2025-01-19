<?php

namespace App\Livewire\Customer;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        if (session()->exists('cart.back_cart')) {
            session()->forget('cart.back_cart');
        }

        return view('livewire.customer.index');
    }
}
