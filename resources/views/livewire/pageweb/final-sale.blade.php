<div class="container mx-auto p-6 grid grid-cols-1 md:grid-cols-2 gap-6" x-data="{ necesitaFactura: false }">
    <!-- Sección de Información del Cliente -->
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-bold mb-4">Información del Cliente</h2>
        <form wire:submit.prevent="submit">
            <label class="block mb-2">DNI</label>
            <div class="flex gap-2">
                <input type="text" wire:model="dni" class="w-full border p-2 rounded" required>
                <button type="button" wire:click="searchClient"
                    class="bg-blue-600 text-white px-4 py-2 rounded shadow-md hover:bg-blue-700">
                    Buscar
                </button>
            </div>

            @if ($message)
                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
            @endif


            <label class="block mt-4 mb-2">Nombre</label>
            <input type="text" wire:model="name" class="w-full border p-2 rounded mb-4" required>

            <label class="block mb-2">Correo</label>
            <input type="email" wire:model="email" class="w-full border p-2 rounded mb-4" required>

            <label class="block mb-2">Celular</label>
            <input type="text" wire:model="phone_number" class="w-full border p-2 rounded mb-4" required>

            <label class="flex items-center mb-4">
                <input type="checkbox" class="mr-2" x-model="necesitaFactura">
                Necesito Factura
            </label>

            <div x-show="necesitaFactura" class="mt-2">
                <label class="block mb-2">RUC</label>
                <input type="text" wire:model="ruc" class="w-full border p-2 rounded mb-4" >

                <label class="block mb-2">Razón Social</label>
                <input type="text" wire:model="business_name" class="w-full border p-2 rounded mb-4" >
            </div>


            <p class="text-red-600 text-sm mb-4">Debe recoger su pedido en nuestra tienda.</p>


        </form>
    </div>

    <!-- Resumen de la Compra -->
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-bold mb-4">Resumen de tu Compra</h2>

        @if (count($cart) > 0)
            <div>
                @foreach ($cart as $item)
                    <div class="flex flex-col sm:flex-row items-center justify-between border-b py-2">
                        <div class="flex items-center">
                            <img src="{{ asset('storage/' . $item['photo_url']) }}" alt="{{ $item['name'] }}"
                                class="w-16 h-16 object-cover mr-4">
                            <div>
                                <h3 class="font-semibold">{{ $item['name'] }}</h3>
                                <p class="text-gray-600">Cantidad: {{ $item['quantity'] }}</p>
                                <p class="text-gray-600">Precio: S/.{{ number_format($item['price'], 2) }}</p>
                            </div>
                        </div>
                        <p class="text-lg font-bold">S/.{{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                    </div>
                @endforeach

                <div x-show="necesitaFactura" class="mt-4">
                    <div class="flex justify-between items-center text-lg font-bold">
                        <span>Subtotal:</span>
                        <span>S/.{{ number_format($subtotal, 2) }}</span>
                    </div>

                    <div class="flex justify-between items-center mt-2 text-lg font-bold">
                        <span>IGV (18%):</span>
                        <span>S/.{{ number_format($igv, 2) }}</span>
                    </div>
                </div>

                <div class="flex justify-between items-center mt-2 text-xl font-bold text-green-600">
                    <span>Total:</span>
                    <span>S/.{{ number_format($total, 2) }}</span>
                </div>

                <button
                    class="mt-4 w-full bg-green-600 text-white font-semibold py-3 rounded-lg shadow-md hover:bg-green-700 transition duration-300">
                    Confirmar Compra
                </button>
            </div>
        @else
            <p class="text-gray-600">Tu carrito está vacío.</p>
        @endif
    </div>
</div>
