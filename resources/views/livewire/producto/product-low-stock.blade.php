<div
    class="transition-all duration-300 ease-in-out mt-16 max-w-full sm:max-w-7xl mx-auto p-6 bg-gradient-to-br from-blue-50 to-indigo-100 shadow-xl rounded-xl {{ $menuAbierto ? 'ml-60' : 'ml-0' }}">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Productos con Bajo Inventario</h1>
        <button wire:click="toggleModal"
            class="flex items-center gap-2 px-4 py-2 bg-indigo-500 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-600 transition-all">
            Ver Lista
        </button>
    </div>

    <!-- Tabla de productos -->
    <table class="table-auto w-full border-collapse bg-white rounded-lg shadow-md overflow-hidden">
        <thead>
            <tr class="bg-indigo-500 text-white">
                <th class="px-4 py-2 text-left font-medium">Nombre</th>
                <th class="px-4 py-2 text-left font-medium">Stock</th>
                <th class="px-4 py-2 text-center font-medium">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                <tr class="border-t border-gray-200 hover:bg-indigo-50 transition-colors">
                    <td class="px-4 py-3 text-gray-700">{{ $product->name }}</td>
                    <td class="px-4 py-3 text-gray-700">{{ $product->stock }}</td>
                    <td class="px-4 py-3 text-center">
                        <button wire:click="toggleProduct({{ $product->id }})"
                            class="px-4 py-2 font-semibold rounded-lg shadow-md transition-all
                            {{ in_array($product->id, $selectedProducts) ? 'bg-red-500 hover:bg-red-600' : 'bg-indigo-500 hover:bg-indigo-600' }}">
                            {{ in_array($product->id, $selectedProducts) ? 'Sacar de la Lista' : 'Añadir a la Lista' }}
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center py-4 text-gray-500">No hay productos con bajo inventario.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Botón para obtener predicciones -->
    <div class="mt-6">
        <button wire:click="obtenerPredicciones"
            class="px-6 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition-all">
            Actualizar Predicciones
        </button>
    </div>

    <!-- Mostrar predicciones -->
    <!-- Mostrar predicciones -->
    <!-- Mostrar predicciones con estilo oscuro compacto -->
    <div
        class="mt-4 bg-gradient-to-br from-gray-900 to-gray-800 p-4 rounded-lg shadow-lg max-h-56 overflow-auto text-cyan-300 font-mono text-xs leading-snug">
        <h2 class="text-lg font-bold mb-3 text-cyan-400 border-b border-cyan-600 pb-1 tracking-wider">Predicciones de
            Demanda</h2>
        @if (count($predicciones) > 0)
            <ul class="space-y-2">
                @foreach ($predicciones as $prediccion)
                    <li
                        class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1 sm:gap-3 border-b border-cyan-700 pb-2">
                        <div>
                            <span class="font-semibold">Cliente:</span> {{ $prediccion['cliente_nombre'] }}
                            <span class="text-gray-500">(ID: {{ $prediccion['cliente_id'] }})</span><br>
                            <span class="font-semibold">Producto:</span> {{ $prediccion['producto_nombre'] }}
                            <span class="text-gray-500">(ID: {{ $prediccion['producto_id'] }})</span><br>
                            <span class="font-semibold">Próxima compra estimada:</span>
                            {{ $prediccion['proxima_compra_estimada'] }}<br>
                            <span class="font-semibold">Fecha publicidad:</span> {{ $prediccion['fecha_publicidad'] }}
                        </div>
                        <button wire:click="enviarCorreo({{ $prediccion['cliente_id'] }})"
                            class="mt-2 sm:mt-0 px-3 py-1 bg-green-600 text-black font-semibold rounded hover:bg-green-700 transition-all text-xs">
                            Enviar Correo
                        </button>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-600 italic">No hay predicciones disponibles.</p>
        @endif
    </div>



    <!-- Modal -->
    <div x-data="{ open: @entangle('modalAbierto') }" x-show="open"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white w-1/2 p-6 rounded-lg shadow-lg">
            <h2 class="text-lg font-bold mb-4">Productos en la Lista</h2>
            <ul class="space-y-2">
                @forelse ($selectedProductsDetails as $selectedProduct)
                    <li class="flex justify-between items-center border-b pb-2">
                        <span>{{ $selectedProduct->name }}</span>
                        <button wire:click="toggleProduct({{ $selectedProduct->id }})"
                            class="text-red-500 hover:underline">Sacar</button>
                    </li>
                @empty
                    <li class="text-gray-500">No hay productos en la lista.</li>
                @endforelse
            </ul>

            <!-- Botón de Exportar -->
            @if (count($selectedProductsDetails) > 0)
                <button wire:click="exportPdf"
                    class="mt-4 px-4 py-2 bg-green-500 text-white rounded-lg shadow-md hover:bg-green-600">
                    Exportar en PDF
                </button>
            @endif

            <button @click="open = false"
                class="mt-4 px-4 py-2 bg-indigo-500 text-white rounded-lg shadow-md hover:bg-indigo-600">Cerrar</button>
        </div>
    </div>

</div>
