<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-orange-800 dark:text-orange-200 leading-tight text-center">
            {{ __('Daftar Transaksi') }}
        </h2>
    </x-slot>

    <div class="w-full px-4 py-6">

        @if (session('success'))
            <div
                class="mb-6 bg-green-100 dark:bg-green-700 text-green-800 dark:text-green-100 rounded-md px-4 py-3 shadow-md border border-green-200 dark:border-green-600">
                <div class="flex items-center">
                    <svg class="h-5 w-5 mr-2 text-green-500 dark:text-green-300" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l2-2z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="font-medium">Success!</span>
                    <span class="ml-2">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <div class="mb-6">
            <form method="GET" action="{{ route('transactions.index') }}">
                <label for="tanggal_filter"
                    class="block text-sm font-semibold mb-2 text-stone-800 dark:text-amber-200">Filter Tanggal</label>
                <div class="flex rounded-md shadow-sm">
                    <input type="date" name="tanggal" id="tanggal_filter"
                        class="flex-1 block w-full rounded-l-md bg-stone-100 dark:bg-stone-700 text-stone-800 dark:text-amber-100 border border-stone-300 dark:border-stone-600 focus:ring-amber-500 focus:border-amber-500 focus:outline-none px-4 py-2"
                        value="{{ request('tanggal') }}" />
                    <button type="submit"
                        class="bg-amber-700 hover:bg-amber-800 transition-colors text-white px-6 py-2 rounded-r-md font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5 inline-block align-middle">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                        <span class="ml-1 align-middle">Cari</span>
                    </button>
                </div>
            </form>
        </div>

        @if($transactions->count())
            <div class="overflow-x-auto rounded-xl shadow-md border border-stone-200 dark:border-stone-800">
                <table class="min-w-full divide-y divide-stone-200 dark:divide-stone-700">
                    <thead class="bg-stone-50 dark:bg-stone-800">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider border-b border-stone-300 dark:border-stone-600">
                                Produk
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider border-b border-stone-300 dark:border-stone-600">
                                Total Harga
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider border-b border-stone-300 dark:border-stone-600">
                                Tanggal
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-stone-900 divide-y divide-stone-200 dark:divide-stone-700">
                        @foreach($transactions as $transaction)
                            <tr class="hover:bg-amber-100 dark:hover:bg-stone-700 transition-colors duration-200">
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm text-stone-800 dark:text-gray-300 border-b border-stone-300 dark:border-stone-600">
                                    {!! $transaction->item_names !!}
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-stone-900 dark:text-white border-b border-stone-300 dark:border-stone-600">
                                    Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm text-stone-800 dark:text-gray-300 border-b border-stone-300 dark:border-stone-600">
                                    {{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d-m-Y H:i') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex justify-center">
                {{ $transactions->appends(['tanggal' => request('tanggal')])->links('pagination::tailwind') }}
            </div>
        @else
            <div
                class="bg-amber-100 dark:bg-amber-700 text-stone-800 dark:text-amber-100 text-center p-4 rounded-md shadow-md mt-6 border border-amber-300 dark:border-amber-600">
                @if(request('tanggal'))
                    Tidak ada transaksi pada tanggal
                    <strong>{{ request('tanggal') }}</strong>.
                @else
                    Belum ada transaksi yang tercatat.
                @endif
            </div>
        @endif

    </div>
</x-app-layout>