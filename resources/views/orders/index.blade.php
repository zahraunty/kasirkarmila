<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-orange-800 dark:text-orange-200 leading-tight text-center">
            {{ __('Daftar Pemesanan') }}
        </h2>
    </x-slot>


    @if (session('success'))
        <div
            class="mb-6 bg-orange-100 dark:bg-orange-700 text-orange-800 dark:text-orange-100 rounded-xl px-6 py-4 shadow-md border border-orange-200 dark:border-orange-600">
            <div class="flex items-center gap-2">

                <span>{{ session('success') }}</span>
            </div>
        </div>
    @elseif(session('error'))
        <div
            class="mb-6 bg-red-100 dark:bg-red-800 text-red-800 dark:text-red-100 rounded-xl px-6 py-4 shadow-md border border-red-200 dark:border-red-700">
            <div class="flex items-center gap-2">

                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <div class="mb-8 flex justify-end">
        <a href="{{ route('orders.create') }}"
            class="bg-orange-600 hover:bg-orange-700 text-white font-semibold px-8 py-3 rounded-xl shadow-lg transition duration-300 ease-in-out transform hover:scale-105 flex items-center gap-2">

            {{ __('Tambah Pemesanan') }}
        </a>
    </div>

    <form action="{{ route('orders.checkout') }}" method="POST" id="checkout-form">
        @csrf
        <div class="overflow-x-auto rounded-xl shadow-md border border-stone-200 dark:border-stone-800">
            <table class="min-w-full divide-y divide-stone-200 dark:divide-stone-700">
                <thead class="bg-stone-50 dark:bg-stone-800">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-stone-500 dark:text-stone-400 uppercase tracking-wider">
                            Pilih</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-stone-500 dark:text-stone-400 uppercase tracking-wider">
                            Nama Barang</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-stone-500 dark:text-stone-400 uppercase tracking-wider">
                            Jumlah</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-stone-500 dark:text-stone-400 uppercase tracking-wider">
                            Harga Asli</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-stone-500 dark:text-stone-400 uppercase tracking-wider">
                            Harga Setelah Diskon</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-stone-500 dark:text-stone-400 uppercase tracking-wider">
                            Diskon</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-stone-500 dark:text-stone-400 uppercase tracking-wider">
                            Total Harga</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-stone-500 dark:text-stone-400 uppercase tracking-wider">
                            Tanggal</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-stone-900 divide-y divide-stone-200 dark:divide-stone-700">
                    @foreach($orders as $order)
                        <tr
                            class="hover:bg-stone-100 dark:hover:bg-stone-800 transition-colors duration-200 data-order-id-{{ $order->id }}">
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <input type="checkbox" name="selected_orders[]" value="{{ $order->id }}"
                                    class="order-checkbox rounded-md border-stone-300 text-orange-600 shadow-sm focus:ring-orange-500 dark:bg-stone-700 h-5 w-5"
                                    data-name="{{ $order->item->name }}" data-quantity="{{ $order->quantity }}"
                                    data-price="{{ $order->item->price }}" data-final_price="{{ $order->final_price }}"
                                    data-created_at="{{ $order->created_at }}"
                                    data-original_price="{{ $order->item->price * $order->quantity }}">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-stone-900 dark:text-white">
                                {{ $order->item->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-stone-900 dark:text-stone-300">
                                {{ $order->quantity }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-stone-900 dark:text-stone-300">
                                Rp{{ number_format($order->item->price * $order->quantity, 0, ',', '.') }}</td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-orange-600 dark:text-orange-400 font-medium">
                                Rp{{ number_format($order->final_price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600 dark:text-red-400">
                                Rp{{ number_format(($order->item->price * $order->quantity) - $order->final_price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-stone-900 dark:text-white">
                                Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-stone-500 dark:text-stone-400">
                                {{ $order->created_at->format('d-m-Y') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div id="checkout-box"
            class="mt-8 p-6 bg-white dark:bg-stone-900 rounded-xl shadow-lg border border-stone-200 dark:border-stone-700 hidden">
            <h3 class="font-semibold text-2xl text-stone-900 dark:text-orange-100 mb-6">Informasi Pemesanan</h3>
            <div id="checkout-details" class="space-y-4 mb-6"></div>
            <div class="space-y-2 font-semibold text-stone-900 dark:text-stone-200">
                <div class="flex justify-between">
                    <span>Total asli:</span><span id="total-asli-display" class="text-right text-lg">Rp0</span>
                </div>
                <div class="flex justify-between">
                    <span>Diskon Yang Didapatkan:</span><span id="total-diskon-display"
                        class="text-right text-lg text-red-500">Rp0</span>
                </div>
                <div class="flex justify-between">
                    <span>Total Yang Dibayar:</span><span id="total-amount-display"
                        class="text-right text-lg text-orange-600 dark:text-orange-400">Rp0</span>
                </div>
            </div>
            <div class="mt-8 flex justify-end">
                <button type="submit"
                    class="bg-orange-600 hover:bg-orange-700 text-white font-semibold py-3 px-8 rounded-xl shadow-xl transition duration-300 ease-in-out transform hover:scale-105 flex items-center gap-3">

                    HASIL
                </button>
            </div>
        </div>
    </form>

    <div class="mt-8">
        {{ $orders->links() }}
    </div>

    <script>
        const checkboxes = document.querySelectorAll('.order-checkbox');
        const checkoutBox = document.getElementById('checkout-box');
        const checkoutDetails = document.getElementById('checkout-details');
        const totalAsliDisplay = document.getElementById('total-asli-display');
        const totalAmountDisplay = document.getElementById('total-amount-display');
        const totalDiskonDisplay = document.getElementById('total-diskon-display');

        function updateCheckoutDetails() {
            let detailsHTML = '';
            let totalAsli = 0;
            let totalAmount = 0;
            let totalDiskon = 0;
            let hasChecked = false;

            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    hasChecked = true;
                    const name = checkbox.dataset.name;
                    const quantity = parseInt(checkbox.dataset.quantity);
                    const originalPrice = parseFloat(checkbox.dataset.original_price);
                    const finalPrice = parseFloat(checkbox.dataset.final_price);
                    const diskon = originalPrice - finalPrice;

                    totalAsli += originalPrice;
                    totalAmount += finalPrice;
                    totalDiskon += diskon;

                    detailsHTML += `
                        <div class="py-3 px-4 rounded-lg border dark:border-stone-600 bg-stone-50 dark:bg-stone-700">
                            <h5 class="font-semibold text-lg text-stone-900 dark:text-orange-100 mb-2">${name}</h5>
                            <div class="grid grid-cols-2 gap-y-2 gap-x-4 text-stone-700 dark:text-stone-300">
                                <div><span class="font-medium">Jumlah:</span> <span class="text-sm">${quantity}</span></div>
                                <div><span class="font-medium">Harga Asli:</span> <span class="text-sm">Rp${originalPrice.toLocaleString('id-ID')}</span></div>
                                <div><span class="font-medium">Harga Setelah Diskon:</span> <span class="text-sm text-orange-500">Rp${finalPrice.toLocaleString('id-ID')}</span></div>
                                <div><span class="font-medium">Diskon:</span> <span class="text-sm text-red-500">Rp${diskon.toLocaleString('id-ID')}</span></div>
                                <div><span class="font-medium">Total:</span> <span class="text-sm font-semibold text-stone-900 dark:text-white">Rp${finalPrice.toLocaleString('id-ID')}</span></div>
                            </div>
                        </div>
                    `;
                }
            });

            checkoutDetails.innerHTML = detailsHTML;
            totalAsliDisplay.textContent = 'Rp' + totalAsli.toLocaleString('id-ID');
            totalDiskonDisplay.textContent = 'Rp' + totalDiskon.toLocaleString('id-ID');
            totalAmountDisplay.textContent = 'Rp' + totalAmount.toLocaleString('id-ID');
            checkoutBox.classList.toggle('hidden', !hasChecked);
        }

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateCheckoutDetails);
        });


        updateCheckoutDetails();
    </script>
</x-app-layout>