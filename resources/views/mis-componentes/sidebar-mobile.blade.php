<aside x-show="mobileSidebarOpen" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
    x-transition:leave="transition ease-in duration-300" x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full" x-cloak
    class="fixed inset-0 z-50 bg-[#1E2A3A] text-white h-screen w-full transform md:hidden overflow-y-auto">

    <div class="flex items-center justify-between p-4 border-b border-gray-700">
        <!-- Logo en lugar del texto "Menú" -->
        <div class="flex items-center">
            <img src="{{ asset('storage/pageweb/logonuevosinfondo.png') }}" alt="Logo Linhs Llantas" class="h-10">
        </div>

        <button @click="mobileSidebarOpen = false" class="text-gray-400 hover:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <nav class="p-4 space-y-2">
        <!-- Inicio -->
        <a href="{{ route('dashboard') }}" @click="mobileSidebarOpen = false"
            class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-white/10 transition">
            <i class="fas fa-home text-blue-400 w-5"></i>
            <span>Inicio</span>
        </a>

        <!-- Inventario Dropdown -->
        <div x-data="{ open: false }">
            <button @click="open = !open"
                class="flex items-center justify-between w-full px-4 py-2 rounded-lg hover:bg-white/10 transition">
                <div class="flex items-center gap-3">
                    <i class="fas fa-box text-teal-400 w-5"></i>
                    <span>Inventario</span>
                </div>
                <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <div x-show="open" x-collapse class="pl-10 mt-1 space-y-1">
                <a href="{{ route('stockentries.create') }}" @click="mobileSidebarOpen = false"
                    class="flex items-center gap-2 px-3 py-1 text-sm rounded hover:bg-white/10 transition">
                    <i class="fas fa-plus-circle text-teal-300 w-4"></i>
                    Nueva Entrada
                </a>
                <a href="{{ route('stockentries.index') }}" @click="mobileSidebarOpen = false"
                    class="flex items-center gap-2 px-3 py-1 text-sm rounded hover:bg-white/10 transition">
                    <i class="fas fa-list text-teal-300 w-4"></i>
                    Lista de Entradas
                </a>
                <a href="{{ route('products.index') }}" @click="mobileSidebarOpen = false"
                    class="flex items-center gap-2 px-3 py-1 text-sm rounded hover:bg-white/10 transition">
                    <i class="fas fa-box text-teal-300 w-4"></i>
                    Productos
                </a>
                <a href="{{ route('brands.index') }}" @click="mobileSidebarOpen = false"
                    class="flex items-center gap-2 px-3 py-1 text-sm rounded hover:bg-white/10 transition">
                    <i class="fas fa-tags text-teal-300 w-4"></i>
                    Marcas
                </a>
                <a href="{{ route('categories.index') }}" @click="mobileSidebarOpen = false"
                    class="flex items-center gap-2 px-3 py-1 text-sm rounded hover:bg-white/10 transition">
                    <i class="fas fa-th-list text-teal-300 w-4"></i>
                    Categorías
                </a>
                <a href="{{ route('services.index') }}" @click="mobileSidebarOpen = false"
                    class="flex items-center gap-2 px-3 py-1 text-sm rounded hover:bg-white/10 transition">
                    <i class="fas fa-concierge-bell text-teal-300 w-4"></i>
                    Servicios
                </a>
            </div>
        </div>

        <!-- Ventas Dropdown -->
        <div x-data="{ open: false }">
            <button @click="open = !open"
                class="flex items-center justify-between w-full px-4 py-2 rounded-lg hover:bg-white/10 transition">
                <div class="flex items-center gap-3">
                    <i class="fas fa-money-bill-wave text-orange-400 w-5"></i>
                    <span>Ventas</span>
                </div>
                <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <div x-show="open" x-collapse class="pl-10 mt-1 space-y-1">
                <a href="{{ route('ventas-online.index') }}" @click="mobileSidebarOpen = false"
                    class="flex items-center gap-2 px-3 py-1 text-sm rounded hover:bg-white/10 transition">
                    <i class="fas fa-globe text-orange-300 w-4"></i>
                    Ventas Online
                </a>
                <a href="{{ route('sales.create') }}" @click="mobileSidebarOpen = false"
                    class="flex items-center gap-2 px-3 py-1 text-sm rounded hover:bg-white/10 transition">
                    <i class="fas fa-shopping-cart text-orange-300 w-4"></i>
                    Nueva Venta
                </a>
                <a href="{{ route('sales.index', ['isPendienteFacturacion' => false]) }}"
                    @click="mobileSidebarOpen = false"
                    class="flex items-center gap-2 px-3 py-1 text-sm rounded hover:bg-white/10 transition">
                    <i class="fas fa-receipt text-orange-300 w-4"></i>
                    Lista de Ventas
                </a>
            </div>
        </div>

        <!-- Contactos Dropdown -->
        <div x-data="{ open: false }">
            <button @click="open = !open"
                class="flex items-center justify-between w-full px-4 py-2 rounded-lg hover:bg-white/10 transition">
                <div class="flex items-center gap-3">
                    <i class="fas fa-user text-green-400 w-5"></i>
                    <span>Contactos</span>
                </div>
                <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <div x-show="open" x-collapse class="pl-10 mt-1 space-y-1">
                <a href="{{ route('clients.index') }}" @click="mobileSidebarOpen = false"
                    class="flex items-center gap-2 px-3 py-1 text-sm rounded hover:bg-white/10 transition">
                    <i class="fas fa-users text-green-300 w-4"></i>
                    Clientes
                </a>
                <a href="{{ route('suppliers.index') }}" @click="mobileSidebarOpen = false"
                    class="flex items-center gap-2 px-3 py-1 text-sm rounded hover:bg-white/10 transition">
                    <i class="fas fa-truck text-green-300 w-4"></i>
                    Proveedores
                </a>
            </div>
        </div>

        <!-- Más Dropdown -->
        <div x-data="{ open: false }">
            <button @click="open = !open"
                class="flex items-center justify-between w-full px-4 py-2 rounded-lg hover:bg-white/10 transition">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-red-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 16v6m0 0h6m-6 0h-6M4 6v12" />
                    </svg>
                    <span>Más</span>
                </div>
                <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <div x-show="open" x-collapse class="pl-10 mt-1 space-y-1">
                <a href="{{ route('register') }}" @click="mobileSidebarOpen = false"
                    class="flex items-center gap-2 px-3 py-1 text-sm rounded hover:bg-white/10 transition">
                    <i class="fas fa-user-plus text-red-300 w-4"></i>
                    Crear Nuevo Usuario
                </a>
            </div>
        </div>
    </nav>
</aside>
