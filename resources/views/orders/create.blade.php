<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-orange-800 dark:text-orange-200 leading-tight text-center">
            {{ __('Tambah Pesanan') }}
        </h2>
    </x-slot>

    <div class="flex items-center justify-center py-12">
        <div
            class="bg-black bg-opacity-50 shadow-lg rounded-xl p-8 transition-transform transform hover:scale-105 w-full max-w-3xl">
            <form action="{{ route('orders.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label for="item_id" class="px-6 py-4 whitespace-nowrap text-sm text-stone-900 dark:text-white">
                            Pilih Barang
                        </label>
                        <div class="relative">
                            <select name="item_id" id="item_id"
                                class="w-full px-4 py-2 border border-amber-300 dark:border-amber-600 rounded-md shadow-sm bg-white dark:bg-stone-700 text-stone-800 dark:text-amber-100 focus:ring-2 focus:ring-amber-500 focus:outline-none appearance-none transition-colors duration-300 text-sm"
                                required>
                                <option value="">-- Pilih Barang --</option>
                                @foreach ($items as $item)
                                    <option value="{{ $item->id }}" data-price="{{ $item->final_price }}"
                                        data-name="{{ $item->name }}" data-stock="{{ $item->stock }}">
                                        {{ $item->name }} -
                                        Rp{{ number_format($item->final_price, 0, ',', '.') }}
                                        (Stok: {{ $item->stock }})
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">

                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="quantity"
                            class="px-6 py-4 whitespace-nowrap text-sm text-stone-900 dark:text-white">
                            Jumlah
                        </label>
                        <div class="relative">
                            <input type="number" name="quantity" id="quantity" min="1"
                                class="w-full px-4 py-2 border border-amber-300 dark:border-amber-600 rounded-md shadow-sm bg-white dark:bg-stone-700 text-stone-800 dark:text-amber-100 focus:ring-2 focus:ring-amber-500 focus:outline-none transition-colors duration-300 text-sm"
                                required placeholder="Masukkan jumlah pesanan" aria-label="Quantity"
                                inputmode="numeric">
                        </div>
                        <small id="stock-info" class="text-sm text-stone-600 dark:text-stone-300">Sisa stok:
                            -</small>
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="total_price" class="px-6 py-4 whitespace-nowrap text-sm text-stone-900 dark:text-white">
                        Total Harga
                    </label>
                    <div class="relative">
                        <input type="text" id="total_price"
                            class="w-full px-4 py-2 border border-amber-300 dark:border-amber-600 rounded-md shadow-sm bg-white dark:bg-stone-700 text-stone-800 dark:text-amber-100 focus:outline-none cursor-not-allowed text-sm"
                            readonly placeholder="Total harga akan dihitung otomatis" value="Rp0">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">

                        </div>
                    </div>
                </div>

                <input type="hidden" name="harga" id="harga">
                <input type="hidden" name="nama_barang" id="nama_barang">

                @if ($errors->has('quantity'))
                    <div class="text-red-500 text-sm mt-2">
                        {{ $errors->first('quantity') }}
                    </div>
                @endif

                <div class="text-center pt-6">
                    <button type="submit" id="submit-btn"
                        class="bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white font-semibold px-6 py-2 rounded-full shadow-md transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:ring-offset-2 w-full text-md"
                        disabled>
                        Tambah Pesanan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const itemSelect = document.getElementById('item_id');
            const quantityInput = document.getElementById('quantity');
            const totalPriceInput = document.getElementById('total_price');
            const hargaInput = document.getElementById('harga');
            const namaBarangInput = document.getElementById('nama_barang');
            const stockInfo = document.getElementById('stock-info');
            const submitBtn = document.getElementById('submit-btn');

            function updateTotal() {
                const selected = itemSelect.options[itemSelect.selectedIndex];
                const price = parseFloat(selected.getAttribute('data-price')) || 0;
                const name = selected.getAttribute('data-name') || '';
                const stock = parseInt(selected.getAttribute('data-stock')) || 0;
                const quantity = parseInt(quantityInput.value) || 0;
                const total = price * quantity;

                totalPriceInput.value = total.toLocaleString('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                });
                hargaInput.value = price;
                namaBarangInput.value = name;
                stockInfo.textContent = 'Sisa stok: ' + stock;

                if (quantity > stock || quantity < 1 || !itemSelect.value) {
                    submitBtn.disabled = true;
                    totalPriceInput.classList.add('border-red-500');
                    totalPriceInput.classList.remove('border-amber-300',
                        'dark:border-amber-600');
                } else {
                    submitBtn.disabled = false;
                    totalPriceInput.classList.remove('border-red-500');
                    totalPriceInput.classList.add('border-amber-300',
                        'dark:border-amber-600');
                }
            }

            itemSelect.addEventListener('change', updateTotal);
            quantityInput.addEventListener('input', updateTotal);
            updateTotal();
        });
    </script>
</x-app-layout>