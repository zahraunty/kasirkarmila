<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 dark:text-gray-200 leading-tight">
            {{ __('Nota Pembelian') }}
        </h2>
    </x-slot>

    <div class="py-10 max-w-4xl mx-auto">
        <div class="bg-white dark:bg-gray-900 shadow-lg rounded-lg p-8">
            <h2 class="text-3xl font-bold mb-6 text-gray-800 dark:text-gray-100 tracking-wide">Detail Pesanan</h2>

            @if(isset($transactionCode))
                <p class="mb-4 text-gray-700 dark:text-gray-300">
                    <span class="font-semibold">Kode Transaksi:</span> {{ $transactionCode }}
                </p>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-300 dark:border-gray-700 rounded-lg table-auto">
                    <thead class="bg-gray-100 dark:bg-gray-800">
                        <tr>
                            <th
                                class="border-b border-gray-300 dark:border-gray-700 px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide">
                                Nama Barang</th>
                            <th
                                class="border-b border-gray-300 dark:border-gray-700 px-6 py-3 text-center text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide">
                                Jumlah</th>
                            <th
                                class="border-b border-gray-300 dark:border-gray-700 px-6 py-3 text-right text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide">
                                Harga Asli</th>
                            <th
                                class="border-b border-gray-300 dark:border-gray-700 px-6 py-3 text-right text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide">
                                Harga Setelah Diskon</th>
                            <th
                                class="border-b border-gray-300 dark:border-gray-700 px-6 py-3 text-right text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide">
                                Diskon</th>
                            <th
                                class="border-b border-gray-300 dark:border-gray-700 px-6 py-3 text-right text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide">
                                Total Harga</th>
                            <th
                                class="border-b border-gray-300 dark:border-gray-700 px-6 py-3 text-center text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide">
                                Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300">
                        @if(isset($selectedOrders) && count($selectedOrders) > 0)
                            @foreach($selectedOrders as $order)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                                    <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 text-sm font-medium">
                                        {{ $order['name'] }}
                                    </td>
                                    <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 text-center text-sm">
                                        {{ $order['quantity'] }}
                                    </td>
                                    <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 text-right text-sm">
                                        Rp{{ number_format($order['original_price'], 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 text-right text-sm">
                                        Rp{{ number_format($order['final_price'], 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 text-right text-sm">
                                        Rp{{ number_format($order['discount'], 0, ',', '.') }}
                                    </td>
                                    <td
                                        class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 text-right text-sm font-semibold">
                                        Rp{{ number_format($order['total_price'], 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 text-center text-sm">
                                        {{ \Carbon\Carbon::parse($order['created_at'])->format('d-m-Y') }}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7"
                                    class="px-6 py-4 text-center text-gray-400 dark:text-gray-600 text-sm italic">
                                    Tidak ada data pesanan yang tersedia.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                    <tfoot class="bg-gray-100 dark:bg-gray-800">
                        <tr>
                            <td colspan="5"
                                class="px-6 py-3 text-right font-bold text-gray-700 dark:text-gray-300 uppercase text-sm tracking-wider">
                                Diskon Yang Didapatkan
                            </td>
                            <td class="px-6 py-3 text-right font-bold text-red-600 dark:text-red-400 text-lg">
                                Rp{{ number_format($totalDiskon ?? 0, 0, ',', '.') }}
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="5"
                                class="px-6 py-3 text-right font-bold text-gray-700 dark:text-gray-300 uppercase text-sm tracking-wider">
                                Total Harga
                            </td>
                            <td class="px-6 py-3 text-right font-bold text-gray-900 dark:text-white text-lg">
                                Rp{{ number_format($grandTotal ?? 0, 0, ',', '.') }}
                            </td>
                            <td></td>
                        </tr>

                        <tr>
                            <td colspan="5"
                                class="px-6 py-3 text-right font-bold text-gray-900 dark:text-gray-100 uppercase text-lg tracking-wider">
                                Total Yang Dibayar
                            </td>
                            <td class="px-6 py-3 text-right font-extrabold text-blue-700 dark:text-blue-400 text-xl">
                                Rp{{ number_format($grandTotal ?? 0, 0, ',', '.') }}
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>

                </table>
            </div>

            <div class="mt-8 flex justify-end space-x-4">
                <button id="print-button"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-7 rounded shadow-md transition duration-300">
                    Cetak
                </button>
                <a href="{{ route('transactions.index') }}"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-7 rounded shadow-md transition duration-300">
                    Selesai
                </a>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('print-button').addEventListener('click', function () {
            window.print();
        });
    </script>
</x-app-layout>