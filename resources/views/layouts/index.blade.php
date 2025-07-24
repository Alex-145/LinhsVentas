<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Título de la pestaña -->
    <title>Linhs Llantas | Llantas y Servicios Automotrices en Challhuahuacho, Apurímac</title>

    <meta name="description"
        content="Linhs Llantas - Venta de llantas para autos, camionetas y vehículos 4x4 en Challhuahuacho, Apurímac. Servicios de instalación, alineamiento, balanceo, cambio de aceite y revisión mecánica. Atención por Lino Huamanvilca. Trabajamos con marcas como Triangle, Maxxis, Bridgestone, Dunlop, Falken, GTRadial, Comforser, Onyx y Farroad.">
    <meta name="keywords"
        content="llantas Challhuahuacho, llantas Apurímac, Lino Huamanvilca, Linhs Llantas, venta de llantas mina Las Bambas, aceites para autos, baterías, cámaras, alineamiento, balanceo, cambio de aceite, revisión mecánica, Triangle, Maxxis, Bridgestone, Dunlop, Falken, GTRadial, Comforser, Onyx, Farroad, camionetas, 4x4, autos, Saico, Cotabambas, Espinar">
    <meta name="author" content="Linhs Llantas">
    <meta name="robots" content="index, follow">

    <!-- Favicon (ícono de la pestaña) -->
    <link rel="icon" href="{{ asset('storage/pageweb/logopeque.png') }}" type="image/png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Estilos compilados -->
    <link rel="stylesheet" href="{{ asset('build/assets/app-czh60oOY.css') }}">
    <script src="{{ asset('build/assets/app-TCBhWwx8.js') }}" defer></script>

    <!-- Estilos de Livewire -->
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

    @stack('modals')
    @livewireScripts
    @stack('scripts')

    <!-- Ícono flotante de WhatsApp -->
    <a href="https://wa.me/51983316063?text=Hola%2C%20estoy%20interesado%20en%20sus%20productos"
        class="fixed bottom-6 right-6 z-50" target="_blank" rel="noopener noreferrer">
        <div class="bg-green-500 p-3 rounded-full shadow-lg hover:scale-110 transition-transform duration-300">
            <img src="/storage/pageweb/WhatsApp.svg.webp" alt="WhatsApp" class="w-8 h-8">
        </div>
    </a>
</body>

</html>
