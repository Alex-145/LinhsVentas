<div class="mt-4">
    <button wire:click="$set('mostrarModal', true)"
        class="inline-block bg-white text-blue-700 border border-blue-700 hover:bg-blue-700 hover:text-white font-semibold py-3 px-8 rounded-full shadow-xl transition-all duration-300 transform hover:scale-105">
        📦 Coloca tu código de pedido o seguimiento
    </button>

    @if ($mostrarModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
                <h2 class="text-xl font-bold mb-4 text-center text-blue-700">Seguimiento de Pedido</h2>

                @if (session()->has('error'))
                    <div class="bg-red-100 text-red-800 p-2 rounded mb-4 text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                <input type="text" wire:model.defer="codigoIngresado"
                    class="w-full border border-gray-300 rounded p-2 mb-4 text-black"
                    placeholder="Ingrese el código de pedido">

                <div class="flex justify-between gap-4">
                    <button wire:click="verificarCodigo"
                        class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
                        Ver Pedido
                    </button>
                    <button wire:click="$set('mostrarModal', false)"
                        class="w-full bg-gray-300 text-black py-2 rounded hover:bg-gray-400 transition">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
