<header
    class="fixed top-0 left-0 right-0 z-50 flex items-center justify-between px-6 py-4 bg-white border-b {{ $menuAbierto ? 'ml-60' : 'ml-0' }} sm:px-4 sm:py-3">
    <div class="flex items-center flex-1">
        <!-- Botón para alternar el menú -->
        <button wire:click="toggleMenu" class="p-2 rounded-full hover:bg-gray-100 sm:p-1">
            <svg class="w-6 h-6 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
        </button>
    </div>

    <div class="flex-1">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight sm:text-lg">
            @if ($currentRoute == 'dashboard')
                Dashboard
            @elseif ($currentRoute == 'clients.index')
                Clientes
            @elseif ($currentRoute == 'products.index')
                Productos
            @elseif ($currentRoute == 'sales.create')
                Nueva Venta
            @elseif ($currentRoute == 'sales.index')
                Lista de ventas
            @elseif ($currentRoute == 'brands.index')
                Marcas
            @elseif ($currentRoute == 'categories.index')
                Categorias
            @elseif ($currentRoute == 'suppliers.index')
                Proveedores
            @elseif ($currentRoute == 'stockentries.create')
                Nueva Entrada
            @else
                {{ $pageTitle ?? 'Página principal' }}
            @endif
        </h2>
    </div>

    <div class="flex items-center gap-4 sm:gap-2" x-data="{ open: false }">

        <div wire:poll.5s="checkPendingSales">
            <!-- Botón de notificación -->
            <button @click="open = !open; $dispatch('close-user-modal')"
                class="p-2 rounded-full hover:bg-gray-100 relative sm:p-1"
                :class="{ 'bg-red-100': @js($hasNotifications), 'hover:bg-gray-100': !@js($hasNotifications) }">
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
            <div x-show="open" @click.away="open = false"
                class="absolute z-50 mt-2 bg-white border border-gray-300 rounded-lg shadow-lg p-4 right-40 w-72">
                <h3 class="text-lg font-semibold text-gray-800">Notificaciones</h3>

                @if ($hasPending || $lowStockProducts->isNotEmpty())
                    <!-- Notificación de facturas pendientes -->
                    @if ($hasPending)
                        <div class="mt-2 cursor-pointer hover:bg-gray-100 p-4 rounded-lg"
                            wire:click="navegar('sales.index')">
                            <span class="text-sm text-gray-700">Tienes facturas pendientes.</span>
                        </div>
                    @endif

                    <!-- Notificación de productos con bajo stock -->
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
                @else
                    <!-- No hay notificaciones -->
                    <div class="mt-4">
                        <span class="text-sm text-gray-500">No tienes notificaciones.</span>
                    </div>
                @endif

                <button @click="open = false" class="mt-4 text-sm text-gray-600 hover:text-gray-800">Cerrar</button>
            </div>

        </div>


        <div>
            <!-- Información del usuario -->
            <div class="relative">
                <div class="flex items-center gap-3 cursor-pointer" wire:click="toggleModal">
                    <div class="text-right">
                        <div class="text-sm font-medium">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-gray-500">Administrador</div>
                    </div>
                    <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}"
                        class="w-10 h-10 rounded-full">
                </div>

                <!-- Modal de usuario -->
                <div x-data="{ open: @entangle('open') }" x-show="open" @click.away="open = false"
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
    </div>
</header>

<script>
    let hasPlayed = false;

    window.addEventListener('play-notification-sound', () => {
        if (!hasPlayed) {
            const audio = new Audio('/storage/audio/audionoti.mp3');
            audio.volume = 1.0;
            audio.play().catch(error => {
                console.error("Error al reproducir el sonido: ", error);
            });
            hasPlayed = true;

            setTimeout(() => {
                hasPlayed = false;
            }, 10000);
        }
    });

    window.addEventListener('popstate', () => {
        hasPlayed = false;
    });
</script>
