<header x-data="{ scrolledUp: true, lastScroll: 0, mobileMenuOpen: false }" x-init="window.addEventListener('scroll', () => {
    let currentScroll = window.scrollY;
    scrolledUp = currentScroll < lastScroll || currentScroll <= 0;
    lastScroll = currentScroll;
});"
    x-bind:class="{
        'fixed top-0 left-0 w-full transition-all duration-300 transform translate-y-0 bg-[#115ac8] shadow-lg z-50': scrolledUp,
        'fixed top-0 left-0 w-full transition-all duration-300 transform -translate-y-full bg-[#115ac8] shadow-lg z-50':
            !scrolledUp
    }">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">

            <!-- Botón Menú Móvil -->
            <button @click="mobileMenuOpen = !mobileMenuOpen"
                class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-[#ebe7d9] hover:text-[#f55139] hover:bg-white/10 focus:outline-none">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>

            <!-- Logo -->
            <a href="/" class="flex-shrink-0">
                <img class="h-10 w-auto" src="{{ asset('storage/pageweb/logonuevo.png') }}" alt="Logo">
            </a>

            <!-- Navegación Desktop -->
            <nav class="hidden md:flex items-center space-x-4">
                <a href="/"
                    class="text-[#ebe7d9] hover:text-[#f55139] px-3 py-2 text-sm font-medium transition">Inicio</a>
                <a href="{{ route('wnosotros.index') }}"
                    class="text-[#ebe7d9] hover:text-[#f55139] px-3 py-2 text-sm font-medium transition">Nosotros</a>
                <a href="{{ route('wproducts.index') }}"
                    class="text-[#ebe7d9] hover:text-[#f55139] px-3 py-2 text-sm font-medium transition">Productos</a>
                <a href="{{ route('wservices.index') }}"
                    class="text-[#ebe7d9] hover:text-[#f55139] px-3 py-2 text-sm font-medium transition">Servicios</a>
                <a href="{{ route('wcontactenos.index') }}"
                    class="text-[#ebe7d9] hover:text-[#f55139] px-3 py-2 text-sm font-medium transition">Contáctenos</a>
            </nav>

            <!-- Íconos Usuario / Carrito -->
            <div class="flex items-center space-x-4">
                @if (Route::has('login'))
                    @auth
                        <!-- Usuario logueado: ícono -->
                        <a href="{{ url('/dashboard') }}" class="transition transform hover:scale-110 focus:outline-none">
                            <i class="fas fa-user-circle text-2xl text-[#ebe7d9] hover:text-[#f55139]"></i>
                        </a>
                    @else
                        <!-- Usuario no logueado: texto -->
                        <a href="{{ route('login') }}"
                            class="text-[#ebe7d9] hover:text-[#f55139] font-semibold text-sm px-4 py-2 rounded transition transform hover:scale-105">
                            Ingresar
                        </a>
                    @endauth
                @endif

                <!-- Carrito -->
                <a href="#"
                    @click.prevent="
                    @if (request()->routeIs('wfinalsale.index')) $el.classList.add('animate-bounce');
                    setTimeout(() => $el.classList.remove('animate-bounce'), 500);
                    @else
                    $dispatch('openCartModal') @endif
                "
                    class="relative transition transform hover:scale-110">
                    <i class="fas fa-shopping-cart text-2xl text-[#ebe7d9] hover:text-[#f55139]"></i>
                    @if ($totalItems > 0)
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full px-1.5 py-0.5">
                            {{ $totalItems }}
                        </span>
                    @endif
                </a>
            </div>
        </div>
    </div>

    <!-- Menú móvil -->
    <div x-show="mobileMenuOpen" @click.away="mobileMenuOpen = false" x-transition
        class="md:hidden bg-[#115ac8] shadow-md px-4 py-4 space-y-2 z-40">
        <a href="/" class="block text-[#ebe7d9] hover:text-[#f55139] text-base font-medium">Inicio</a>
        <a href="{{ route('wnosotros.index') }}"
            class="block text-[#ebe7d9] hover:text-[#f55139] text-base font-medium">Nosotros</a>
        <a href="{{ route('wproducts.index') }}"
            class="block text-[#ebe7d9] hover:text-[#f55139] text-base font-medium">Productos</a>
        <a href="{{ route('wservices.index') }}"
            class="block text-[#ebe7d9] hover:text-[#f55139] text-base font-medium">Servicios</a>
        <a href="{{ route('wcontactenos.index') }}"
            class="block text-[#ebe7d9] hover:text-[#f55139] text-base font-medium">Contáctenos</a>
    </div>
</header>
