<div>
    <div class="container mx-auto space-y-6">
        <!-- Resumen de Compras -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Tarjeta de Compras en Soles -->
            <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 rounded-xl shadow-md border border-yellow-200 p-5">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 mr-4">
                        <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-yellow-800">Compras Totales</h3>
                        <p class="text-2xl font-bold text-yellow-900">S/.{{ number_format($totalExpenses, 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Tarjeta de Compras en Dólares -->
            <div
                class="bg-gradient-to-r from-purple-50 to-purple-100 rounded-xl shadow-md border border-purple-200 p-5">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 mr-4">
                        <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-purple-800">Compras Totales</h3>
                        <p class="text-2xl font-bold text-purple-900">${{ number_format($totalExpensesInDollars, 2) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Barra de Búsqueda y Filtros -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
            <div class="p-5">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div class="flex-1">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" wire:model="search" wire:keydown.debounce.300ms="loadStockEntries"
                                placeholder="Buscar por nombre de proveedor"
                                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200">
                        </div>
                    </div>
                    <button wire:click="openModal"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Filtros
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal de Filtros -->
        @if ($isOpen)
            @include('livewire.fiterentries')
        @endif

        <!-- Listado de Entradas de Stock -->
        <div class="space-y-4">
            @forelse ($stockEntries as $stockEntrie)
                <div
                    class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 transition duration-200 hover:shadow-lg">
                    <!-- Encabezado de la Entrada -->
                    <div class="p-5 border-b border-gray-200 bg-gray-50">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">
                                    Entrada #{{ $stockEntrie->id }} - {{ $stockEntrie->supplier->name }}
                                </h3>
                                <p class="text-sm text-gray-500 mt-1">
                                    {{ \Carbon\Carbon::parse($stockEntrie->reception_date)->format('d/m/Y') }} •
                                    Registrado por: {{ $stockEntrie->user->name }}
                                </p>
                            </div>
                            <div class="mt-3 md:mt-0 flex items-center space-x-3">
                                <span
                                    class="px-3 py-1 rounded-full text-sm font-medium
                                    {{ $stockEntrie->currency === 'dolar' ? 'bg-purple-100 text-purple-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $stockEntrie->currency === 'dolar' ? 'Dólares' : 'Soles' }}
                                </span>
                                <button wire:click="selectStockEntry({{ $stockEntrie->id }})"
                                    class="text-indigo-600 hover:text-indigo-900 transition duration-150">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="{{ $selectedStockEntry === $stockEntrie->id ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Resumen de Totales -->
                    <div class="p-5 border-b border-gray-200">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @if ($stockEntrie->currency === 'dolar')
                                <div class="bg-blue-50 p-3 rounded-lg">
                                    <p class="text-sm font-medium text-blue-800">Valor del Dólar</p>
                                    <p class="text-lg font-bold text-blue-900">
                                        ${{ number_format($stockEntrie->dollar_value, 2) }}</p>
                                </div>
                                <div class="bg-green-50 p-3 rounded-lg">
                                    <p class="text-sm font-medium text-green-800">Total en Soles</p>
                                    <p class="text-lg font-bold text-green-900">
                                        S/.{{ number_format($stockEntrie->total_soles, 2) }}</p>
                                </div>
                                <div class="bg-purple-50 p-3 rounded-lg">
                                    <p class="text-sm font-medium text-purple-800">Total en Dólares</p>
                                    <p class="text-lg font-bold text-purple-900">
                                        ${{ number_format($stockEntrie->total_dollar, 2) }}</p>
                                </div>
                            @else
                                <div class="bg-green-50 p-3 rounded-lg col-span-2">
                                    <p class="text-sm font-medium text-green-800">Total en Soles</p>
                                    <p class="text-lg font-bold text-green-900">
                                        S/.{{ number_format($stockEntrie->total_soles, 2) }}</p>
                                </div>
                            @endif
                            <div class="flex items-center justify-end">
                                <button wire:click="confirmDelete({{ $stockEntrie->id }})"
                                    class="text-red-600 hover:text-red-900 transition duration-150 p-2 rounded-full hover:bg-red-50"
                                    title="Eliminar entrada">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Detalles de la Entrada (se muestra al hacer clic) -->
                    @if ($selectedStockEntry === $stockEntrie->id)
                        <div class="p-5 bg-gray-50">
                            <h4 class="text-md font-medium text-gray-900 mb-4 flex items-center">
                                <svg class="h-5 w-5 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5h6a2 2 0 012 2v10a2 2 0 01-2 2H9a2 2 0 01-2-2V7a2 2 0 012-2z" />
                                </svg>
                                Detalles de la Entrada
                            </h4>

                            @if ($stockEntrie->stockEntryDetails && $stockEntrie->stockEntryDetails->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-100">
                                            <tr>
                                                <th
                                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Producto</th>
                                                <th
                                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Cantidad</th>
                                                @if ($stockEntrie->currency === 'dolar')
                                                    <th
                                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Precio ($)</th>
                                                    <th
                                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Subtotal ($)</th>
                                                @endif
                                                <th
                                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Precio (S/.)</th>
                                                <th
                                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Subtotal (S/.)</th>
                                                <th
                                                    class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach ($stockEntrie->stockEntryDetails as $detail)
                                                <tr class="hover:bg-gray-50 transition duration-150">
                                                    <td class="px-4 py-3 whitespace-nowrap">
                                                        <div class="flex items-center">
                                                            <div
                                                                class="flex-shrink-0 h-10 w-10 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                                                                <svg class="h-6 w-6 text-indigo-500" fill="none"
                                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                                </svg>
                                                            </div>
                                                            <div>
                                                                <div class="text-sm font-medium text-gray-900">
                                                                    {{ $detail->product->name }}</div>
                                                                <div class="text-sm text-gray-500">SKU:
                                                                    {{ $detail->product->sku ?? 'N/A' }}</div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                                        {{ $detail->quantity }}</td>
                                                    @if ($stockEntrie->currency === 'dolar')
                                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                                            ${{ number_format($detail->purchase_pricedolar, 2) }}</td>
                                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                                            ${{ number_format($detail->subtotaldolar, 2) }}</td>
                                                    @endif
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                                        S/.{{ number_format($detail->purchase_pricesol, 2) }}</td>
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                                        S/.{{ number_format($detail->subtotalsol, 2) }}</td>
                                                    <td
                                                        class="px-4 py-3 whitespace-nowrap text-right text-sm font-medium">
                                                        <button wire:click="confirmDeleteDetail({{ $detail->id }})"
                                                            class="text-red-600 hover:text-red-900 transition duration-150 p-1 rounded-full hover:bg-red-50"
                                                            title="Eliminar detalle">
                                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-8 bg-white rounded-lg border border-dashed border-gray-300">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No hay detalles disponibles</h3>
                                    <p class="mt-1 text-sm text-gray-500">No se encontraron productos en esta entrada
                                        de stock.</p>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            @empty
                <div class="text-center py-12 bg-white rounded-xl shadow-md border border-gray-100">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-gray-900">No hay entradas de stock registradas</h3>
                    <p class="mt-1 text-sm text-gray-500">No se encontraron entradas de stock con los criterios
                        actuales.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Modal de Confirmación para Eliminar Detalle -->
    <div x-data="{ open: @entangle('showDeleteConfirmationde') }" x-show="open" x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" class="fixed z-50 inset-0 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Eliminar detalle</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">¿Estás seguro de que deseas eliminar este detalle?
                                    Esta acción no se puede deshacer.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button wire:click="deleteDetailStockEntry({{ $detailToDelete }})" type="button"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm transition duration-150">
                        Eliminar
                    </button>
                    <button wire:click="$set('showDeleteConfirmationde', false)" type="button"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition duration-150">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmación para Eliminar Entrada -->
    @if ($showDeleteConfirmation)
        <div class="fixed z-50 inset-0 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Eliminar entrada de stock</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">¿Estás seguro de que deseas eliminar esta entrada
                                        de stock completa? Esta acción no se puede deshacer y afectará el inventario.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button wire:click="deleteStockEntry" type="button"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm transition duration-150">
                            Sí, eliminar
                        </button>
                        <button wire:click="cancelAction" type="button"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition duration-150">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@push('styles')
    <style>
        .animate-fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .transition-colors {
            transition-property: background-color, border-color, color, fill, stroke;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }
    </style>
@endpush
{{--
    @if ($sales->isNotEmpty())
        <button wire:click="calculateTithe"
            class="mt-8 bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-md transition duration-300 ease-in-out transform hover:scale-105">
            Calcular Diezmo
        </button>

        @if ($tithe > 0)
            <div class="mt-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                <p class="font-bold">El diezmo calculado es: {{ number_format($tithe, 2) }}</p>
            </div>
        @endif
    @endif

    @if ($tithe > 0)
        <div class="fixed inset-0 flex items-center justify-center bg-gray-700 bg-opacity-50 z-50">
            <div class="bg-white p-8 rounded-lg shadow-xl">
                <h2 class="text-2xl font-bold mb-4">Diezmo Calculado</h2>
                <p class="text-3xl font-semibold text-green-600">{{ number_format($tithe, 2) }}</p>
                <div class="flex justify-end mt-6">
                    <button wire:click="$set('tithe', 0)"
                        class="bg-indigo-500 hover:bg-indigo-600 text-white px-6 py-2 rounded-md transition duration-300 ease-in-out transform hover:scale-105">Cerrar</button>
                </div>
            </div>
        </div>
    @endif

    @if ($selectedClient)
        <div class="fixed inset-0 flex items-center justify-center bg-gray-700 bg-opacity-50 z-50">
            <div class="bg-white p-8 rounded-lg shadow-xl">
                <h2 class="text-2xl font-bold mb-4">Información del Cliente</h2>
                <p><strong>Nombre:</strong> {{ $selectedClient['name'] }}</p>
                <p><strong>DNI/RUC:</strong> {{ $selectedClient['dni_ruc'] }}</p>
                <p><strong>Razón Social:</strong> {{ $selectedClient['business_name'] }}</p>
                <p><strong>Teléfono:</strong> {{ $selectedClient['phone_number'] }}</p>
                <div class="flex justify-end mt-6">
                    <button wire:click="$set('selectedClient', null)"
                        class="bg-indigo-500 hover:bg-indigo-600 text-white px-6 py-2 rounded-md transition duration-300 ease-in-out transform hover:scale-105">Cerrar</button>
                </div>
            </div>
        </div>
    @endif --}}
