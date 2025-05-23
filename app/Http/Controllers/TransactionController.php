<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::query();

        if ($request->has('tanggal') && $request->input('tanggal') != '') {
            $query->whereDate('transaction_date', $request->input('tanggal'));
        }

        $transactions = $query
            ->select(
                'transaction_code',
                DB::raw('GROUP_CONCAT(CONCAT(item_name, " (", quantity, "x)") SEPARATOR "<br>") as item_names'),
                DB::raw('SUM(total_price) as total_price'),
                'transaction_date'
            )
            ->groupBy('transaction_code', 'transaction_date')
            ->orderBy('transaction_date', 'desc')
            ->paginate(10);



        return view('transactions.index', compact('transactions'));
    }

    public function storeMultiple(Request $request)
    {
        $selectedOrders = $request->input('selected_orders');

        if (!$selectedOrders || !is_array($selectedOrders)) {
            return redirect()->back()->with('error', 'Pilih pesanan terlebih dahulu.');
        }

        DB::beginTransaction();
        try {
            $totalAmount = 0;
            $itemDetails = [];
            $processedOrderIds = [];
            $transactionCode = 'TRX-' . Carbon::now()->format('YmdHis') . Str::random(4);

            foreach ($selectedOrders as $orderId) {
                $order = Order::with('item')->find($orderId);
                if (!$order) {
                    throw new \Exception("Order with ID {$orderId} not found.");
                }

                if (!$order->is_checkout && !in_array($orderId, $processedOrderIds)) {
                    $originalPrice = $order->item->price * $order->quantity;
                    $discountedPrice = $order->final_price;

                    $itemDetails[] = $order->item->name . ' (' . $order->quantity . 'x) - Asli: Rp ' . number_format($originalPrice, 0, ',', '.') .
                        ', Diskon: Rp ' . number_format($discountedPrice, 0, ',', '.') .
                        ', Total: Rp ' . number_format($order->total_price, 0, ',', '.');
                    $totalAmount += $order->total_price;
                    $order->update(['is_checkout' => true]);
                    $processedOrderIds[] = $orderId;


                    Transaction::create([
                        'transaction_code' => $transactionCode,
                        'item_name' => $order->item->name,
                        'quantity' => $order->quantity,
                        'total_price' => $order->total_price,
                        'transaction_date' => now(),
                    ]);
                }
            }

            if (empty($processedOrderIds)) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Tidak ada pesanan yang valid untuk di-checkout.');
            }

            DB::commit();

            $newTransactions = Transaction::where('transaction_code', $transactionCode)->get();
            $selectedOrdersForReceipt = $newTransactions->map(function ($transaction) {
                return [
                    'name' => $transaction->item_name,
                    'quantity' => $transaction->quantity,
                    'original_price' => ($transaction->total_price + ($transaction->discount ?? 0)) / $transaction->quantity,
                    'final_price' => $transaction->total_price / $transaction->quantity,
                    'discount' => $transaction->discount ?? 0,
                    'total_price' => $transaction->total_price,
                    'created_at' => $transaction->transaction_date,
                ];
            });


            return redirect()->route('orders.receipt')->with([
                'success' => 'Pesanan berhasil di-checkout dan transaksi disimpan.',
                'selectedOrders' => $selectedOrdersForReceipt->toArray(),
                'transactionCode' => $transactionCode,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan transaksi: ' . $e->getMessage());
        }
    }

    public function showReceipt(Request $request)
    {
        $selectedOrders = session('selectedOrders');
        $transactionCode = session('transactionCode');

        if (!$selectedOrders) {
            return redirect()->route('transactions.index')->with('error', 'Tidak ada nota untuk ditampilkan.');
        }

        $grandTotal = 0;
        $totalDiskon = 0;
        foreach ($selectedOrders as $order) {
            $grandTotal += $order['total_price'];
            $totalDiskon += $order['discount'];
        }

        return view('orders.receipt', compact('selectedOrders', 'grandTotal', 'totalDiskon', 'transactionCode'));
    }
}

