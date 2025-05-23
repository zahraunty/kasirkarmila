<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .dark .dark\:bg-gray-900 {
            background-color: #1a202c;

        }

        .dark .dark\:text-gray-100 {
            color: #f7fafc;

        }
    </style>
</head>

<body class="font-sans text-green-900 antialiased bg-green-100">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div>
            <a href="/">

                <x-application-logo class="w-20 h-20 fill-current text-green-500" />
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden rounded-lg">
            {{ $slot }}
        </div>
    </div>
</body>

</html>