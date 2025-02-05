<header x-data="{ scrolledUp: true, lastScroll: 0, mobileMenuOpen: false }" x-init="window.addEventListener('scroll', () => {
    let currentScroll = window.scrollY;
    scrolledUp = currentScroll < lastScroll || currentScroll <= 0;
    lastScroll = currentScroll;
});"
    x-bind:class="{ 'fixed top-0 left-0 w-full transition-transform transform translate-y-0': scrolledUp, 'fixed top-0 left-0 w-full transition-transform transform -translate-y-full': !scrolledUp }"
    class="bg-[#115ac8] shadow-md z-50">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <a href="/" class="flex-shrink-0">
                <img class="h-10 w-auto" src="{{ asset('storage/pageweb/logonuevo.png') }}" alt="Logo">
            </a>

            <!-- Mobile Menu Button -->
            <button
                @click="mobileMenuOpen = !mobileMenuOpen"
                class="inline-flex items-center justify-center p-2 rounded-md text-[#ebe7d9] hover:text-[#f55139] hover:bg-[#115ac8]/30 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-[#f55139] md:hidden"
                aria-expanded="false" id="mobile-menu-button">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>

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
            <div class="ml-4 flex items-center md:ml-6 space-x-6">
                <!-- User Icon -->
                @if (Route::has('login'))
                    <nav class="-mx-3 flex justify-end">
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="rounded-md px-3 py-2 transition focus:outline-none focus-visible:ring-[#FF2D20]">
                                <svg class="h-6 w-6 text-[#ebe7d9] hover:text-[#f55139]" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="rounded-md px-3 py-2 transition focus:outline-none focus-visible:ring-[#FF2D20]">
                                <svg class="h-6 w-6 text-[#ebe7d9] hover:text-[#f55139]" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </a>
                        @endauth
                    </nav>
                @endif

                <!-- Cart Icon -->
                <a href="#" wire:click.prevent="$dispatch('openCartModal')"
                    class="relative rounded-md px-3 py-2 transition focus:outline-none focus-visible:ring-[#FF2D20]">
                    <svg class="h-6 w-6 text-[#ebe7d9] hover:text-[#f55139]" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 459.529 459.529" fill="currentColor">
                        <path
                            d="M17,55.231h48.733l69.417,251.033c1.983,7.367,8.783,12.467,16.433,12.467h213.35c6.8,0,12.75-3.967,15.583-10.2 l77.633-178.5c2.267-5.383,1.7-11.333-1.417-16.15c-3.117-4.817-8.5-7.65-14.167-7.65H206.833c-9.35,0-17,7.65-17,17 s7.65,17,17,17H416.5l-62.9,144.5H164.333L94.917,33.698c-1.983-7.367-8.783-12.467-16.433-12.467H17c-9.35,0-17,7.65-17,17 S7.65,55.231,17,55.231z" />
                        <path
                            d="M135.433,438.298c21.25,0,38.533-17.283,38.533-38.533s-17.283-38.533-38.533-38.533S96.9,378.514,96.9,399.764 S114.183,438.298,135.433,438.298z" />
                        <path
                            d="M376.267,438.298c0.85,0,1.983,0,2.833,0c10.2-0.85,19.55-5.383,26.35-13.317c6.8-7.65,9.917-17.567,9.35-28.05 c-1.417-20.967-19.833-37.117-41.083-35.7c-21.25,1.417-37.117,20.117-35.7,41.083 C339.433,422.431,356.15,438.298,376.267,438.298z" />
                    </svg>
                    @if ($totalItems > 0)
                        <span class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full px-1.5 py-0.5">
                            {{ $totalItems }}
                        </span>
                    @endif
                </a>
            </div>
        </div>
    </div>
</header>
