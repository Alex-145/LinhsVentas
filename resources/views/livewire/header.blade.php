<header class="fixed top-0 left-0 right-0 z-50 flex items-center justify-between px-6 py-4 bg-white border-b {{ $menuAbierto ? 'ml-60' : 'ml-16' }}">
    <div class="flex items-center flex-1">
        <!-- Botón para alternar el menú -->
        <button wire:click="toggleMenu" class="p-2 rounded-full hover:bg-gray-100">
            <svg class="w-6 h-6 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
        </button>
    </div>

    <div class="flex-1">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if ($currentRoute == 'dashboard') Dashboard
            @elseif ($currentRoute == 'clients.index') Clientes
            @elseif ($currentRoute == 'products.index') Productos
            @elseif ($currentRoute == 'sales.create') Nueva Venta
            @elseif ($currentRoute == 'sales.index') Lista de ventas
            @elseif ($currentRoute == 'brands.index') Marcas
            @elseif ($currentRoute == 'categories.index') Categorias
            @elseif ($currentRoute == 'suppliers.index') Proveedores
            @elseif ($currentRoute == 'stockentries.create') Nueva Entrada
            @else {{ $pageTitle ?? 'Página principal' }}
            @endif
        </h2>
    </div>

    <div class="flex items-center gap-4">
        <!-- Otros botones del header -->
        <button class="p-2 rounded-full hover:bg-gray-100">
            <svg class="w-5 h-5 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </button>

        <!-- Botón de notificación con indicador -->
        <button class="p-2 rounded-full hover:bg-gray-100 relative">
            <svg class="w-5 h-5 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
        </button>

        <div>
            <!-- Información del usuario -->
            <div class="relative">
                <div class="flex items-center gap-3 cursor-pointer" wire:click="toggleModal">
                    <div class="text-right">
                        <div class="text-sm font-medium">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-gray-500">Administrador
                        </div>
                    </div>
                    <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="w-10 h-10 rounded-full">
                </div>

                <!-- Modal -->
                <div x-data="{ open: @entangle('open') }" x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg">
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Manage Account') }}
                    </div>
                    <a href="{{ route('profile.showt') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('Profile') }}</a>

                    <div class="border-t border-gray-200"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            {{ __('Log Out') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</header>
