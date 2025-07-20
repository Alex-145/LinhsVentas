<div class="{{ $menuAbierto ? 'ml-60' : 'ml-0' }} mt-16 max-w-7xl mx-auto p-6 transition-all duration-300 ease-in-out">
    <div class="container mx-auto space-y-6">
        <!-- Notificación -->
        @if (session()->has('message'))
            <div
                class="p-4 mb-4 text-green-800 bg-green-100 border-l-4 border-green-500 rounded-lg shadow-sm animate-fade-in">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ session('message') }}
                </div>
            </div>
        @endif

        <!-- Tarjeta de Proveedor y Moneda -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Tarjeta de Proveedor -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                <div class="p-5 bg-gradient-to-r from-blue-500 to-indigo-600">
                    <h3 class="text-lg font-semibold text-white">Información del Proveedor</h3>
                </div>
                <div class="p-5">
                    <div class="mb-4">
                        <label for="supplierSearch" class="block text-sm font-medium text-gray-700 mb-1">Buscar
                            Proveedor</label>
                        <div class="relative">
                            <input type="text" id="supplierSearch" wire:model="supplierSearch"
                                wire:keydown="searchSupplier" placeholder="Nombre o RUC"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200" />
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>

                        @if (!empty($supplierResults))
                            <ul
                                class="absolute z-10 mt-1 w-full max-w-md bg-white border border-gray-200 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                                @foreach ($supplierResults as $supplier)
                                    <li wire:click="selectSupplier({{ $supplier->id }})"
                                        class="px-4 py-3 cursor-pointer hover:bg-indigo-50 transition duration-150 flex justify-between items-center">
                                        <div>
                                            <span class="font-medium">{{ $supplier->name }}</span>
                                            <span class="text-gray-500 text-sm block">{{ $supplier->ruc }}</span>
                                        </div>
                                        <svg class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    @if ($selectedSupplier)
                        <div class="mt-4 p-4 bg-green-50 rounded-lg border border-green-200 shadow-inner">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 pt-0.5">
                                    <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-green-800">Proveedor Seleccionado</h3>
                                    <div class="mt-1 text-sm text-green-700">
                                        <p><span class="font-semibold">Nombre:</span> {{ $selectedSupplier['name'] }}
                                        </p>
                                        <p><span class="font-semibold">RUC:</span> {{ $selectedSupplier['ruc'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Tarjeta de Moneda y Totales -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                <div class="p-5 bg-gradient-to-r from-purple-500 to-indigo-600">
                    <h3 class="text-lg font-semibold text-white">Moneda y Totales</h3>
                </div>
                <div class="p-5">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Moneda de Compra</label>
                        <div class="flex items-center space-x-4">
                            <button wire:click="changeCurrency" type="button"
                                class="{{ $currency === 'sol' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700' }} px-4 py-2 rounded-lg shadow-sm transition duration-200 flex items-center">
                                <span class="mr-2">S/.</span> Soles
                            </button>
                            <button wire:click="changeCurrency" type="button"
                                class="{{ $currency === 'dolar' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700' }} px-4 py-2 rounded-lg shadow-sm transition duration-200 flex items-center">
                                <span class="mr-2">$</span> Dólares
                            </button>
                        </div>
                    </div>

                    @if ($currency === 'dolar')
                        <div class="space-y-3">
                            <div>
                                <label for="total_dollar" class="block text-sm font-medium text-gray-700">Total en
                                    Dólares</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">$</span>
                                    </div>
                                    <input type="number" id="total_dollar" wire:model="total_dollar"
                                        wire:change="calculateDollarValue"
                                        class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 py-2 border-gray-300 rounded-lg shadow-sm"
                                        placeholder="0.00">
                                </div>
                            </div>
                            <div>
                                <label for="total_soles" class="block text-sm font-medium text-gray-700">Total en
                                    Soles</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">S/.</span>
                                    </div>
                                    <input type="number" id="total_soles" wire:model="total_soles"
                                        wire:change="calculateDollarValue"
                                        class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-9 pr-12 py-2 border-gray-300 rounded-lg shadow-sm"
                                        placeholder="0.00">
                                </div>
                            </div>
                            <div class="p-3 bg-blue-50 rounded-lg">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-700">Tipo de Cambio:</span>
                                    <span
                                        class="text-lg font-bold text-blue-600">{{ number_format($dollar_value, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    @else
                        <div>
                            <label for="total_soles" class="block text-sm font-medium text-gray-700">Total en
                                Soles</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">S/.</span>
                                </div>
                                <input type="number" id="total_soles" wire:model="total_soles"
                                    class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-9 pr-12 py-2 border-gray-300 rounded-lg shadow-sm"
                                    placeholder="0.00">
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Buscador de Productos -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
            <div class="p-5 bg-gradient-to-r from-cyan-500 to-blue-600">
                <h3 class="text-lg font-semibold text-white">Agregar Productos</h3>
            </div>
            <div class="p-5">
                <label for="productSearch" class="block text-sm font-medium text-gray-700 mb-1">Buscar
                    Producto</label>
                <div class="relative">
                    <input type="text" id="productSearch" wire:model="search" wire:keyup="searchProduct"
                        placeholder="Ingresa el nombre del producto"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200" />
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>

                @if ($showlist)
                    <ul
                        class="absolute z-10 mt-1 w-full max-w-2xl bg-white border border-gray-200 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                        @if (!empty($results))
                            @foreach ($results as $result)
                                <li wire:click="getProduct({{ $result->id }})"
                                    class="px-4 py-3 cursor-pointer hover:bg-indigo-50 transition duration-150 flex justify-between items-center">
                                    <span>{{ $result->name }}</span>
                                    <span class="text-xs bg-indigo-100 text-indigo-800 px-2 py-1 rounded-full">SKU:
                                        {{ $result->sku ?? 'N/A' }}</span>
                                </li>
                            @endforeach
                        @else
                            <li class="px-4 py-3 text-gray-500">No se encontraron productos</li>
                        @endif
                    </ul>
                @endif
            </div>
        </div>

        <!-- Tabla de Productos -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Cantidad</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Producto</th>
                            @if ($currency === 'dolar')
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Precio Unit. ($)</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Subtotal ($)</th>
                            @endif
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Precio Unit. (S/.)</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Subtotal (S/.)</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($products as $product)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="number" wire:model="quantities.{{ $product->id }}"
                                        wire:change="{{ $currency === 'sol' ? 'calculateOperationsSol' : 'calculateOperationsDolar' }}"
                                        min="1"
                                        class="w-20 px-2 py-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-center" />
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="flex-shrink-0 h-10 w-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                                            <svg class="h-6 w-6 text-indigo-500" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                            <div class="text-sm text-gray-500">SKU: {{ $product->sku ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                </td>
                                @if ($currency === 'dolar')
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="relative rounded-md shadow-sm">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 text-sm">$</span>
                                            </div>
                                            <input type="number" wire:model="pricesdolar.{{ $product->id }}"
                                                wire:change="calculateOperationsDolar"
                                                class="block w-full pl-7 pr-12 py-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        ${{ number_format($subtotaldollar[$product->id], 2) }}
                                    </td>
                                @endif
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="relative rounded-md shadow-sm">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 text-sm">S/.</span>
                                        </div>
                                        <input type="number" wire:model="pricessol.{{ $product->id }}"
                                            wire:change="{{ $currency === 'sol' ? 'calculateOperationsSol' : 'calculateOperationsDolar' }}"
                                            class="block w-full pl-9 pr-12 py-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    S/.{{ number_format($subtotalsol[$product->id], 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button wire:click="removeProduct({{ $product->id }})"
                                        class="text-red-600 hover:text-red-900 transition duration-150 p-1 rounded-full hover:bg-red-50">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $currency === 'dolar' ? 6 : 5 }}"
                                    class="px-6 py-4 text-center text-sm text-gray-500">
                                    <div class="flex flex-col items-center justify-center py-8">
                                        <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900">No hay productos agregados
                                        </h3>
                                        <p class="mt-1 text-sm text-gray-500">Busca y selecciona productos para
                                            agregarlos a la entrada de stock.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="{{ $currency === 'dolar' ? 3 : 2 }}"
                                class="px-6 py-3 text-right text-sm font-medium text-gray-500 uppercase tracking-wider">
                                Totales</td>
                            @if ($currency === 'dolar')
                                <td class="px-6 py-3 text-sm font-medium text-gray-900">
                                    ${{ number_format($total_dollar_forsin, 2) }}
                                </td>
                            @endif
                            <td class="px-6 py-3 text-sm font-medium text-gray-900">
                                S/.{{ number_format($total_soles_forsin, 2) }}
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Botones de Acción -->
        <div class="flex justify-between items-center mt-6">
            <div class="flex space-x-3">
                <button wire:click="cancelStockEntry"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">
                    <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Cancelar
                </button>
            </div>
            <div class="flex space-x-3">
                <button wire:click="openConfirmationModal"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                    {{ empty($products) ? 'disabled' : '' }}>
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Guardar Entrada
                </button>
            </div>
        </div>

        <!-- Modal de Confirmación -->
        @if ($showConfirmationModal)
            <div class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
                aria-modal="true">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
                        wire:click="closeConfirmationModal"></div>

                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                    <div
                        class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div
                                    class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                        Confirmar Entrada de Stock
                                    </h3>
                                    <div class="mt-2">
                                        @if ($validationMessage)
                                            <p class="text-sm text-red-600 bg-red-50 p-3 rounded-lg">
                                                {{ $validationMessage }}</p>
                                        @else
                                            <p class="text-sm text-gray-500">
                                                ¿Estás seguro de que deseas registrar esta entrada de stock? Esta acción
                                                no se puede deshacer.
                                            </p>
                                            <div class="mt-4 space-y-2">
                                                <div class="flex justify-between">
                                                    <span class="text-sm font-medium text-gray-500">Proveedor:</span>
                                                    <span
                                                        class="text-sm text-gray-900">{{ $selectedSupplier ? $selectedSupplier->name : 'No seleccionado' }}</span>
                                                </div>
                                                <div class="flex justify-between">
                                                    <span class="text-sm font-medium text-gray-500">Productos:</span>
                                                    <span class="text-sm text-gray-900">{{ count($products) }}</span>
                                                </div>
                                                @if ($currency === 'dolar')
                                                    <div class="flex justify-between">
                                                        <span class="text-sm font-medium text-gray-500">Total en
                                                            Dólares:</span>
                                                        <span
                                                            class="text-sm font-medium text-gray-900">${{ number_format($total_dollar_forsin, 2) }}</span>
                                                    </div>
                                                @endif
                                                <div class="flex justify-between">
                                                    <span class="text-sm font-medium text-gray-500">Total en
                                                        Soles:</span>
                                                    <span
                                                        class="text-sm font-medium text-gray-900">S/.{{ number_format($total_soles_forsin, 2) }}</span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button wire:click="saveStockEntry" type="button"
                                class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm transition duration-200">
                                Confirmar
                            </button>
                            <button wire:click="closeConfirmationModal" type="button"
                                class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition duration-200">
                                Cancelar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
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

        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }
    </style>
@endpush
