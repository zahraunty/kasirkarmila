<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ config('app.name', 'Laravel') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .fade-in {
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }

        .slide-up {
            transform: translateY(20px);
            transition: transform 1s ease-out;
        }

        .fade-in.active,
        .slide-up.active {
            opacity: 1;
            transform: translateY(0);
        }

        .nav-link {
            @apply inline-block bg-amber-700 hover:bg-amber-800 text-amber-100 font-semibold px-5 py-2 rounded-lg shadow-md transition transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-1;
        }

        .nav-link:hover {
            animation: pulse 0.5s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }
    </style>
</head>

<body
    class="bg-gradient-to-r from-white to-amber-100 dark:bg-gradient-to-r dark:from-gray-900 dark:to-amber-900 text-amber-900 dark:text-amber-100 min-h-screen flex flex-col">
    <nav class="bg-amber-300 dark:bg-amber-800 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <span class="font-bold text-lg text-amber-900 dark:text-amber-100">Task_
                        Kasir</span>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('items.index') }}" class="nav-link">Produk</a>
                    <a href="{{ route('orders.index') }}" class="nav-link">Pesanan</a>
                    <a href="{{ route('transactions.index') }}" class="nav-link">Transaksi</a>
                </div>
            </div>
        </div>
    </nav>

    <header class="bg-amber-200 dark:bg-amber-700 shadow-md slide-up">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-amber-900 dark:text-amber-100 leading-tight">
                {{ $header }}
            </h2>
        </div>
    </header>

    <main class="flex-1 max-w-7xl mx-auto px-4 py-10 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 text-amber-900 dark:text-amber-100 fade-in">
            {{ $slot }}
        </div>
    </main>

    <script>
        window.addEventListener('load', () => {
            const fadeInElements = document.querySelectorAll('.fade-in');
            const slideUpElements = document.querySelectorAll('.slide-up');

            fadeInElements.forEach(element => {
                element.classList.add('active');
            });

            slideUpElements.forEach(element => {
                element.classList.add('active');
            });
        });
    </script>
</body>

</html>