<template x-if="esDesktop">
    <aside x-show="menuAbierto" x-transition x-cloak
        class="fixed inset-y-0 left-0 z-30 w-64 bg-[#1E2A3A] text-white shadow-lg overflow-y-auto transform transition-transform">
        <!-- Encabezado con logo -->
        <div class="p-4 border-b border-gray-700 flex justify-center items-center h-20">
            <img src="{{ asset('storage/pageweb/logonuevosinfondo.png') }}" alt="Logo Linhs Llantas"
                class="h-12 object-contain">
        </div>

        <nav class="p-4 space-y-2">
            <!-- Inicio -->

            <a wire:navigate href="{{ url('/') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-white/10 transition">
                <i class="fas fa-globe text-green-400 w-5"></i>
                <span>Pagina Web</span>
            </a>

            <a wire:navigate href="{{ route('dashboard') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-white/10 transition">
                <i class="fas fa-home text-blue-400 w-5"></i>
                <span>Inicio</span>
            </a>

            <!-- Inventario Dropdown -->
            <div>
                <button wire:click="toggleDropdown('inventario')"
                    class="flex items-center justify-between w-full px-4 py-2 rounded-lg hover:bg-white/10 transition">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-box text-teal-400 w-5"></i>
                        <span>Inventario</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform"
                        :class="{ 'rotate-180': $wire.dropdownStates['inventario'] }" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d=" M19 9l-7 7-7-7">
                        </path>
                    </svg>
                </button>

                @if ($dropdownStates['inventario'] ?? false)
                    <div class="pl-10 mt-1 space-y-1">
                        <a wire:navigate href="{{ route('stockentries.create') }}"
                            class="flex items-center gap-2 px-3 py-1 text-sm rounded hover:bg-white/10 transition">
                            <i class="fas fa-plus-circle text-teal-300 w-4"></i>
                            Nueva Entrada
                        </a>
                        <a wire:navigate href="{{ route('stockentries.index') }}"
                            class="flex items-center gap-2 px-3 py-1 text-sm rounded hover:bg-white/10 transition">
                            <i class="fas fa-list text-teal-300 w-4"></i>
                            Lista de Entradas
                        </a>
                        <a wire:navigate href="{{ route('products.index') }}"
                            class="flex items-center gap-2 px-3 py-1 text-sm rounded hover:bg-white/10 transition">
                            <i class="fas fa-box text-teal-300 w-4"></i>
                            Productos
                        </a>
                        <a wire:navigate href="{{ route('brands.index') }}"
                            class="flex items-center gap-2 px-3 py-1 text-sm rounded hover:bg-white/10 transition">
                            <i class="fas fa-tags text-teal-300 w-4"></i>
                            Marcas
                        </a>
                        <a wire:navigate href="{{ route('categories.index') }}"
                            class="flex items-center gap-2 px-3 py-1 text-sm rounded hover:bg-white/10 transition">
                            <i class="fas fa-th-list text-teal-300 w-4"></i>
                            Categorías
                        </a>
                        <a wire:navigate href="{{ route('services.index') }}"
                            class="flex items-center gap-2 px-3 py-1 text-sm rounded hover:bg-white/10 transition">
                            <i class="fas fa-concierge-bell text-teal-300 w-4"></i>
                            Servicios
                        </a>
                    </div>
                @endif
            </div>

            <!-- Ventas Dropdown -->
            <div>
                <button wire:click="toggleDropdown('ventas')"
                    class="flex items-center justify-between w-full px-4 py-2 rounded-lg hover:bg-white/10 transition">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-money-bill-wave text-orange-400 w-5"></i>
                        <span>Ventas</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': $wire.dropdownStates['ventas'] }"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                        </path>
                    </svg>
                </button>

                @if ($dropdownStates['ventas'] ?? false)
                    <div class="pl-10 mt-1 space-y-1">
                        <a wire:navigate href="{{ route('ventas-online.index') }}"
                            class="flex items-center gap-2 px-3 py-1 text-sm rounded hover:bg-white/10 transition">
                            <i class="fas fa-globe text-orange-300 w-4"></i>
                            Ventas Online
                        </a>
                        <a wire:navigate href="{{ route('sales.create') }}"
                            class="flex items-center gap-2 px-3 py-1 text-sm rounded hover:bg-white/10 transition">
                            <i class="fas fa-shopping-cart text-orange-300 w-4"></i>
                            Nueva Venta
                        </a>
                        <a wire:navigate href="{{ route('sales.index', ['isPendienteFacturacion' => false]) }}"
                            class="flex items-center gap-2 px-3 py-1 text-sm rounded hover:bg-white/10 transition">
                            <i class="fas fa-receipt text-orange-300 w-4"></i>
                            Lista de Ventas
                        </a>
                    </div>
                @endif
            </div>

            <!-- Contactos Dropdown -->
            <div>
                <button wire:click="toggleDropdown('contactos')"
                    class="flex items-center justify-between w-full px-4 py-2 rounded-lg hover:bg-white/10 transition">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-user text-green-400 w-5"></i>
                        <span>Contactos</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform"
                        :class="{ 'rotate-180': $wire.dropdownStates['contactos'] }" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                        </path>
                    </svg>
                </button>

                @if ($dropdownStates['contactos'] ?? false)
                    <div class="pl-10 mt-1 space-y-1">
                        <a wire:navigate href="{{ route('clients.index') }}"
                            class="flex items-center gap-2 px-3 py-1 text-sm rounded hover:bg-white/10 transition">
                            <i class="fas fa-users text-green-300 w-4"></i>
                            Clientes
                        </a>
                        <a wire:navigate href="{{ route('suppliers.index') }}"
                            class="flex items-center gap-2 px-3 py-1 text-sm rounded hover:bg-white/10 transition">
                            <i class="fas fa-truck text-green-300 w-4"></i>
                            Proveedores
                        </a>
                    </div>
                @endif
            </div>

            <!-- Más Dropdown -->
            <div>
                <button wire:click="toggleDropdown('more')"
                    class="flex items-center justify-between w-full px-4 py-2 rounded-lg hover:bg-white/10 transition">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-red-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 16v6m0 0h6m-6 0h-6M4 6v12" />
                        </svg>
                        <span>Más</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': $wire.dropdownStates['more'] }"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                        </path>
                    </svg>
                </button>

                @if ($dropdownStates['more'] ?? false)
                    <div class="pl-10 mt-1 space-y-1">
                        <a wire:navigate href="{{ route('register') }}"
                            class="flex items-center gap-2 px-3 py-1 text-sm rounded hover:bg-white/10 transition">
                            <i class="fas fa-user-plus text-red-300 w-4"></i>
                            Crear Nuevo Usuario
                        </a>
                    </div>
                @endif
            </div>
        </nav>
    </aside>
</template>
