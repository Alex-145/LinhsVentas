<template x-if="esMovil">
    <header class="fixed top-0 left-0 right-0 z-30 bg-white shadow h-16 flex items-center px-4 md:px-6">
        <!-- Botón menú móvil -->
        <button @click="mobileSidebarOpen = true" class="md:hidden mr-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <!-- Título dinámico -->
        <h1 class="text-lg font-semibold text-gray-800">
            @if (request()->routeIs('dashboard'))
                Dashboard
            @elseif (request()->routeIs('clients.index'))
                Clientes
            @elseif (request()->routeIs('products.index'))
                Productos
            @elseif (request()->routeIs('sales.create'))
                Nueva Venta
            @elseif (request()->routeIs('sales.index'))
                Ventas
            @elseif (request()->routeIs('brands.index'))
                Marcas
            @elseif (request()->routeIs('categories.index'))
                Categorías
            @elseif (request()->routeIs('suppliers.index'))
                Proveedores
            @elseif (request()->routeIs('stockentries.create'))
                Nueva Entrada
            @else
                Panel
            @endif
        </h1>

        <!-- Espaciador -->
        <div class="flex-1"></div>

        <!-- Acciones rápidas (versión móvil simplificada) -->
        <div class="flex items-center space-x-2">
            <!-- Botón de predicciones -->
            <a href="{{ route('predicciones') }}" class="p-2 text-blue-600 hover:bg-gray-100 rounded-full">
                <i class="fas fa-robot"></i>
            </a>

            <!-- Notificaciones -->
            <div x-data="{ notificationOpen: false }" wire:poll.5s="checkPendingSales">
                <button @click="notificationOpen = !notificationOpen"
                    class="p-2 rounded-full hover:bg-gray-100 relative"
                    :class="{ 'bg-red-100': @js($hasNotifications) }">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor"
                        :class="{ 'text-red-600': @js($hasNotifications), 'text-gray-600': !@js($hasNotifications) }">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    @if ($hasNotifications)
                        <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full animate-ping"></span>
                    @endif
                </button>

                <!-- Modal de notificación móvil -->
                <div x-show="notificationOpen" @click.away="notificationOpen = false"
                    class="fixed inset-0 z-50 bg-white p-4 overflow-y-auto" style="margin-top: 4rem;">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Notificaciones</h3>
                        <button @click="notificationOpen = false" class="text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    @if ($hasNotifications)
                        {{-- Notificación de facturas pendientes --}}
                        @if ($hasPending)
                            <div class="mt-2 cursor-pointer hover:bg-gray-100 p-4 rounded-lg"
                                wire:click="navegar('sales.index')" @click="notificationOpen = false">
                                <span class="text-sm text-gray-700">Tienes facturas pendientes.</span>
                            </div>
                        @endif

                        {{-- Notificación de productos con bajo stock --}}
                        @if ($lowStockProducts->isNotEmpty())
                            <div class="mt-4 cursor-pointer hover:bg-gray-100 p-4 rounded-lg"
                                onclick="window.location.href='{{ route('lowstock.index') }}'; notificationOpen = false">
                                <h4 class="text-sm font-semibold text-gray-700">Productos con bajo stock:</h4>
                                <ul class="mt-2 space-y-1">
                                    @foreach ($lowStockProducts as $product)
                                        <li class="text-sm text-gray-600">
                                            {{ $product->name }} (Stock: {{ $product->stock }})
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Notificación de pagos por verificar --}}
                        @if ($hasVerificacionPendiente)
                            <div class="mt-2 cursor-pointer hover:bg-gray-100 p-4 rounded-lg"
                                onclick="window.location.href='{{ route('ventas-online.index') }}'; notificationOpen = false">
                                <span class="text-sm text-gray-700">Tienes pagos por verificar.</span>
                            </div>
                        @endif
                    @else
                        {{-- No hay notificaciones --}}
                        <div class="mt-4">
                            <span class="text-sm text-gray-500">No tienes notificaciones.</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </header>
</template>
