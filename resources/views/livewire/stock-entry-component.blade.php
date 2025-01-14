<div
    class="{{ $menuAbierto ? 'ml-60' : 'ml-16' }} mt-16 max-w-7xl mx-auto p-6 bg-gradient-to-br from-blue-50 to-indigo-100 shadow-xl rounded-xl transition-all duration-300 ease-in-out">
    <div class="container mx-auto space-y-8">
        <!-- Mensajes de sesión -->
        @if (session()->has('message'))
            <div class="p-4 mb-4 text-green-800 bg-green-100 border-l-4 border-green-500">
                {{ session('message') }}
            </div>
        @endif

        <!-- Sección de búsqueda -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Buscar Proveedor -->
            <div>
                <label for="supplierSearch" class="block text-sm font-medium text-gray-700">Buscar Proveedor</label>
                <div class="relative mt-2">
                    <input type="text" id="supplierSearch" wire:model="supplierSearch" wire:keydown="searchSupplier"
                        placeholder="Nombre o RUC"
                        class="w-full md:w-3/4 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />

                    @if (!empty($supplierResults))
                        <ul
                            class="absolute z-10 w-full bg-white border border-gray-300 mt-1 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                            @foreach ($supplierResults as $supplier)
                                <li wire:click="selectSupplier({{ $supplier->id }})"
                                    class="px-4 py-2 cursor-pointer hover:bg-gray-100 transition">
                                    {{ $supplier->name }} ({{ $supplier->ruc }})
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    <!-- selectedSupplier Seleccionado -->
                    @if ($selectedSupplier)
                        <div class="p-4 bg-green-50 rounded-lg border border-green-200">
                            <h3 class="font-bold text-green-700">Proveedor Seleccionado:</h3>
                            <p class="text-green-600"><strong>Nombre:</strong> {{ $selectedSupplier['name'] }}</p>
                            <p class="text-green-600"><strong>DNI/RUC:</strong> {{ $selectedSupplier['ruc'] }}</p>

                        </div>
                    @endif
                </div>
            </div>


            <div>
                <!-- Selección de Moneda -->
                <div class="relative">
                    <label for="currency" class="block text-sm font-medium text-gray-700">Selecciona Moneda</label>
                    <select id="currency" wire:model="currencyn" wire:change="changeCurrency"
                        class="w-full md:w-1/2 mt-2 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="sol">Sol S/.</option>
                        <option value="dolar">Dólar $</option>
                    </select>

                    <!-- Superposición para bloquear la sección -->
                    @if ($disableInputs)
                        <div class="absolute inset-0 bg-gray-200 opacity-50 cursor-not-allowed"></div>
                    @endif
                </div>

                @if ($currency === 'sol')
                    <!-- Total Soles -->
                    <div class="mt-4 relative">
                        <label for="total_soles" class="block text-sm font-medium text-gray-700">Total en Soles
                            (S/.)</label>
                        <input type="number" id="total_soles" wire:model="total_soles"
                            class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                        @if ($disableInputs)
                            <div class="absolute inset-0 bg-gray-200 opacity-50 cursor-not-allowed"></div>
                        @endif
                    </div>
                @endif

                @if ($currency === 'dolar')
                    <!-- Total Soles -->
                    <div class="mt-4 relative">
                        <label for="total_soles" class="block text-sm font-medium text-gray-700">Total en Soles
                            (S/.)</label>
                        <input type="number" id="total_soles" wire:model="total_soles"
                            wire:change="calculateDollarValue"
                            class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                        @if ($disableInputs)
                            <div class="absolute inset-0 bg-gray-200 opacity-50 cursor-not-allowed"></div>
                        @endif
                    </div>

                    <!-- Total Dólares -->
                    <div class="mt-4 relative">
                        <label for="total_dollar" class="block text-sm font-medium text-gray-700">Total en Dólares
                            ($)</label>
                        <input type="number" id="total_dollar" wire:model="total_dollar"
                            wire:change="calculateDollarValue"
                            class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                        @if ($disableInputs)
                            <div class="absolute inset-0 bg-gray-200 opacity-50 cursor-not-allowed"></div>
                        @endif
                    </div>

                    <!-- Valor del Dólar -->
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700">Valor del Dólar:</label>
                        <span class="text-orange-600 font-bold">
                            {{ number_format($dollar_value, 2) }}
                        </span>
                    </div>
                @endif
            </div>

        </div>
        <!-- Buscar Producto -->
        <div>
            <label for="productSearch" class="block text-sm font-medium text-gray-700">Buscar Producto</label>
            <div class="relative mt-2">
                <input type="text" id="productSearch" wire:model="search" wire:keyup="searchProduct"
                    placeholder="Ingresa el nombre del producto"
                    class="w-full md:w-3/4 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />

                @if ($showlist)
                    <ul
                        class="absolute z-10 w-full bg-white border border-gray-300 mt-1 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                        @if (!empty($results))
                            @foreach ($results as $result)
                                <li wire:click="getProduct({{ $result->id }})"
                                    class="px-4 py-2 cursor-pointer hover:bg-gray-100 transition">
                                    {{ $result->name }}
                                </li>
                            @endforeach
                        @else
                            <li class="px-4 py-2 text-gray-500">No se encontraron resultados.</li>
                        @endif
                    </ul>
                @endif
            </div>
        </div>
        <!-- Tabla de Productos -->
        <div class="overflow-hidden rounded-lg shadow bg-white">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Cantidad</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Descripción</th>
                        @if ($currency === 'dolar')
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Precio $</th>
                        @endif
                        @if ($currency === 'dolar')
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Subtotal $</th>
                        @endif
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Precio S/.</th>

                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Subtotal S/.</th>

                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Acciones</th>
                    </tr>
                </thead>

                @if ($currency === 'sol')
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($products as $product)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="number" wire:model="quantities.{{ $product->id }}"
                                        wire:change="calculateOperationsSol"
                                        class="w-20 px-2 py-1 border border-gray-300 rounded-md focus:ring-indigo-500" />
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">{{ $product->name }}</td>


                                <td class="px-6 py-4 whitespace-nowrap">S/
                                    <input type="number" wire:model="pricessol.{{ $product->id }}"
                                        wire:change="calculateOperationsSol"
                                        class="w-24 px-2 py-1 border border-gray-300 rounded-md focus:ring-indigo-500" />
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    S/.{{ number_format($subtotalsol[$product->id], 2) }}

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button wire:click="removeProduct({{ $product->id }})"
                                        class="text-red-600 hover:text-red-800 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 009 2zM8 7a1 1 0 011-1h2a1 1 0 011 1v7a1 1 0 11-2 0V8H9v6a1 1 0 01-2 0V7z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                @endif

                @if ($currency === 'dolar')
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($products as $product)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="number" wire:model="quantities.{{ $product->id }}"
                                        wire:change="calculateOperationsDolar"
                                        class="w-20 px-2 py-1 border border-gray-300 rounded-md focus:ring-indigo-500" />
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $product->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">$
                                    <input type="number" wire:model="pricesdolar.{{ $product->id }}"
                                        wire:change="calculateOperationsDolar"
                                        class="w-24 px-2 py-1 border border-gray-300 rounded-md focus:ring-indigo-500" />
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">$
                                    {{ number_format($subtotaldollar[$product->id], 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    S/.{{ number_format($pricessol[$product->id], 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    S/.{{ number_format($subtotalsol[$product->id], 2) }}
                                </td>



                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button wire:click="removeProduct({{ $product->id }})"
                                        class="text-red-600 hover:text-red-800 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 009 2zM8 7a1 1 0 011-1h2a1 1 0 011 1v7a1 1 0 11-2 0V8H9v6a1 1 0 01-2 0V7z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                @endif

            </table>
        </div>

        <!-- Total -->
        <div class="flex justify-between items-center mt-6">

            <div>
                <strong>Total en Soles:</strong>
                <span class="text-green-600 font-bold">
                    S/.{{ number_format($total_soles_forsin, 2) }}
                </span>
            </div>

            @if ($currency === 'dolar')
                <div>
                    <strong>Total en Dólares:</strong>
                    <span class="text-orange-600 font-bold">
                        ${{ number_format($total_dollar_forsin, 2) }}
                    </span>
                </div>
            @endif
        </div>


        <!-- Botones de acción -->
        <div class="flex justify-end space-x-4 mt-4">
            <button wire:click="cancelStockEntry"
                class="px-6 py-2 bg-gray-500 text-white rounded-lg shadow hover:bg-gray-700 transition">
                Cancelar
            </button>
            <!-- Botón para abrir el modal -->
            <button wire:click="openConfirmationModal" class="bg-blue-500 text-white px-4 py-2 rounded">
                Guardar Entrada de Stock
            </button>
        </div>
        <!-- Modal -->
        @if ($showConfirmationModal)
            <div class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
                <div class="bg-white p-6 rounded shadow-xl">
                    <h2 class="text-lg font-bold mb-4">Confirmar Guardado</h2>
                    @if ($validationMessage)
                        <p class="text-red-600">{{ $validationMessage }}</p>
                    @endif
                    <p>¿Estás seguro de que deseas guardar esta entrada de stock?</p>
                    <div class="mt-4 flex justify-end space-x-2">
                        <button wire:click="closeConfirmationModal"
                            class="bg-gray-300 text-gray-700 px-4 py-2 rounded">Cancelar</button>
                        <button wire:click="saveStockEntry" class="bg-blue-500 text-white px-4 py-2 rounded">
                            Confirmar
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>
