<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-orange-800 dark:text-orange-200 leading-tight text-center">
            {{ __('Nota Pembelian') }}
        </h2>
    </x-slot>

    <div class="py-10 max-w-4xl mx-auto">
        <div class="bg-black bg-opacity-50 shadow-lg rounded-lg p-8 transition-transform transform hover:scale-105">

            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-300 dark:border-gray-700 rounded-lg table-auto">
                    <thead class="bg-grey-600 dark:bg-grey-800">
                        <tr>
                            <th class="px-6 py-3 text-white text-sm font-semibold text-left uppercase tracking-wide">
                                Nama Barang</th>
                            <th class="px-6 py-3 text-white text-sm font-semibold text-center uppercase tracking-wide">
                                Jumlah</th>
                            <th class="px-6 py-3 text-white text-sm font-semibold text-right uppercase tracking-wide">
                                Harga Asli</th>
                            <th class="px-6 py-3 text-white text-sm font-semibold text-right uppercase tracking-wide">
                                Harga Setelah Diskon</th>
                            <th class="px-6 py-3 text-white text-sm font-semibold text-right uppercase tracking-wide">
                                Diskon</th>
                            <th class="px-6 py-3 text-white text-sm font-semibold text-right uppercase tracking-wide">
                                Total Harga</th>
                            <th class="px-6 py-3 text-white text-sm font-semibold text-center uppercase tracking-wide">
                                Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300">
                        @php
                            $grandTotal = 0;
                            $totalDiskon = 0;
                        @endphp
                        @if(isset($selectedOrders) && count($selectedOrders) > 0)
                            @foreach($selectedOrders as $order)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                                    <td class="px-6 py-4 border-b text-sm font-medium">{{ $order['name'] }}</td>
                                    <td class="px-6 py-4 border-b text-sm text-center">{{ $order['quantity'] }}</td>
                                    <td class="px-6 py-4 border-b text-sm text-right">
                                        Rp{{ number_format($order['original_price'], 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 border-b text-sm text-right">
                                        Rp{{ number_format($order['final_price'], 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 border-b text-sm text-right">
                                        Rp{{ number_format($order['discount'], 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 border-b text-sm font-semibold text-right">
                                        Rp{{ number_format($order['total_price'], 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 border-b text-sm text-center">
                                        {{ \Carbon\Carbon::parse($order['created_at'])->format('d-m-Y') }}
                                    </td>
                                </tr>
                                @php
                                    $grandTotal += $order['total_price'];
                                    $totalDiskon += $order['discount'];
                                @endphp
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-400 italic">Tidak ada data pesanan.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                    <tfoot class="bg-grey-600 dark:bg-grey-800">
                        <tr>
                            <td colspan="5" class="px-6 py-3 text-white font-bold text-sm text-right uppercase">Diskon
                                Yang Didapatkan</td>
                            <td class="px-6 py-3 text-red-500 font-bold text-lg text-right">
                                Rp{{ number_format($totalDiskon, 0, ',', '.') }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="5" class="px-6 py-3 text-white font-bold text-sm text-right uppercase">Total
                                Harga</td>
                            <td class="px-6 py-3 text-white font-bold text-lg text-right">
                                Rp{{ number_format($grandTotal, 0, ',', '.') }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="5" class="px-6 py-3 text-white font-bold text-lg text-right uppercase">Total
                                Yang Dibayar</td>
                            <td class="px-6 py-3 text-grey-200 font-extrabold text-xl text-right">
                                Rp{{ number_format($grandTotal, 0, ',', '.') }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="mt-8 flex justify-end gap-4">

                <button onclick="cetakStruk()"
                    class="bg-orange-600 hover:bg-orange-700 text-white font-semibold py-2 px-6 rounded shadow-md">
                    Cetak Struk
                </button>

                <a href="{{ route('transactions.index') }}"
                    class="bg-orange-600 hover:bg-orange-700 text-white font-semibold py-2 px-6 rounded shadow-md">
                    Selesai
                </a>
            </div>
        </div>
    </div>

    <div id="struk-print" class="hidden">
        <div style="font-family: monospace; font-size: 16px; color: black; padding: 10px;">
            <div style="text-align: center; border-bottom: 2px dashed #000; padding-bottom: 10px;">
                <h2 style="margin-bottom: 5px; font-weight: 900; font-size: 22px;">Toko MiMuCu</h2>
                <p style="margin: 0;">Jl. Raya Merdeka 098</p>
                <p style="margin: 0;">Telp: 0889-8976-7623</p>
                <hr>
                <p><em>Struk Pembelian</em></p>
            </div>

            <table style="width: 100%; margin-top: 10px; border-collapse: collapse; font-weight: 600;">
                <thead>
                    <tr>
                        <th style="border-bottom: 1px solid #000; padding: 8px;">Nama Barang</th>
                        <th style="border-bottom: 1px solid #000; padding: 8px;">Jumlah</th>
                        <th style="border-bottom: 1px solid #000; padding: 8px;">Harga</th>
                        <th style="border-bottom: 1px solid #000; padding: 8px;">Diskon</th>
                        <th style="border-bottom: 1px solid #000; padding: 8px;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $grandTotal = 0;
                        $totalDiskon = 0;
                    @endphp
                    @foreach($selectedOrders as $order)
                        @php
                            $grandTotal += $order['total_price'];
                            $totalDiskon += $order['discount'];
                        @endphp
                        <tr>
                            <td style="padding: 8px;">{{ $order['name'] }}</td>
                            <td style="padding: 8px; text-align: center;">{{ $order['quantity'] }}</td>
                            <td style="padding: 8px; text-align: right;">
                                {{ number_format($order['original_price'], 0, ',', '.') }}
                            </td>
                            <td style="padding: 8px; text-align: right;">
                                {{ number_format($order['discount'], 0, ',', '.') }}
                            </td>
                            <td style="padding: 8px; text-align: right;">
                                {{ number_format($order['total_price'], 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <hr style="border-top: 2px dashed #000; margin: 15px 0;">
            <p>Total Diskon: Rp{{ number_format($totalDiskon, 0, ',', '.') }}</p>
            <p>Total Bayar: <strong>Rp{{ number_format($grandTotal, 0, ',', '.') }}</strong></p>
            <hr style="border-top: 2px dashed #000; margin: 15px 0;">
            <p style="text-align: center;">Terima Kasih</p>
            <p style="text-align: center;">{{ \Carbon\Carbon::now()->format('d-m-Y H:i') }}</p>
        </div>
    </div>

    <script>
        function cetakStruk() {
            const strukContent = document.getElementById('struk-print').innerHTML;

            const printWindow = window.open('', '', 'resizable=yes,scrollbars=yes');

            printWindow.document.write(`
                <html>
                <head>
                    <title>Cetak Struk</title>
                    <style>
                        body {
                            font-family: monospace;
                            font-size: 16px;
                            padding: 20px;
                            color: black;
                            background: white;
                            margin: 0;
                        }
                        table {
                            width: 100%;
                            border-collapse: collapse;
                            font-weight: 600;
                        }
                        td, th {
                            padding: 8px 5px;
                            border-bottom: 1px solid #000;
                        }
                        th {
                            background-color: #f0f0f0;
                        }
                        hr {
                            border-top: 2px dashed #000;
                            margin: 15px 0;
                        }
                    </style>
                </head>
                <body>
                    ${strukContent}
                </body>
                </html>
            `);

            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
            printWindow.close();
        }
    </script>
</x-app-layout>