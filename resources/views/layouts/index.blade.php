<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>
        <!-- Styles -->
        @livewireStyles
    </head>
    <body>
        <header class="shadow-md fixed top-0 w-full z-50">
            @livewire('pageweb.header')
        </header>

        <main class="pt-16">
            {{ $slot }}
        </main>

        <footer>
            @livewire('footer')
        </footer>

        @livewire('pageweb.carrito')

        @livewireScripts
    </body>
</html>
