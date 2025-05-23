<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;

class CartController extends Controller
{
    public function show()
    {
        $cartItems = Cart::all();
        return view('cart.show', compact('cartItems'));
    }

    public function store()
    {
        if (request()->item_id) {
            Cart::create(request()->all());
        }

        return redirect()->back();
    }

    public function update(Cart $cart)
    {
        $cart->update(request()->all());

        return redirect()->back();
    }

    public function destroy(Cart $cart)
    {
        $cart->delete();

        return redirect()->back();
    }
}
