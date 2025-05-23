<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-stone-800 dark:text-amber-200 leading-tight">
            {{ __('Daftar Pesanan') }}
        </h2>
    </x-slot>

    @endsection

    @section('slot')
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-[#FAF3E0] dark:bg-[#6B8E23] overflow-hidden shadow-md sm:rounded-lg">
                    <div class="p-6 text-[#5D4037] dark:text-[#FAF3E0]">
                        {{ __("You're logged in!") }}
                    </div>
                </div>
            </div>
        </div>
    @endsection