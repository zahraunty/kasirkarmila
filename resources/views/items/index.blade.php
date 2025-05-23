<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-orange-800 dark:text-orange-200 leading-tight text-center">
            {{ __('Daftar Barang') }}
        </h2>
    </x-slot>




    @if (session('success'))
        <div
            class="mb-6 bg-orange-100 dark:bg-orange-700 text-orange-800 dark:text-orange-100 rounded-xl px-6 py-4 shadow-md transition-all duration-300">
            <div class="flex items-center">

                <span>{{ session('success') }}</span>
            </div>
        </div>
    @elseif(session('error'))
        <div
            class="mb-6 bg-red-100 dark:bg-red-800 text-red-800 dark:text-red-100 rounded-xl px-6 py-4 shadow-md transition-all duration-300">
            <div class="flex items-center">

                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <div class="mb-8 flex justify-end">
        <a href="{{ route('items.create') }}"
            class="bg-orange-600 hover:bg-orange-700 text-white font-semibold px-8 py-3 rounded-xl shadow-lg transition duration-300 ease-in-out transform hover:scale-105 flex items-center gap-2">

            {{ __('Tambah Barang') }}
        </a>
    </div>

    <div class="overflow-x-auto rounded-xl shadow-md border border-stone-200 dark:border-stone-800">
        <table class="min-w-full divide-y divide-stone-200 dark:divide-stone-700">
            <thead class="bg-stone-50 dark:bg-stone-800">
                <tr>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-stone-500 dark:text-stone-400 uppercase tracking-wider">
                        Nama Barang
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-stone-500 dark:text-stone-400 uppercase tracking-wider">
                        Harga Barang
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-stone-500 dark:text-stone-400 uppercase tracking-wider">
                        Diskon
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-stone-500 dark:text-stone-400 uppercase tracking-wider">
                        Harga Setelah Diskon
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-stone-500 dark:text-stone-400 uppercase tracking-wider">
                        Stok Barang
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-stone-500 dark:text-stone-400 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-stone-900 divide-y divide-stone-200 dark:divide-stone-700">
                @foreach($items as $item)
                    <tr class="hover:bg-amber-50 dark:hover:bg-stone-800/50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-stone-900 dark:text-white">
                            {{ $item->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-stone-900 dark:text-white">
                            Rp {{ number_format($item->price, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-stone-900 dark:text-white">
                            {{ $item->diskon }}%
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-stone-900 dark:text-white">
                            Rp {{ number_format($item->final_price, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-stone-900 dark:text-white">
                            {{ $item->stock }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap space-x-3">
                            <a href="{{ route('items.edit', $item) }}"
                                class="text-blue-500 hover:text-blue-700 dark:text-blue-300 dark:hover:text-blue-200 hover:underline transition-colors duration-200"
                                aria-label="Edit">
                                {{ __('EDIT') }}
                            </a>
                            <form action="{{ route('items.destroy', $item) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-600 hover:underline transition-colors duration-200"
                                    onclick="return confirm('Yakin ingin menghapus barang ini?')" aria-label="Delete">
                                    {{ __('HAPUS') }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>
    </div>
    </div>
    </div>
</x-app-layout>