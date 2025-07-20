<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Linhs Llantas | Panel Administrativo</title>
    <link rel="icon" href="{{ asset('storage/pageweb/logopeque.png') }}" type="image/png">

    <!-- Tipografía -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Estilos y Scripts (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])


    <!-- Estilos Livewire -->
    @livewireStyles
</head>

<body class="bg-gray-50 text-gray-900">

    <!-- Layout Principal -->
    <div class="flex h-screen">

        <!-- Navegación lateral -->
        <aside>
            @livewire('navigation-menudos')
        </aside>

        <!-- Contenido principal -->
        <main class="flex-1 flex flex-col">

            <!-- Encabezado superior -->
            <header>
                @livewire('header')
            </header>

            <!-- Slot dinámico -->
            <section class="p-4 flex-1 overflow-y-auto">
                {{ $slot }}
            </section>

        </main>
    </div>

    <!-- Modales -->
    @stack('modals')

    <!-- Scripts Livewire -->
    @livewireScripts

    <!-- Script personalizado para gráficos -->
    @stack('scripts')
</body>

</html>
