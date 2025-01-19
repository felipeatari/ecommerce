<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        Auth::logout();

        $cart = [];
        $totalItemsCart = null;

        if (session()->exists('cart')) {
            $cart = session()->get('cart');
            $totalItemsCart = session()->get('totalItemsCart');
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($cart) {
            session()->put('cart', $cart);
            session()->put('totalItemsCart', $totalItemsCart);
        }

        return redirect(route('login'));
    }
}
