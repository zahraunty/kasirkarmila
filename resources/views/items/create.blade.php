<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-orange-800 dark:text-orange-200 leading-tight text-center">
            {{ __('Tambah Barang') }}
        </h2>
    </x-slot>

    <div class="flex items-center justify-center py-12">
        <div
            class="bg-black bg-opacity-50 shadow-lg rounded-xl p-8 transition-transform transform hover:scale-105 w-full max-w-3xl">
            <form action="{{ route('items.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label for="name" class="px-6 py-4 whitespace-nowrap text-sm text-stone-900 dark:text-white">
                            Nama Barang</label>
                        <input type="text" name="name" id="name"
                            class="w-full px-4 py-2 border border-amber-300 dark:border-amber-600 rounded-md shadow-sm bg-white dark:bg-stone-700 text-stone-800 dark:text-amber-100 focus:ring-2 focus:ring-amber-500 focus:outline-none transition-colors duration-300 text-sm"
                            placeholder="Contoh: Minyak Goreng 1L" required>
                    </div>
                    <div class="space-y-2">
                        <label for="price"
                            class="px-6 py-4 whitespace-nowrap text-sm text-stone-900 dark:text-white">Harga
                            Barang</label>
                        <input type="number" name="price" id="price"
                            class="w-full px-4 py-2 border border-amber-300 dark:border-amber-600 rounded-md shadow-sm bg-white dark:bg-stone-700 text-stone-800 dark:text-amber-100 focus:ring-2 focus:ring-amber-500 focus:outline-none transition-colors duration-300 text-sm"
                            placeholder="Contoh: 15000" required>
                    </div>
                    <div class="space-y-2">
                        <label for="stock"
                            class="px-6 py-4 whitespace-nowrap text-sm text-stone-900 dark:text-white">Stok
                            Barang</label>
                        <input type="number" name="stock" id="stock"
                            class="w-full px-4 py-2 border border-amber-300 dark:border-amber-600 rounded-md shadow-sm bg-white dark:bg-stone-700 text-stone-800 dark:text-amber-100 focus:ring-2 focus:ring-amber-500 focus:outline-none transition-colors duration-300 text-sm"
                            placeholder="Contoh: 25" required>
                    </div>
                    <div class="space-y-2">
                        <label for="diskon"
                            class="px-6 py-4 whitespace-nowrap text-sm text-stone-900 dark:text-white">Diskon
                        </label>
                        <input type="number" name="diskon" id="diskon" value="0"
                            class="w-full px-4 py-2 border border-amber-300 dark:border-amber-600 rounded-md shadow-sm bg-white dark:bg-stone-700 text-stone-800 dark:text-amber-100 focus:ring-2 focus:ring-amber-500 focus:outline-none transition-colors duration-300 text-sm"
                            placeholder="Contoh: 10">
                    </div>
                </div>
                <div class="pt-6">
                    <button type="submit"
                        class="bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white font-semibold px-6 py-2 rounded-full shadow-md transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:ring-offset-2 w-full text-md">
                        Tambah Barang
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>