<div
    class="{{ $menuAbierto ? 'w-60 p-4' : 'w-0' }} bg-[#1E2A3A] overflow-y-auto max-h-screen min-h-screen text-white transition-all duration-300 fixed top-0 left-0 z-50" style="scrollbar-width: none; -ms-overflow-style: none;">
<div class="space-y-2">

        <!-- Botón para Raíz -->
        <a wire:click.prevent="navegarinicio('/')"
            class="flex items-center gap-4 px-2 py-2 rounded-lg hover:bg-green-600 transition duration-200 cursor-pointer {{ request()->routeIs('/') ? 'bg-green-600' : '' }} {{ $menuAbierto ? '' : 'hidden' }}">
            <i class="fas fa-home text-blue-400" style="font-size: 18px;"></i>
            @if ($menuAbierto)
                <span class="text-blue-300 ml-2">Inicio</span>
            @endif
        </a>
        <!-- Botón para Dashboard -->
        <a wire:click.prevent="navegar('dashboard')"
            class="flex items-center gap-4 px-2 py-2 rounded-lg hover:bg-blue-600 transition duration-200 cursor-pointer {{ request()->routeIs('dashboard') ? 'bg-blue-600' : '' }} {{ $menuAbierto ? '' : 'hidden' }}">
            <i class="fas fa-tachometer-alt text-yellow-400" style="font-size: 18px;"></i>
            @if ($menuAbierto)
                <span class="text-yellow-300 ml-2">Dashboard</span>
            @endif
        </a>

        <!-- Inventario Dropdown -->
        <div class="relative">
            <button wire:click="toggleDropdown('inventario')"
                class="flex items-center gap-4 px-2 py-2 rounded-lg hover:bg-teal-600 transition duration-200 cursor-pointer w-full text-left {{ $menuAbierto ? '' : 'hidden' }}">

                <i class="fas fa-box w-5 h-5 text-teal-400"></i> <!-- Icono de caja de Font Awesome -->

                @if ($menuAbierto)
                    <span class="text-teal-300">Inventario</span>
                    <svg class="w-4 h-4 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                @endif
            </button>
            @if ($menuAbierto && $dropdowns['inventario'])
                <div class="mt-2 space-y-2 pl-6">

                    <a wire:click.prevent="navegar('stockentries.create')"
                        class="flex items-center block px-2 py-1 text-sm text-teal-300 hover:bg-teal-500 rounded cursor-pointer">
                        <i class="fas fa-plus-circle mr-2"></i> <!-- Icono de agregar -->
                        Nueva Entrada
                    </a>


                    <a wire:click.prevent="navegar('stockentries.index')"
                        class="flex items-center block px-2 py-1 text-sm text-teal-300 hover:bg-teal-500 rounded cursor-pointer">
                        <i class="fas fa-list mr-2"></i> <!-- Icono de lista -->
                        Lista de Entradas
                    </a>

                    <a wire:click.prevent="navegar('products.index')"
                        class="flex items-center block px-2 py-1 text-sm text-teal-300 hover:bg-teal-500 rounded cursor-pointer">
                        <i class="fas fa-box mr-2"></i> <!-- Icono de caja -->
                        Productos
                    </a>

                    <a wire:click.prevent="navegar('brands.index')"
                        class="flex items-center block px-2 py-1 text-sm text-teal-300 hover:bg-teal-500 rounded cursor-pointer">
                        <i class="fas fa-tags mr-2"></i> <!-- Icono de etiquetas -->
                        Marcas
                    </a>

                    <a wire:click.prevent="navegar('categories.index')"
                        class="flex items-center block px-2 py-1 text-sm text-teal-300 hover:bg-teal-500 rounded cursor-pointer">
                        <i class="fas fa-th-list mr-2"></i> <!-- Icono de categorías -->
                        Categorías
                    </a>

                    <a wire:click.prevent="navegar('services.index')"
                        class="flex items-center block px-2 py-1 text-sm text-teal-300 hover:bg-teal-500 rounded cursor-pointer">
                        <i class="fas fa-concierge-bell mr-2"></i> <!-- Icono de servicios -->
                        Servicios
                    </a>

                </div>
            @endif
        </div>

        <!-- Ventas Dropdown -->
        <div class="relative">
            <button wire:click="toggleDropdown('ventas')"
                class="flex items-center gap-4 px-2 py-2 rounded-lg hover:bg-orange-600 transition duration-200 cursor-pointer w-full text-left {{ $menuAbierto ? '' : 'hidden' }}">

                <i class="fas fa-money-bill-wave w-5 h-5 text-orange-400"></i> <!-- Icono de dinero de Font Awesome -->

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
                        class="flex items-center block px-2 py-1 text-sm text-orange-300 hover:bg-orange-500 rounded cursor-pointer">
                        <i class="fas fa-shopping-cart mr-2"></i> <!-- Icono de carrito de compras -->
                        Nueva Venta
                    </a>
                    <a wire:click.prevent="navegarsales('sales.index')"
                        class="flex items-center block px-2 py-1 text-sm text-orange-300 hover:bg-orange-500 rounded cursor-pointer">
                        <i class="fas fa-receipt mr-2"></i> <!-- Icono de recibo -->
                        Lista de Ventas
                    </a>
                </div>
            @endif
        </div>

        <!-- Contactos Dropdown -->
        <div class="relative">
            <button wire:click="toggleDropdown('contactos')"
                class="flex items-center gap-4 px-2 py-2 rounded-lg hover:bg-green-600 transition duration-200 cursor-pointer w-full text-left {{ $menuAbierto ? '' : 'hidden' }}">

                <i class="fas fa-user w-5 h-5 text-green-400"></i> <!-- Icono de usuario de Font Awesome -->

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
                        class="flex items-center block px-2 py-1 text-sm text-green-300 hover:bg-green-500 rounded cursor-pointer">
                        <i class="fas fa-users mr-2"></i> <!-- Icono de usuarios -->
                        Clientes
                    </a>
                    <a wire:click.prevent="navegar('suppliers.index')"
                        class="flex items-center block px-2 py-1 text-sm text-green-300 hover:bg-green-500 rounded cursor-pointer">
                        <i class="fas fa-truck mr-2"></i> <!-- Icono de camión (proveedores) -->
                        Proveedores
                    </a>
                </div>
            @endif
        </div>

        <!-- More -->
        <!-- More -->
        <div class="relative">
            <button wire:click="toggleDropdown('more')"
                class="flex items-center gap-4 px-2 py-2 rounded-lg hover:bg-pink-600 transition duration-200 cursor-pointer w-full text-left {{ $menuAbierto ? '' : 'hidden' }}">
                <svg class="w-5 h-5 text-red-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 16v6m0 0h6m-6 0h-6M4 6v12" />
                </svg>
                @if ($menuAbierto)
                    <span class="text-red-300">Más</span>
                    <svg class="w-4 h-4 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                @endif
            </button>
            @if ($menuAbierto && $dropdowns['more'])
                <div class="mt-2 space-y-2 pl-6">
                    <!-- Opción Crear Nuevo Usuario -->
                    <a wire:click.prevent="navegarinicio('/register')"
                        class="flex items-center block px-2 py-1 text-sm text-red-300 hover:bg-pink-500 rounded cursor-pointer">
                        <i class="fas fa-user-plus mr-2"></i> <!-- Icono de agregar usuario -->
                        Crear Nuevo Usuario
                    </a>
                </div>
            @endif
        </div>



    </div>
    <style>
        @media screen and (max-width: 640px) {

            /* Ajustar el ancho del menú en pantallas pequeñas */
            .menu-abierto {
                width: 80% !important;
                /* Cambia el ancho al 80% de la pantalla */
            }

            .menu-cerrado {
                width: 0 !important;
                /* Ocultar el menú completamente si está cerrado */
            }

            /* Hacer que los textos y espacios sean más pequeños */
            .menu-abierto a span {
                font-size: 0.875rem;
                /* Reduce el tamaño del texto */
            }

            .menu-abierto .gap-4 {
                gap: 0.5rem;
                /* Reduce el espacio entre íconos y texto */
            }

            .menu-abierto .px-2 {
                padding-left: 0.5rem;
                /* Reduce los márgenes internos */
                padding-right: 0.5rem;
            }

            .menu-abierto .py-2 {
                padding-top: 0.375rem;
                /* Reduce los márgenes internos */
                padding-bottom: 0.375rem;
            }

            /* Ajustar íconos para que se vean mejor en pantallas pequeñas */
            .menu-abierto i,
            .menu-abierto svg {
                font-size: 16px !important;
                /* Haz los íconos un poco más pequeños */
            }
        }
    </style>


</div>
