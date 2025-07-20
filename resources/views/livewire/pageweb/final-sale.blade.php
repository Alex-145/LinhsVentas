<div class="container mx-auto p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

    <!-- Información del Cliente -->
    <div class="bg-white shadow-lg rounded-2xl p-6 border border-gray-100">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Información del Cliente</h2>

        <form wire:submit.prevent="submit" class="space-y-4">
            <!-- DNI + Botón -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">DNI</label>
                <div class="flex gap-2">
                    <input type="text" wire:model="dni"
                        class="flex-1 border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300 focus:outline-none"
                        required>
                    <button type="button" wire:click="searchClient"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">
                        Buscar
                    </button>
                </div>
                @if ($message)
                    <div class="mt-2 p-3 bg-red-50 border-l-4 border-red-400 text-red-800 rounded-md shadow-sm">
                        <p class="text-sm font-medium">
                            {{ $message }}
                        </p>
                    </div>
                @endif

            </div>

            <!-- Nombre -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Nombre</label>
                <input type="text" wire:model="name"
                    class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300 focus:outline-none"
                    required>
                @error('name')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Correo -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Correo</label>
                <input type="email" wire:model="email"
                    class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300 focus:outline-none"
                    required>
                @error('email')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Celular -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Celular</label>
                <input type="text" wire:model="phone_number"
                    class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300 focus:outline-none"
                    required>
                @error('phone_number')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Checkbox Factura -->
            <div class="flex items-center">
                <input type="checkbox" class="form-checkbox mr-2 text-blue-600" wire:model.live="necesitaFactura">
                <label class="text-gray-700 font-medium">Necesito Factura</label>
            </div>

            <!-- Campos RUC y Razón Social -->
            @if ($necesitaFactura)
                <div class="space-y-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">RUC</label>
                        <input type="text" wire:model="ruc"
                            class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300 focus:outline-none">
                        @error('ruc')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Razón Social</label>
                        <input type="text" wire:model="business_name"
                            class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300 focus:outline-none">
                        @error('business_name')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            @endif

            <div class="mt-6 p-4 bg-yellow-50 border-l-4 border-yellow-400 text-yellow-800 rounded-md shadow-sm">
                <p class="text-sm font-medium">
                    <strong>Importante:</strong> El pedido debe ser recogido personalmente en nuestra tienda.
                </p>
            </div>
        </form>
        <div id="custom-alert"
            class="hidden mt-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg shadow-md transition-opacity duration-300 ease-in-out">
            <p id="custom-alert-message" class="text-sm font-medium"></p>
        </div>

    </div>

    <!-- Resumen de Compra -->
    <div class="bg-white shadow-lg rounded-2xl p-6 border border-gray-100">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Resumen de tu Compra</h2>

        @if (count($cart) > 0)
            <div class="space-y-4">
                @foreach ($cart as $item)
                    <div class="flex flex-col sm:flex-row justify-between items-center border-b pb-3">
                        <div class="flex items-center">
                            <img src="{{ asset('storage/' . $item['photo_url']) }}" alt="{{ $item['name'] }}"
                                class="w-16 h-16 object-cover rounded mr-4 border">
                            <div>
                                <h3 class="font-semibold text-gray-800">{{ $item['name'] }}</h3>
                                <p class="text-gray-500 text-sm">Cantidad: {{ $item['quantity'] }}</p>
                                <p class="text-gray-500 text-sm">Precio: S/.{{ number_format($item['price'], 2) }}</p>
                            </div>
                        </div>
                        <p class="text-lg font-bold text-gray-700 mt-2 sm:mt-0">
                            S/.{{ number_format($item['price'] * $item['quantity'], 2) }}
                        </p>
                    </div>
                @endforeach

                @if ($necesitaFactura)
                    <div class="mt-2 space-y-2">
                        <div class="flex justify-between text-gray-700 font-medium">
                            <span>Subtotal:</span>
                            <span>S/.{{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-700 font-medium">
                            <span>IGV (18%):</span>
                            <span>S/.{{ number_format($igv, 2) }}</span>
                        </div>
                    </div>
                @endif

                <div class="flex justify-between items-center mt-2 text-xl font-bold text-green-600 border-t pt-4">
                    <span>Total:</span>
                    <span>S/.{{ number_format($total, 2) }}</span>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 mt-6">
                    <button type="button" wire:click="generarProforma"
                        class="w-full bg-indigo-600 text-white font-semibold py-3 rounded-lg shadow-md hover:bg-indigo-700 transition disabled:opacity-50"
                        @disabled($cotizacionGenerada)>
                        Solo Cotización
                    </button>


                    <a href="{{ route('wproducts.index') }}"
                        class="w-full text-center bg-gray-200 text-gray-800 font-semibold py-3 rounded-lg shadow hover:bg-gray-300 transition">
                        Seguir Comprando
                    </a>
                </div>

                <button wire:click="confirmarCompra" wire:loading.attr="disabled" wire:target="confirmarCompra"
                    class="mt-6 w-full bg-green-600 text-white font-semibold py-3 rounded-lg shadow-md hover:bg-green-700 transition">
                    <span wire:loading.remove wire:target="confirmarCompra">Confirmar Compra</span>
                    <span wire:loading wire:target="confirmarCompra">Procesando...</span>
                </button>


            </div>
        @else
            <p class="text-gray-600">Tu carrito está vacío.</p>
        @endif
    </div>
    <div x-data="{ open: @entangle('mostrarModalCodigo') }" x-show="open"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow p-6 w-full max-w-md relative">

            {{-- Botón de cerrar --}}
            <button type="button"
                class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xl font-bold focus:outline-none"
                x-on:click="open = false">
                &times;
            </button>

            <h2 class="text-xl font-bold mb-4">Verifica tu compra</h2>

            <p class="mb-4">
                Hemos enviado un código a tu correo: <strong>{{ $email }}</strong>. Ingrésalo para continuar.
            </p>

            {{-- Mensajes flash --}}
            @if (session()->has('success'))
                <div class="mt-4 p-3 bg-green-100 border-l-4 border-green-500 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @elseif (session()->has('error'))
                <div class="mt-4 p-3 bg-red-100 border-l-4 border-red-500 text-red-800 rounded">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Campo para ingresar código --}}
            <input type="text" wire:model="codigoIngresado" class="w-full border border-gray-300 rounded p-2 mb-4"
                placeholder="Ingrese el código recibido">

            {{-- Botón para verificar código --}}
            <button wire:click="verificarCodigo"
                class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 mb-3">
                Verificar Código
            </button>

            {{-- Botón para reenviar código --}}
            <button wire:click="reenviarCodigo"
                class="mt-3 w-full bg-gray-200 text-gray-700 py-2 rounded hover:bg-gray-300">
                Volver a enviar código
            </button>
        </div>
    </div>

    <div x-data="{ open: @entangle('mostrarModalVerificacionPedido') }" x-show="open"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow p-6 w-full max-w-2xl">
            <h2 class="text-xl font-bold mb-4">Verificar Pedido</h2>

            @livewire('pageweb.verificar-pedido', ['codigo' => $codigoGenerado])

            <button class="mt-4 bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300" @click="open = false">
                Cerrar
            </button>
        </div>
    </div>
    @if ($descargaExitosa)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white w-full max-w-sm rounded-xl shadow-lg p-6 text-center">
                <h3 class="text-xl font-semibold text-green-700 mb-4">¡Cotización Generada!</h3>
                <p class="text-gray-700 mb-6">Se ha descargado su cotización correctamente.</p>
                <button wire:click="$set('descargaExitosa', false)"
                    class="px-6 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition">
                    OK
                </button>
            </div>
        </div>
    @endif


