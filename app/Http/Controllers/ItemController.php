<?php
namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();
        return view('items.index', compact('items'));
    }

    public function create()
    {
        $items = Item::all();
        return view('items.create', compact('items'));
    }

    public function edit(Item $item)
    {
        return view('items.edit', compact('item'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'diskon' => 'nullable|numeric|min:0|max:100',
        ]);

        $diskon = $validated['diskon'] ?? 0;
        $finalPrice = $validated['price'] - ($validated['price'] * $diskon / 100);
        $finalPrice = max($finalPrice, 0);

        Item::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'diskon' => $diskon,
            'final_price' => $finalPrice,
        ]);

        return redirect()->route('items.index')->with('success', 'Barang berhasil ditambahkan!');
    }

    public function update(Request $request, Item $item)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'diskon' => 'required|integer|min:0|max:100',
        ]);

        $diskon = $request->diskon;
        $finalPrice = $request->price - ($request->price * $diskon / 100);

        $finalPrice = max($finalPrice, 0);

        $item->update([
            'name' => $request->name,
            'price' => $request->price,
            'final_price' => $finalPrice,
            'stock' => $request->stock,
            'diskon' => $diskon,
        ]);

        return redirect()->route('items.index')->with('success', 'Barang berhasil diubah.');
    }

    public function destroy(Item $item)
    {
        $item->delete();
        return redirect()->route('items.index')->with('success', 'Barang berhasil dihapus.');
    }
}
