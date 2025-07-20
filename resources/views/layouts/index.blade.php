<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Título de la pestaña -->
    <title>Linhs Llantas | Tu tienda de confianza</title>

    <!-- Favicon (ícono de la pestaña) -->
    <link rel="icon" href="{{ asset('storage/pageweb/logopeque.png') }}" type="image/png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Estilos de Livewire y Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <!-- Ocultar elementos con x-cloak hasta que Alpine.js esté listo -->
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body>
    <!-- Encabezado -->
    <header class="shadow-md fixed top-0 w-full z-50">
        @livewire('pageweb.header')
    </header>

    <!-- Contenido principal -->
    <main class="pt-16">
        {{ $slot }}
    </main>

    <!-- Pie de página -->
    <footer>
        @livewire('footer')
    </footer>

    <!-- Componente del carrito flotante -->
    @livewire('pageweb.carrito')

    @livewireScripts

    <!-- Ícono flotante de WhatsApp -->
    <a href="https://wa.me/51983316063?text=Hola%2C%20estoy%20interesado%20en%20sus%20productos"
        class="fixed bottom-6 right-6 z-50" target="_blank" rel="noopener noreferrer">
        <div class="bg-green-500 p-3 rounded-full shadow-lg hover:scale-110 transition-transform duration-300">
            <img src="/storage/pageweb/WhatsApp.svg.webp" alt="WhatsApp" class="w-8 h-8">
        </div>
    </a>
</body>

</html>
