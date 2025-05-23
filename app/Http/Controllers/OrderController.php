<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Item;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('item')->where('is_checkout', false)->latest()->paginate(10);
        $transactions = Transaction::latest()->paginate(10);

        return view('orders.index', compact('orders', 'transactions'));
    }

    public function create()
    {
        $items = Item::all();
        return view('orders.create', compact('items'));
    }

    public function show($orderId)
    {
        $order = Order::with('item')->findOrFail($orderId);
        return view('orders.show', compact('order'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $item = Item::findOrFail($validated['item_id']);

        if ($item->stock < $validated['quantity']) {
            return back()->withErrors(['quantity' => 'Stok barang tidak mencukupi.'])->withInput();
        }

        $order = Order::create([
            'item_id' => $item->id,
            'quantity' => $validated['quantity'],
            'discount' => 0,
            'final_price' => $item->price * $validated['quantity'],
            'total_price' => $item->price * $validated['quantity'],
            'is_checkout' => false,
        ]);

        $item->decrement('stock', $validated['quantity']);

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibuat.');
    }

    public function cetakPDF($id)
    {
        $order = Order::with('item')->findOrFail($id);
        $pdf = PDF::loadView('orders.pdf', compact('order'));
        return $pdf->download('nota-pemesanan.pdf');
    }

    public function checkout(Request $request)
    {
        $selectedOrders = $request->input('selected_orders');

        if (!$selectedOrders || !is_array($selectedOrders)) {
            return redirect()->back()->with('error', 'Pilih pesanan terlebih dahulu.');
        }

        DB::beginTransaction();
        try {
            $totalAmount = 0;
            $selectedOrdersData = [];

            foreach ($selectedOrders as $orderId) {
                $order = Order::find($orderId);

                if ($order && !$order->is_checkout) {
                    Transaction::create([
                        'order_id' => $order->id,
                        'item_name' => $order->item->name,
                        'quantity' => $order->quantity,
                        'total_price' => $order->final_price,
                        'transaction_date' => now(),
                    ]);

                    DB::table('orders')
                        ->where('id', $order->id)
                        ->update(['is_checkout' => true]);

                    $selectedOrdersData[] = [
                        'name' => $order->item->name,
                        'quantity' => $order->quantity,
                        'final_price' => $order->final_price,
                        'created_at' => $order->created_at,
                        'original_price' => $order->item->price * $order->quantity,
                        'discount' => ($order->item->price * $order->quantity) - $order->final_price,
                        'total_price' => $order->final_price,
                    ];

                    $totalAmount += $order->final_price;
                }
            }

            DB::commit();

            return view('orders.print', [
                'selectedOrders' => $selectedOrdersData,
                'totalAmount' => $totalAmount,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat melakukan checkout.');
        }
    }
}