</div>

<!-- Script de validación JS -->
<script>
    function mostrarAlerta(mensaje) {
        const alertBox = document.getElementById("custom-alert");
        const alertMessage = document.getElementById("custom-alert-message");

        alertMessage.textContent = mensaje;
        alertBox.classList.remove("hidden");

        // Ocultar automáticamente después de 5 segundos
        setTimeout(() => {
            alertBox.classList.add("hidden");
        }, 5000);
    }

    function validarAntesDeEnviar() {
        const dni = document.querySelector('input[wire\\:model="dni"]').value.trim();
        const name = document.querySelector('input[wire\\:model="name"]').value.trim();
        const email = document.querySelector('input[wire\\:model="email"]').value.trim();
        const phone = document.querySelector('input[wire\\:model="phone_number"]').value.trim();
        const necesitaFactura = @json($necesitaFactura);

        if (!dni || !name || !email || !phone) {
            mostrarAlerta('Por favor, complete todos los datos del cliente.');
            return false;
        }
        if (necesitaFactura &&
            (!document.querySelector('input[wire\\:model="ruc"]').value.trim() ||
                !document.querySelector('input[wire\\:model="business_name"]').value.trim())
        ) {
            mostrarAlerta('Por favor, complete RUC y Razón Social.');
            return false;
        }

        // Si todo está bien, ocultamos la alerta por si estaba visible antes
        document.getElementById("custom-alert").classList.add("hidden");
        return true;
    }
</script>
