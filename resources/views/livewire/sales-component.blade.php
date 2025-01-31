<div
    class="{{ $menuAbierto ? 'ml-60' : 'ml-0' }} mt-16 max-w-7xl mx-auto p-6 bg-gradient-to-br from-blue-50 to-indigo-100 shadow-xl rounded-xl transition-all duration-300 ease-in-out">
    <div class="container mx-auto space-y-8">
        @if (session()->has('message'))
            <div class="p-4 mb-4 text-green-800 bg-green-100 border-l-4 border-green-500">
                {{ session('message') }}
            </div>
        @endif

        <!-- Sección de búsqueda -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Buscar Cliente -->
            <div>
                <label for="clientSearch" class="block text-sm font-medium text-gray-700">Buscar Cliente</label>
                <div class="relative mt-2">
                    <input type="text" id="clientSearch" wire:model="clientSearch" wire:keydown="searchClient"
                        placeholder="Nombre, DNI/RUC o Razón Social"
                        class="w-full md:w-3/4 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />

                    @if (!empty($clientResults))
                        <ul
                            class="absolute z-10 w-full bg-white border border-gray-300 mt-1 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                            @foreach ($clientResults as $client)
                                <li wire:click="selectClient({{ $client->id }})"
                                    class="px-4 py-2 cursor-pointer hover:bg-gray-100 transition">
                                    {{ $client->name }} ({{ $client->dni_ruc }})
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>



            <!-- Estado de Factura -->
            <div>
                <h3 class="text-sm font-medium text-gray-700">Estado de la Factura</h3>
                <div class="flex space-x-8 mt-2">
                    <label class="inline-flex items-center">
                        <input type="radio" id="pendiente_facturacion" wire:model="status_fac"
                            value="pendiente_facturacion" class="form-radio text-indigo-600" />
                        <span class="ml-2 text-gray-700">Para Facturar</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" id="no_aplicable" wire:model="status_fac" value="no_aplicable"
                            class="form-radio text-indigo-600" />
                        <span class="ml-2 text-gray-700">Sin Factura</span>
                    </label>
                </div>
            </div>


            <!-- Cliente Seleccionado -->
            @if ($selectedClient)
                <div class="p-4 bg-green-50 rounded-lg border border-green-200">
                    <h3 class="font-bold text-green-700">Cliente Seleccionado:</h3>
                    <p class="text-green-600"><strong>Nombre:</strong> {{ $selectedClient['name'] }}</p>
                    <p class="text-green-600"><strong>DNI/RUC:</strong> {{ $selectedClient['dni_ruc'] }}</p>
                    <p class="text-green-600"><strong>Razón Social:</strong>
                        {{ $selectedClient['business_name'] ?? 'N/A' }}
                    </p>
                </div>
            @endif
            <!-- Buscar Producto -->
        </div>


        <div class="flex space-x-4">
            <!-- Buscador de Productos -->
            <div class="w-1/2">
                <label for="productSearch" class="block text-sm font-medium text-gray-700">Buscar Producto</label>
                <div class="relative mt-2">
                    <input type="text" id="productSearch" wire:model="search" wire:keyup="searchProduct"
                        placeholder="Ingresa el nombre del producto"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />

                    @if ($showlist)
                        <ul
                            class="absolute z-10 w-full bg-white border border-gray-300 mt-1 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                            @if (!empty($resultsProduct))
                                @foreach ($resultsProduct as $resultsProduct)
                                    <li wire:click="getProduct({{ $resultsProduct->id }})"
                                        class="px-4 py-2 cursor-pointer hover:bg-gray-100 transition">
                                        {{ $resultsProduct->name }}
                                    </li>
                                @endforeach
                            @else
                                <li class="px-4 py-2 text-gray-500">No se encontraron resultados.</li>
                            @endif
                        </ul>
                    @endif
                </div>
            </div>

            <!-- Buscador de Servicios -->
            <div class="w-1/2">
                <label for="serviceSearch" class="block text-sm font-medium text-gray-700">Buscar Servicio</label>
                <div class="relative mt-2">
                    <input type="text" id="serviceSearch" wire:model="servicobuscar" wire:keyup="searchService"
                        placeholder="Ingresa el nombre del servicio"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />

                    @if ($serviceshowlist)
                        <ul
                            class="absolute z-10 w-full bg-white border border-gray-300 mt-1 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                            @if (!empty($resultsService))
                                @foreach ($resultsService as $resultsService)
                                    <li wire:click="getService({{ $resultsService->id }})"
                                        class="px-4 py-2 cursor-pointer hover:bg-gray-100 transition">
                                        {{ $resultsService->name }}
                                    </li>
                                @endforeach
                            @else
                                <li class="px-4 py-2 text-gray-500">No se encontraron resultados.</li>
                            @endif
                        </ul>
                    @endif
                </div>
            </div>
        </div>



        <!-- Tabla de Productos -->
        <div class="overflow-hidden rounded-lg shadow bg-white">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Cantidad</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Descripción</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Precio</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Subtotal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Utilidad</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <!-- Mostrar productos -->
                    @foreach ($products as $product)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="number" wire:model="productQuantities.{{ $product->id }}"
                                    wire:change="calculateTotal"
                                    class="w-20 px-2 py-1 border border-gray-300 rounded-md focus:ring-indigo-500" />
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $product->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">S/.
                                <input type="number" wire:model="productPrices.{{ $product->id }}"
                                    wire:change="calculateTotal"
                                    class="w-24 px-2 py-1 border border-gray-300 rounded-md focus:ring-indigo-500" />
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">S/
                                {{ number_format(
                                    ((float) ($productPrices[$product->id] ?? $product->sale_price)) * ((int) ($productQuantities[$product->id] ?? 0)),
                                    2
                                ) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">S/
                                {{ number_format($this->calculateProductUtilidad($product), 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button wire:click="removeProduct({{ $product->id }})"
                                    class="text-red-600 hover:text-red-800 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @endforeach

                    <!-- Mostrar servicios -->
                    @foreach ($services as $service)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="number" wire:model="serviceQuantities.{{ $service->id }}"
                                    wire:change="calculateTotal"
                                    class="w-20 px-2 py-1 border border-gray-300 rounded-md focus:ring-indigo-500" />
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $service->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">S/.
                                <input type="number" wire:model="servicePrices.{{ $service->id }}"
                                    wire:change="calculateTotal"
                                    class="w-24 px-2 py-1 border border-gray-300 rounded-md focus:ring-indigo-500" />
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">S/
                                {{ number_format(
                                    ((float) ($servicePrices[$service->id] ?? $service->price)) * ((int) ($serviceQuantities[$service->id] ?? 0)),
                                    2
                                ) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">S/
                                {{ number_format($this->calculateServiceUtilidad($service), 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button wire:click="removeService({{ $service->id }})"
                                    class="text-red-600 hover:text-red-800 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>

        </div>

        <!-- Total y Botones -->
        <div class="flex justify-between items-center">
            <div>
                <h3 class="text-xl font-bold text-gray-800">Total: {{ number_format($total, 2) }}</h3>
                <h3 class="text-xl font-bold text-gray-600">Utilidad: {{ number_format($this->calculateUtilidadSale(), 2) }}</h3>
            </div>
            <div class="space-x-4">
                <button wire:click="cancelSale"
                    class="px-6 py-3 bg-gray-600 text-white font-semibold rounded-md hover:bg-gray-700 transition">
                    Cancelar
                </button>
                <button wire:click="openConfirmationModal"
                    class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-150 ease-in-out">
                    Guardar Venta
                </button>
            </div>
        </div>

        <!-- Modal de confirmación -->
        @if ($showConfirmationModal)
            <div class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
                <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Atención</h2>

                    @if ($validationMessage)
                        <p class="text-red-600 font-semibold mb-4">{{ $validationMessage }}</p>
                        <div class="flex justify-end space-x-4">
                            <button wire:click="$set('showConfirmationModal', false)"
                                class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400">
                                Cerrar
                            </button>
                        </div>
                    @else
                        <p class="text-gray-600 mb-6">¿Está seguro de que desea crear esta venta?</p>
                        <div class="flex justify-end space-x-4">
                            <button wire:click="$set('showConfirmationModal', false)"
                                class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400">
                                Cancelar
                            </button>
                            <button wire:click="saveSale"
                                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                Confirmar
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        @endif

    </div>
</div>
