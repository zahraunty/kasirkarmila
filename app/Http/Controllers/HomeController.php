<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $items = Item::doesntHave('cart')->where('stock', '>', 0)->orderBy('name')->get();

        $itemCarts = Item::has('cart')->with('cart')->orderByDesc('cart.created_at')->get();

        return view('home', compact('items', 'itemCarts'));
    }
}
