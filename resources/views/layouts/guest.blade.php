<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Sembako Mart') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Tailwind CSS & FontAwesome CDN (Pengganti Vite) -->
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    </head>
    <body class="font-sans text-gray-800 antialiased bg-gradient-to-br from-emerald-50 to-teal-100">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="mb-4 text-center">
                <a href="/" class="inline-flex items-center gap-2 text-emerald-800 font-extrabold text-2xl">
                    <i class="fa-solid fa-store text-3xl text-emerald-600"></i> Sembako Mart
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-2 px-8 py-6 bg-white shadow-xl overflow-hidden sm:rounded-2xl border border-emerald-100">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>