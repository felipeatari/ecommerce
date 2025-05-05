<?php

namespace App\Livewire\Cart;

use Livewire\Component;

class Payment extends Component
{
    public ?string $date = '';
    public ?string $cvc = '';
    public ?string $number = '';

    public int $payment = 0;
    public int $installment = 1;
    public int|float $installmentValue = 0;

    public int|float $subtotal = 0;
    public int|float $cartTotal = 0;

    public function confirm()
    {
        dd('ok');
    }

    public function render()
    {
        $this->cartTotal = session()->get('cart.total');

        if ($this->installment === 1) {
            $this->subtotal = $this->cartTotal;

            $add = (5.29 / 100) * $this->subtotal;

            $this->subtotal += $add;
            $this->subtotal += 0.99;
            $this->subtotal += 3.67;
            $this->subtotal *= 100;
            $this->installmentValue = $this->subtotal;
        } elseif ($this->installment === 2) {
            $this->subtotal = $this->cartTotal;

            $this->subtotal = 150;
            $add = (8.31 / 100) * $this->subtotal;

            $this->subtotal += $add;
            $this->subtotal += 0.99;
            $this->subtotal += 3.67;
            $this->subtotal *= 100;
            $this->installmentValue = $this->subtotal / 2;
        } elseif ($this->installment === 3) {
            $this->subtotal = $this->cartTotal;

            $this->subtotal = 150;
            $add = (9.48 / 100) * $this->subtotal;

            $this->subtotal += $add;
            $this->subtotal += 0.99;
            $this->subtotal += 3.67;
            $this->subtotal *= 100;
            $this->installmentValue = $this->subtotal / 3;
        } elseif ($this->installment === 4) {
            $this->subtotal = $this->cartTotal;

            $this->subtotal = 150;
            $add = (10.65 / 100) * $this->subtotal;

            $this->subtotal += $add;
            $this->subtotal += 0.99;
            $this->subtotal += 3.67;
            $this->subtotal *= 100;
            $this->installmentValue = $this->subtotal / 4;
        } elseif ($this->installment === 5) {
            $this->subtotal = $this->cartTotal;

            $this->subtotal = 150;
            $add = (11.82 / 100) * $this->subtotal;

            $this->subtotal += $add;
            $this->subtotal += 0.99;
            $this->subtotal += 3.67;
            $this->subtotal *= 100;
            $this->installmentValue = $this->subtotal / 5;
        } elseif ($this->installment === 6) {
            $this->subtotal = $this->cartTotal;

            $this->subtotal = 150;
            $add = (12.99 / 100) * $this->subtotal;

            $this->subtotal += $add;
            $this->subtotal += 0.99;
            $this->subtotal += 3.67;
            $this->subtotal *= 100;
            $this->installmentValue = $this->subtotal / 6;
        } elseif ($this->installment === 7) {
            $this->subtotal = $this->cartTotal;

            $this->subtotal = 150;
            $add = (15.18 / 100) * $this->subtotal;

            $this->subtotal += $add;
            $this->subtotal += 0.99;
            $this->subtotal += 3.67;
            $this->subtotal *= 100;
            $this->installmentValue = $this->subtotal / 7;
        } elseif ($this->installment === 8) {
            $this->subtotal = $this->cartTotal;

            $this->subtotal = 150;
            $add = (16.35 / 100) * $this->subtotal;

            $this->subtotal += $add;
            $this->subtotal += 0.99;
            $this->subtotal += 3.67;
            $this->subtotal *= 100;
            $this->installmentValue = $this->subtotal / 8;
        } elseif ($this->installment === 9) {
            $this->subtotal = $this->cartTotal;

            $this->subtotal = 150;
            $add = (17.52 / 100) * $this->subtotal;

            $this->subtotal += $add;
            $this->subtotal += 0.99;
            $this->subtotal += 3.67;
            $this->subtotal *= 100;
            $this->installmentValue = $this->subtotal / 9;
        } elseif ($this->installment === 10) {
            $this->subtotal = $this->cartTotal;

            $this->subtotal = 150;
            $add = (18.69 / 100) * $this->subtotal;

            $this->subtotal += $add;
            $this->subtotal += 0.99;
            $this->subtotal += 3.67;
            $this->subtotal *= 100;
            $this->installmentValue = $this->subtotal / 10;
        } elseif ($this->installment === 11) {
            $this->subtotal = $this->cartTotal;

            $this->subtotal = 150;
            $add = (19.86 / 100) * $this->subtotal;

            $this->subtotal += $add;
            $this->subtotal += 0.99;
            $this->subtotal += 3.67;
            $this->subtotal *= 100;
            $this->installmentValue = $this->subtotal / 11;
        } elseif ($this->installment === 12) {
            $this->subtotal = $this->cartTotal;

            $this->subtotal = 150;
            $add = (21.03 / 100) * $this->subtotal;

            $this->subtotal += $add;
            $this->subtotal += 0.99;
            $this->subtotal += 3.67;
            $this->subtotal *= 100;
            $this->installmentValue = $this->subtotal / 12;
        }

        return view('livewire.cart.payment');
    }
}
