<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Riwayat Pemesanan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if($orders->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="table-auto w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-gray-100 dark:bg-gray-700">
                                        <th class="px-4 py-2 border-b">Nama Barang</th>
                                        <th class="px-4 py-2 border-b">Jumlah</th>
                                        <th class="px-4 py-2 border-b">Total Harga</th>
                                        <th class="px-4 py-2 border-b">Tanggal</th>
                                        <th class="px-4 py-2 border-b">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-600">
                                            <td class="px-4 py-2 border-b">{{ $order->item->name }}</td>
                                            <td class="px-4 py-2 border-b">{{ $order->quantity }}</td>
                                            <td class="px-4 py-2 border-b">
                                                Rp{{ number_format($order->total_price, 0, ',', '.') }}
                                            </td>
                                            <td class="px-4 py-2 border-b">{{ $order->created_at->format('d-m-Y H:i') }}</td>
                                            <td class="px-4 py-2 border-b">
                                                <a href="{{ route('orders.print', $order->id) }}" target="_blank"
                                                    class="bg-green-600 text-white px-4 py-2 rounded-md shadow-lg hover:bg-green-700 transition">
                                                    Cetak Nota
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p>Tidak ada data pemesanan.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>