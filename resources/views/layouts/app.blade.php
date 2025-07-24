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

    <!-- Assets compilados -->
    <link rel="stylesheet" href="{{ asset('build/assets/app-czh60oOY.css') }}">
    <script src="{{ asset('build/assets/app-TCBhWwx8.js') }}" defer></script>

    @livewireStyles
</head>

<body class="font-sans antialiased bg-gray-100" x-data="{
    menuAbierto: window.innerWidth > 768,
    mobileSidebarOpen: false,
    esMovil: window.innerWidth <= 768,
    esDesktop: window.innerWidth > 768
}"
    @resize.window="
        menuAbierto = window.innerWidth > 768;
        esMovil = window.innerWidth <= 768;
        esDesktop = window.innerWidth > 768;
    ">

    <x-banner />

    @livewire('navigation-menudos')

    @livewire('header')

    <div :class="menuAbierto && esDesktop ? 'md:ml-64 pt-20' : 'pt-20'" class="transition-all duration-300">
        <main>
            @if (isset($header))
                <div class="bg-white shadow mb-4">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </div>
            @endif

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    {{ $slot }}
                </div>
            </div>
        </main>
    </div>

    @stack('modals')
    @livewireScripts
    @stack('scripts')
</body>

</html>
