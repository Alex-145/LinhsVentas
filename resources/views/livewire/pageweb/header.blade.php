<header x-data="{ scrolledUp: true, lastScroll: 0, mobileMenuOpen: false }" x-init="window.addEventListener('scroll', () => {
    let currentScroll = window.scrollY;
    scrolledUp = currentScroll < lastScroll || currentScroll <= 0;
    lastScroll = currentScroll;
});"
    x-bind:class="{
        'fixed top-0 left-0 w-full transition-transform transform translate-y-0': scrolledUp,
        'fixed top-0 left-0 w-full transition-transform transform -translate-y-full':
            !scrolledUp
    }"
    class="bg-[#115ac8] shadow-md z-50">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">

            <!-- Mobile Menu Button -->
            <button @click="mobileMenuOpen = !mobileMenuOpen"
                class="inline-flex items-center justify-center p-2 rounded-md text-[#ebe7d9] hover:text-[#f55139] hover:bg-[#115ac8]/30 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-[#f55139] md:hidden"
                aria-expanded="false" id="mobile-menu-button">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>
            <!-- Logo -->
            <a href="/" class="flex-shrink-0">
                <img class="h-10 w-auto" src="{{ asset('storage/pageweb/logonuevo.png') }}" alt="Logo">
            </a>



            <!-- Navigation Menu -->
            <nav class="hidden md:flex items-center space-x-4">
                <a href="/"
                    class="text-[#ebe7d9] hover:text-[#f55139] px-3 py-2 rounded-md text-sm font-medium">Inicio</a>
                <a href="{{ route('wnosotros.index') }}"
                    class="text-[#ebe7d9] hover:text-[#f55139] px-3 py-2 rounded-md text-sm font-medium">Nosotros</a>
                <a href="{{ route('wproducts.index') }}"
                    class="text-[#ebe7d9] hover:text-[#f55139] px-3 py-2 rounded-md text-sm font-medium">Productos</a>
                <a href="{{ route('wservices.index') }}"
                    class="text-[#ebe7d9] hover:text-[#f55139] px-3 py-2 rounded-md text-sm font-medium">Servicios</a>
                <a href="{{ route('wcontactenos.index') }}"
                    class="text-[#ebe7d9] hover:text-[#f55139] px-3 py-2 rounded-md text-sm font-medium">Contáctenos</a>
            </nav>

            <!-- Mobile Navigation Menu -->
            <div x-show="mobileMenuOpen" @click.away="mobileMenuOpen = false"
                class="md:hidden absolute top-16 left-0 right-0 bg-[#115ac8] shadow-md z-50">
                <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                    <a href="/"
                        class="block text-[#ebe7d9] hover:text-[#f55139] px-3 py-2 rounded-md text-base font-medium">Inicio</a>
                    <a href="{{ route('wnosotros.index') }}"
                        class="block text-[#ebe7d9] hover:text-[#f55139] px-3 py-2 rounded-md text-base font-medium">Nosotros</a>
                    <a href="{{ route('wproducts.index') }}"
                        class="block text-[#ebe7d9] hover:text-[#f55139] px-3 py-2 rounded-md text-base font-medium">Productos</a>
                    <a href="{{ route('wservices.index') }}"
                        class="block text-[#ebe7d9] hover:text-[#f55139] px-3 py-2 rounded-md text-base font-medium">Servicios</a>
                    <a href="{{ route('wcontactenos.index') }}"
                        class="block text-[#ebe7d9] hover:text-[#f55139] px-3 py-2 rounded-md text-base font-medium">Contáctenos</a>
                </div>
            </div>

            <!-- User and Cart Icons -->
            <div class="ml-4 flex items-center md:ml-6 space-x-6" x-data="{ isOpen: false }">
                <!-- User Icon -->
                @if (Route::has('login'))
                    <nav class="-mx-3 flex justify-end">
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="rounded-md px-3 py-2 transition transform hover:scale-110 focus:outline-none focus-visible:ring-[#FF2D20]">
                                <i class="fas fa-user-circle text-2xl text-[#ebe7d9] hover:text-[#f55139]"></i>
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="rounded-md px-3 py-2 transition transform hover:scale-110 focus:outline-none focus-visible:ring-[#FF2D20]">
                                <i class="fas fa-sign-in-alt text-2xl text-[#ebe7d9] hover:text-[#f55139]"></i>
                            </a>
                        @endauth
                    </nav>
                @endif

                <!-- Cart Icon -->
                <!-- Cart Icon -->
                <a href="#" x-data
                    @click.prevent="
    @if (request()->routeIs('wfinalsale.index')) $el.classList.add('animate-bounce');
        setTimeout(() => $el.classList.remove('animate-bounce'), 500);
    @else
        $dispatch('openCartModal') @endif
"
                    class="relative rounded-md px-3 py-2 transition transform hover:scale-110 focus:outline-none focus-visible:ring-[#FF2D20]">

                    <i class="fas fa-shopping-cart text-2xl text-[#ebe7d9] hover:text-[#f55139]"></i>

                    @if ($totalItems > 0)
                        <span
                            class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full px-1.5 py-0.5 transform translate-x-1/2 -translate-y-1/2">
                            {{ $totalItems }}
                        </span>
                    @endif
                </a>

            </div>
        </div>
    </div>
</header>
