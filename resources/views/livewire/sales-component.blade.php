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
            <div x-data="{ openModal: false, name: '', dni_ruc: '', business_name: '', phone_number: '' }">
                <label for="clientSearch" class="block text-sm font-medium text-gray-700 mb-2">Buscar Cliente</label>
                <div class="flex items-center">
                    <!-- Campo de búsqueda -->
                    <div class="flex-1 relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <!-- Ícono de búsqueda -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-4.35-4.35M18 10a8 8 0 10-8 8 8 8 0 008-8z" />
                            </svg>
                        </div>
                        <input type="text" id="clientSearch" wire:model="clientSearch" wire:keydown="searchClient"
                            placeholder="Nombre, DNI/RUC o Razón Social"
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                            aria-describedby="clientSearchHelp" />
                        <!-- Lista de resultados -->
                        @if (!empty($clientResults))
                            <ul
                                class="absolute z-10 w-full bg-white border border-gray-300 mt-2 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                                @foreach ($clientResults as $client)
                                    <li wire:click="selectClient({{ $client->id }})"
                                        class="px-4 py-3 cursor-pointer hover:bg-indigo-50 transition duration-200 ease-in-out border-b border-gray-200 last:border-b-0">
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-800 font-medium">{{ $client->name }}</span>
                                            <span class="text-sm text-gray-500">{{ $client->dni_ruc }}</span>
                                        </div>
                                        @if ($client->business_name)
                                            <p class="text-sm text-gray-500 mt-1">{{ $client->business_name }}</p>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <!-- Botón para nuevo cliente -->
                    <button type="button" @click="openModal = true"
                        class="ml-2 px-4 py-2 bg-indigo-600 text-white rounded-lg shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50 transition duration-200">
                        + Nuevo Cliente
                    </button>
                </div>
                <p id="clientSearchHelp" class="mt-2 text-sm text-gray-500">
                    Escribe para buscar clientes por nombre, DNI/RUC o razón social.
                </p>

                <!-- Modal para agregar nuevo cliente -->
                <div x-show="openModal" x-transition
                    class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50">
                    <div class="bg-white p-6 rounded-lg w-96">
                        <h2 class="text-xl font-semibold mb-4">Nuevo Cliente</h2>
                        <form wire:submit.prevent="createClient">
                            <div class="mb-4">
                                <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                                <input type="text" id="name" wire:model="name"
                                    class="w-full p-2 border border-gray-300 rounded-lg" required />
                            </div>
                            <div class="mb-4">
                                <label for="dni_ruc" class="block text-sm font-medium text-gray-700">DNI/RUC</label>
                                <input type="text" id="dni_ruc" wire:model="dni_ruc"
                                    class="w-full p-2 border border-gray-300 rounded-lg" />
                            </div>
                            <div class="mb-4">
                                <label for="business_name" class="block text-sm font-medium text-gray-700">Razón
                                    Social</label>
                                <input type="text" id="business_name" wire:model="business_name"
                                    class="w-full p-2 border border-gray-300 rounded-lg" />
                            </div>
                            <div class="mb-4">
                                <label for="phone_number" class="block text-sm font-medium text-gray-700">Número de
                                    Teléfono</label>
                                <input type="text" id="phone_number" wire:model="phone_number"
                                    class="w-full p-2 border border-gray-300 rounded-lg" />
                            </div>
                            <div class="flex justify-end">
                                <button type="button" @click="openModal = false"
                                    class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                                    Cancelar
                                </button>
                                <button type="submit"
                                    class="ml-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                                    Guardar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                @if ($selectedClient)
                    <div x-data="{ open: false }"
                        class="col-span-full bg-white rounded-lg border border-green-300 shadow-md hover:shadow-lg transition-shadow duration-300">
                        <div @click="open = !open" class="cursor-pointer p-4 flex items-center justify-between">
                            <h3 class="text-sm font-semibold text-green-800">Cliente: {{ $selectedClient['name'] }}</h3>
                            <svg :class="open ? 'rotate-180' : 'rotate-0'"
                                class="w-4 h-4 text-green-700 transition-transform duration-200" fill="none"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" stroke="currentColor"
                                aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7l5 5 5-5">
                                </path>
                            </svg>
                        </div>

                        <div x-show="open" x-transition class="p-4 bg-green-50 rounded-b-lg">
                            <p class="text-green-700 text-sm"><strong>DNI/RUC:</strong> {{ $selectedClient['dni_ruc'] }}
                            </p>
                            <p class="text-green-700 text-sm"><strong>Razón Social:</strong>
                                {{ $selectedClient['business_name'] ?? 'N/A' }}</p>
                        </div>
                    </div>
                @endif
            </div>




            <!-- Estado de Factura -->
            <div>
                <h3 class="text-sm font-medium text-gray-700 mb-2">Estado de la Factura</h3>
                <div class="flex flex-col md:flex-row md:space-x-8 space-y-2 md:space-y-0">
                    <label class="inline-flex items-center">
                        <input type="radio" id="pendiente_facturacion" wire:model="status_fac"
                            value="pendiente_facturacion"
                            class="form-radio h-4 w-4 text-indigo-600 transition duration-200" />
                        <span class="ml-2 text-gray-700">Para Facturar</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" id="no_aplicable" wire:model="status_fac" value="no_aplicable"
                            class="form-radio h-4 w-4 text-indigo-600 transition duration-200" />
                        <span class="ml-2 text-gray-700">Sin Factura</span>
                    </label>
                </div>
            </div>


        </div>


        <!-- Sección de dolar -->
        <div class="flex items-center space-x-2">
            <span class="text-sm font-medium text-gray-700">Valor del Dólar (USD a PEN):</span>
            <span
                class="font-bold text-green-600">{{ $dollarValue ? number_format($dollarValue, 2) : 'Cargando...' }}</span>
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
                                    2,
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
                                    2,
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
                <h3 class="text-xl font-bold text-gray-600">Utilidad:
                    {{ number_format($this->calculateUtilidadSale(), 2) }}</h3>
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
