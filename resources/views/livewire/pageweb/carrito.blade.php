<div x-data="{ isOpen: @entangle('isOpen') }">
    <!-- Modal Backdrop -->
    <div x-show="isOpen" class="fixed inset-0 bg-black bg-opacity-50 z-50" @click.self="isOpen = false">
        <!-- Modal Content -->
        <div x-show="isOpen" x-transition:enter="transition transform duration-300 ease-in-out" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition transform duration-300 ease-in-out" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" class="fixed inset-0 flex justify-end">
            <div class="bg-white w-full max-w-md h-full shadow-lg flex flex-col">
                <!-- Modal Header -->
                <div class="flex justify-between items-center border-b p-4">
                    <h2 class="text-xl font-semibold">Carrito de Compras</h2>
                    <button @click="isOpen = false" class="text-gray-500 hover:text-gray-700">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-4 overflow-y-auto flex-1"> <!-- flex-1 para que ocupe el espacio restante -->
                    @if (count($cart) > 0)
                        @foreach ($cart as $item)
                            <div class="mb-4 border-b pb-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <img src="{{ asset('storage/' . $item['photo_url']) }}" alt="{{ $item['name'] }}" class="w-16 h-16 object-cover mr-4">
                                        <div>
                                            <h3 class="font-semibold">{{ $item['name'] }}</h3>
                                            <p class="text-gray-600">S/.{{ number_format($item['price'], 2) }}</p>
                                            <div class="flex items-center space-x-2">
                                                <button wire:click="decrementQuantity({{ $item['id'] }})" class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300">
                                                    -
                                                </button>
                                                <p class="text-sm text-gray-500">{{ $item['quantity'] }}</p>
                                                <button wire:click="incrementQuantity({{ $item['id'] }})" class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300">
                                                    +
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <button wire:click="removeFromCart({{ $item['id'] }})" class="text-red-500 hover:text-red-700">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-gray-600">El carrito está vacío.</p>
                    @endif
                </div>

                <!-- Modal Footer -->
                <div class="border-t p-4">
                    <!-- Subtotal -->
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-lg font-semibold">Subtotal:</span>
                        <span class="text-lg font-semibold">S/.{{ number_format($subtotal, 2) }}</span>
                    </div>

                    <!-- Botón de Cerrar -->
                    <button @click="isOpen = false" class="w-full px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
