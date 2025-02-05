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

        <!-- Livewire Styles -->
        @livewireStyles
    </head>
    <body>
        <!-- Contenedor de la interfaz de usuario -->
        <div class="flex h-screen">
            <!-- Navegación -->
            <div class="">
                @livewire('navigation-menudos') <!-- Componente de navegación -->
            </div>

            <!-- Contenido principal -->
            <div class="flex-1 flex flex-col">
                <!-- Header -->
                <div class="">
                    @livewire('header')
                </div>

                <!-- Contenido dinámico (slot) -->
                <div class="p-4 flex-1">
                    {{ $slot }}
                </div>
            </div>
        </div>

        <!-- Modales o componentes adicionales -->
        @stack('modals')

        <!-- Livewire Scripts -->
        @livewireScripts
    </body>
</html>
