<template x-if="esDesktop">
    <header class="fixed top-0 z-30 bg-white border-b shadow h-16 flex items-center px-6 transition-all duration-300"
        :class="menuAbierto ? 'left-64 w-[calc(100%-16rem)]' : 'left-0 w-full'" x-cloak>

        <!-- Botón menú -->
        <button @click="menuAbierto = !menuAbierto"
            class="text-gray-600 hover:text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-300"
            title="Mostrar/Ocultar menú">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <!-- Título dinámico -->
        <h1 class="ml-4 text-xl font-semibold text-gray-800">
            @if (request()->routeIs('dashboard'))
                Dashboard
            @elseif (request()->routeIs('clients.index'))
                Clientes
            @elseif (request()->routeIs('products.index'))
                Productos
            @elseif (request()->routeIs('sales.create'))
                Nueva Venta
            @elseif (request()->routeIs('sales.index'))
                Lista de ventas
            @elseif (request()->routeIs('brands.index'))
                Marcas
            @elseif (request()->routeIs('categories.index'))
                Categorías
            @elseif (request()->routeIs('suppliers.index'))
                Proveedores
            @elseif (request()->routeIs('stockentries.create'))
                Nueva Entrada
            @else
                Linhs Llantas - Panel de Control
            @endif
        </h1>

        <!-- Espaciador -->
        <div class="flex-1"></div>

        <!-- Acciones rápidas -->
        <div class="flex items-center space-x-4">
            <!-- Botón de predicciones -->
            <a href="{{ route('predicciones') }}" wire:navigate
                class="p-2 text-blue-600 hover:bg-gray-100 rounded-full">
                <i class="fas fa-robot"></i>
            </a>




            <!-- Notificaciones -->
            <div x-data="{ notificationOpen: false }">
                <button @click="notificationOpen = !notificationOpen; $dispatch('close-user-modal')"
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

                <!-- Modal de notificación -->
                <div x-show="notificationOpen" @click.away="notificationOpen = false"
                    class="absolute z-50 mt-2 bg-white border border-gray-300 rounded-lg shadow-lg p-4 right-0 w-72">
                    <h3 class="text-lg font-semibold text-gray-800">Notificaciones</h3>

                    @if ($hasNotifications)
                        {{-- Notificación de facturas pendientes --}}
                        @if ($hasPending)
                            <div class="mt-2 cursor-pointer hover:bg-gray-100 p-4 rounded-lg"
                                wire:click="navegar('sales.index')">
                                <span class="text-sm text-gray-700">Tienes facturas pendientes.</span>
                            </div>
                        @endif

                        {{-- Notificación de productos con bajo stock --}}
                        @if ($lowStockProducts->isNotEmpty())
                            <div class="mt-4 cursor-pointer hover:bg-gray-100 p-4 rounded-lg"
                                onclick="window.location.href='{{ route('lowstock.index') }}'">
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
                                onclick="window.location.href='{{ route('ventas-online.index') }}'">
                                <span class="text-sm text-gray-700">Tienes pagos por verificar.</span>
                            </div>
                        @endif
                    @else
                        {{-- No hay notificaciones --}}
                        <div class="mt-4">
                            <span class="text-sm text-gray-500">No tienes notificaciones.</span>
                        </div>
                    @endif

                    <button @click="notificationOpen = false"
                        class="mt-4 text-sm text-gray-600 hover:text-gray-800">Cerrar</button>
                </div>
            </div>

            <!-- Perfil de usuario -->
            <div x-data="{ userModalOpen: false }" class="relative">
                <div class="flex items-center gap-3 cursor-pointer"
                    @click="userModalOpen = !userModalOpen; $dispatch('close-notification-modal')">
                    <div class="text-right">
                        <div class="text-sm font-medium">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-gray-500">Administrador</div>
                    </div>
                    <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}"
                        class="w-10 h-10 rounded-full">
                </div>

                <!-- Modal de usuario -->
                <div x-show="userModalOpen" @click.away="userModalOpen = false"
                    class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg">
                    <div class="block px-4 py-2 text-xs text-gray-400">{{ __('Manage Account') }}</div>
                    <a href="{{ route('profile.show') }}"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('Profile') }}</a>

                    <div class="border-t border-gray-200"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('Log Out') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </header>
</template>
