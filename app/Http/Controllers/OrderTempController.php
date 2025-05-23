<?php

namespace App\Http\Controllers;

use App\Models\OrderTemp;
use App\Models\Item;
use Illuminate\Http\Request;

class OrderTempController extends Controller
{
    public function index()
    {
        $orders = OrderTemp::all();
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $items = Item::all();
        return view('orders.create', compact('items'));
    }

    public function store(Request $request)
    {
        $item = Item::findOrFail($request->item_id);
        $harga_setelah_diskon = $item->price - ($item->price * $item->diskon / 100);

        OrderTemp::create([
            'nama_barang' => $item->name,
            'jumlah' => $request->jumlah,
            'harga_setelah_diskon' => $harga_setelah_diskon
        ]);

        return redirect('/pemesanan')->with('success', 'Pesanan ditambahkan');
    }
}
