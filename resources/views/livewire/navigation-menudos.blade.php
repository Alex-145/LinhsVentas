<div class="{{ $menuAbierto ? 'w-60 p-4' : 'w-0' }} bg-[#1E2A3A] overflow-y-auto max-h-screen min-h-screen text-white transition-all duration-300 fixed top-0 left-0 z-50"
    style="scrollbar-width: none; -ms-overflow-style: none;">
    <div class="space-y-2">



        <!-- Botón para Raíz -->
        <a wire:click.prevent="navegarinicio('/')"
            class="flex items-center gap-4 px-3 py-2 rounded-lg bg-white/10 hover:bg-white/20 transition duration-200 cursor-pointer text-white {{ request()->routeIs('/') ? 'bg-white/20' : '' }} {{ $menuAbierto ? '' : 'hidden' }}">
            <i class="fas fa-home text-blue-400" style="font-size: 18px;"></i>
            @if ($menuAbierto)
                <span class="ml-2">Inicio</span>
            @endif
        </a>

        <!-- Botón para Dashboard -->
        <a wire:click.prevent="navegar('dashboard')"
            class="flex items-center gap-4 px-3 py-2 rounded-lg bg-white/10 hover:bg-white/20 transition duration-200 cursor-pointer text-white {{ request()->routeIs('dashboard') ? 'bg-white/20' : '' }} {{ $menuAbierto ? '' : 'hidden' }}">
            <i class="fas fa-tachometer-alt text-yellow-400" style="font-size: 18px;"></i>
            @if ($menuAbierto)
                <span class="ml-2">Dashboard</span>
            @endif
        </a>

        <!-- Inventario Dropdown -->
        <div class="relative">
            <button wire:click="toggleDropdown('inventario')"
                class="flex items-center gap-4 px-3 py-2 rounded-lg bg-white/10 hover:bg-white/20 transition duration-200 cursor-pointer text-white w-full text-left {{ $menuAbierto ? '' : 'hidden' }}">
                <i class="fas fa-box w-5 h-5 text-teal-400"></i>
                @if ($menuAbierto)
                    <span>Inventario</span>
                    <svg class="w-4 h-4 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                @endif
            </button>
            @if ($menuAbierto && $dropdowns['inventario'])
                <div class="mt-2 space-y-2 pl-6 text-white text-sm">
                    <a wire:click.prevent="navegar('stockentries.create')"
                        class="block px-2 py-1 hover:bg-white/20 rounded cursor-pointer">
                        <i class="fas fa-plus-circle mr-2 text-teal-300"></i> Nueva Entrada
                    </a>
                    <a wire:click.prevent="navegar('stockentries.index')"
                        class="block px-2 py-1 hover:bg-white/20 rounded cursor-pointer">
                        <i class="fas fa-list mr-2 text-teal-300"></i> Lista de Entradas
                    </a>
                    <a wire:click.prevent="navegar('products.index')"
                        class="block px-2 py-1 hover:bg-white/20 rounded cursor-pointer">
                        <i class="fas fa-box mr-2 text-teal-300"></i> Productos
                    </a>
                    <a wire:click.prevent="navegar('brands.index')"
                        class="block px-2 py-1 hover:bg-white/20 rounded cursor-pointer">
                        <i class="fas fa-tags mr-2 text-teal-300"></i> Marcas
                    </a>
                    <a wire:click.prevent="navegar('categories.index')"
                        class="block px-2 py-1 hover:bg-white/20 rounded cursor-pointer">
                        <i class="fas fa-th-list mr-2 text-teal-300"></i> Categorías
                    </a>
                    <a wire:click.prevent="navegar('services.index')"
                        class="block px-2 py-1 hover:bg-white/20 rounded cursor-pointer">
                        <i class="fas fa-concierge-bell mr-2 text-teal-300"></i> Servicios
                    </a>
                </div>
            @endif
        </div>

        <!-- Ventas Dropdown -->
        <div class="relative">
            <button wire:click="toggleDropdown('ventas')"
                class="flex items-center gap-4 px-3 py-2 rounded-lg bg-white/10 hover:bg-white/20 transition duration-200 cursor-pointer text-white w-full text-left {{ $menuAbierto ? '' : 'hidden' }}">
                <i class="fas fa-money-bill-wave w-5 h-5 text-orange-400"></i>
                @if ($menuAbierto)
                    <span>Ventas</span>
                    <svg class="w-4 h-4 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                @endif
            </button>

            @if ($menuAbierto && $dropdowns['ventas'])
                <div class="mt-2 space-y-2 pl-6 text-white text-sm">
                    <a wire:click.prevent="navegar('ventas-online.index')"
                        class="block px-2 py-1 hover:bg-white/20 rounded cursor-pointer">
                        <i class="fas fa-globe mr-2 text-orange-300"></i> Ventas Online
                    </a>
                    <a wire:click.prevent="navegar('sales.create')"
                        class="block px-2 py-1 hover:bg-white/20 rounded cursor-pointer">
                        <i class="fas fa-shopping-cart mr-2 text-orange-300"></i> Nueva Venta
                    </a>
                    <a wire:click.prevent="navegarsales('sales.index')"
                        class="block px-2 py-1 hover:bg-white/20 rounded cursor-pointer">
                        <i class="fas fa-receipt mr-2 text-orange-300"></i> Lista de Ventas
                    </a>

                </div>
            @endif
        </div>


        <!-- Contactos Dropdown -->
        <div class="relative">
            <button wire:click="toggleDropdown('contactos')"
                class="flex items-center gap-4 px-3 py-2 rounded-lg bg-white/10 hover:bg-white/20 transition duration-200 cursor-pointer text-white w-full text-left {{ $menuAbierto ? '' : 'hidden' }}">
                <i class="fas fa-user w-5 h-5 text-green-400"></i>
                @if ($menuAbierto)
                    <span>Contactos</span>
                    <svg class="w-4 h-4 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                @endif
            </button>
            @if ($menuAbierto && $dropdowns['contactos'])
                <div class="mt-2 space-y-2 pl-6 text-white text-sm">
                    <a wire:click.prevent="navegar('clients.index')"
                        class="block px-2 py-1 hover:bg-white/20 rounded cursor-pointer">
                        <i class="fas fa-users mr-2 text-green-300"></i> Clientes
                    </a>
                    <a wire:click.prevent="navegar('suppliers.index')"
                        class="block px-2 py-1 hover:bg-white/20 rounded cursor-pointer">
                        <i class="fas fa-truck mr-2 text-green-300"></i> Proveedores
                    </a>
                </div>
            @endif
        </div>

        <!-- Más -->
        <div class="relative">
            <button wire:click="toggleDropdown('more')"
                class="flex items-center gap-4 px-3 py-2 rounded-lg bg-white/10 hover:bg-white/20 transition duration-200 cursor-pointer text-white w-full text-left {{ $menuAbierto ? '' : 'hidden' }}">
                <svg class="w-5 h-5 text-red-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 16v6m0 0h6m-6 0h-6M4 6v12" />
                </svg>
                @if ($menuAbierto)
                    <span>Más</span>
                    <svg class="w-4 h-4 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                @endif
            </button>
            @if ($menuAbierto && $dropdowns['more'])
                <div class="mt-2 space-y-2 pl-6 text-white text-sm">
                    <a wire:click.prevent="navegarinicio('/register')"
                        class="block px-2 py-1 hover:bg-white/20 rounded cursor-pointer">
                        <i class="fas fa-user-plus mr-2 text-red-300"></i> Crear Nuevo Usuario
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
