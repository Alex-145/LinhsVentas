<div
    class="{{ $menuAbierto ? 'w-60' : 'w-16' }} bg-[#1E2A3A] min-h-screen text-white p-4 transition-all duration-300 fixed top-0 left-0 overflow-y-auto z-5">
    <div class="space-y-2">
        <p class="text-xs font-semibold text-yellow-300 mb-3 uppercase">Menu</p>

        <!-- Dashboard -->
        <a wire:click.prevent="navegar('dashboard')"
            class="flex items-center gap-4 px-2 py-2 rounded-lg hover:bg-indigo-700 transition duration-200 {{ request()->routeIs('dashboard') ? 'bg-indigo-700' : '' }}">
            <svg class="w-5 h-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>
            @if ($menuAbierto)
                <span class="text-yellow-300">Dashboard</span>
            @endif
        </a>

        <!-- Inventario Dropdown -->
        <div class="relative">
            <button wire:click="toggleDropdown('inventario')"
                class="flex items-center gap-4 px-2 py-2 rounded-lg hover:bg-blue-700 transition duration-200 w-full text-left">
                <svg class="w-5 h-5 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4V3m6 2V3m-6 4h6m-6 4h6m-6 4h6M6 4v12a2 2 0 00-2 2v4a2 2 0 002 2h12a2 2 0 002-2v-4a2 2 0 00-2-2V4a2 2 0 00-2-2H8a2 2 0 00-2 2v12m-4 0h4M6 6h4m4 0h4M6 8h4m4 0h4" />
                </svg>
                @if ($menuAbierto)
                    <span class="text-green-300">Inventario</span>
                    <svg class="w-4 h-4 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                @endif
            </button>
            @if ($menuAbierto && $dropdowns['inventario'])
                <div class="mt-2 space-y-2 pl-6">

                    <a wire:click.prevent="navegar('stockentries.create')"
                        class="block px-2 py-1 text-sm text-orange-300 hover:bg-teal-600 rounded">NuevaEntradas</a>
                    <a wire:click.prevent="navegar('products.index')"
                        class="block px-2 py-1 text-sm text-green-300 hover:bg-blue-600 rounded">Productos</a>
                    <a wire:click.prevent="navegar('brands.index')"
                        class="block px-2 py-1 text-sm text-green-300 hover:bg-blue-600 rounded">Marcas</a>
                    <a wire:click.prevent="navegar('categories.index')"
                        class="block px-2 py-1 text-sm text-green-300 hover:bg-blue-600 rounded">Categorías</a>
                    <a wire:click.prevent="navegar('services.index')"
                        class="block px-2 py-1 text-sm text-green-300 hover:bg-blue-600 rounded">Servicios</a>

                </div>
            @endif
        </div>

        <!-- Ventas Dropdown -->
        <div class="relative">
            <button wire:click="toggleDropdown('ventas')"
                class="flex items-center gap-4 px-2 py-2 rounded-lg hover:bg-teal-700 transition duration-200 w-full text-left">
                <svg class="w-5 h-5 text-orange-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                @if ($menuAbierto)
                    <span class="text-orange-300">Ventas</span>
                    <svg class="w-4 h-4 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                @endif
            </button>
            @if ($menuAbierto && $dropdowns['ventas'])
                <div class="mt-2 space-y-2 pl-6">
                    <a wire:click.prevent="navegar('sales.create')"
                        class="block px-2 py-1 text-sm text-orange-300 hover:bg-teal-600 rounded">Nueva Venta</a>
                    <a wire:click.prevent="navegar('sales.index')"
                        class="block px-2 py-1 text-sm text-orange-300 hover:bg-teal-600 rounded">Lista de Ventas</a>
                </div>
            @endif
        </div>

        <!-- Contactos Dropdown -->
        <div class="relative">
            <button wire:click="toggleDropdown('contactos')"
                class="flex items-center gap-4 px-2 py-2 rounded-lg hover:bg-blue-700 transition duration-200 w-full text-left">
                <svg class="w-5 h-5 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4V3m6 2V3m-6 4h6m-6 4h6m-6 4h6M6 4v12a2 2 0 00-2 2v4a2 2 0 002 2h12a2 2 0 002-2v-4a2 2 0 00-2-2V4a2 2 0 00-2-2H8a2 2 0 00-2 2v12m-4 0h4M6 6h4m4 0h4M6 8h4m4 0h4" />
                </svg>
                @if ($menuAbierto)
                    <span class="text-green-300">Contactos</span>
                    <svg class="w-4 h-4 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                @endif
            </button>
            @if ($menuAbierto && $dropdowns['contactos'])
                <div class="mt-2 space-y-2 pl-6">
                    <a wire:click.prevent="navegar('clients.index')"
                        class="block px-2 py-1 text-sm text-green-300 hover:bg-blue-600 rounded">Clientes</a>
                    <a wire:click.prevent="navegar('suppliers.index')"
                        class="block px-2 py-1 text-sm text-green-300 hover:bg-blue-600 rounded">Proveedores</a>
                </div>
            @endif
        </div>

        <!-- More -->
        <a href="#"
            class="flex items-center gap-4 px-2 py-2 rounded-lg hover:bg-pink-700 transition duration-200">
            <svg class="w-5 h-5 text-red-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 16v6m0 0h6m-6 0h-6M4 6v12" />
            </svg>
            @if ($menuAbierto)
                <span class="text-red-300">More</span>
            @endif
        </a>
    </div>
</div>
