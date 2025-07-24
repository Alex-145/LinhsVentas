<div class="px-2 sm:px-4">
    <div class="container mx-auto space-y-4 sm:space-y-6">
        @if (session()->has('message'))
            <div class="p-3 sm:p-4 mb-4 text-sm sm:text-base text-green-800 bg-green-100 border-l-4 border-green-500">
                {{ session('message') }}
            </div>
        @endif

        <!-- Sección de búsqueda -->
        <div class="grid grid-cols-1 gap-4 sm:gap-6 md:grid-cols-2">

            <!-- Buscar Cliente - Versión mejorada -->
            <div x-data="{ openModal: false }" x-on:close-modal.window="openModal = false" class="w-full">
                <label for="clientSearch" class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-2">Buscar
                    Cliente</label>
                <div class="flex flex-col sm:flex-row gap-2">
                    <!-- Campo de búsqueda -->
                    <div class="flex-1 relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-4.35-4.35M18 10a8 8 0 10-8 8 8 8 0 008-8z" />
                            </svg>
                        </div>
                        <input type="text" id="clientSearch" wire:model="clientSearch" wire:keydown="searchClient"
                            placeholder="Nombre, DNI, RUC o Razón Social"
                            class="w-full pl-8 sm:pl-10 pr-3 sm:pr-4 py-1 sm:py-2 text-xs sm:text-sm border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                            aria-describedby="clientSearchHelp" />
                        <!-- Lista de resultados -->
                        @if (!empty($clientResults))
                            <ul
                                class="absolute z-10 w-full bg-white border border-gray-300 mt-1 rounded-lg shadow-lg max-h-60 overflow-y-auto text-xs sm:text-sm">
                                @foreach ($clientResults as $client)
                                    <li wire:click="selectClient({{ $client->id }})"
                                        class="px-3 py-2 sm:px-4 sm:py-3 cursor-pointer hover:bg-indigo-50 transition duration-200 ease-in-out border-b border-gray-200 last:border-b-0">
                                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
                                            <span class="text-gray-800 font-medium">{{ $client->name }}</span>
                                            <div class="flex gap-2 mt-1 sm:mt-0">
                                                @if ($client->dni)
                                                    <span class="text-gray-500">{{ $client->dni }}</span>
                                                @endif
                                                @if ($client->ruc)
                                                    <span class="text-gray-500">{{ $client->ruc }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        @if ($client->business_name)
                                            <p class="text-gray-500 mt-1 truncate">{{ $client->business_name }}</p>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <!-- Botón para nuevo cliente -->
                    <button type="button" @click="openModal = true"
                        class="px-3 py-1 sm:px-4 sm:py-2 text-xs sm:text-sm bg-indigo-600 text-white rounded-lg shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50 transition duration-200">
                        + Nuevo Cliente
                    </button>
                </div>
                <p id="clientSearchHelp" class="mt-1 text-xs sm:text-sm text-gray-500">
                    Escribe para buscar clientes por nombre, DNI, RUC o razón social.
                </p>

                <!-- Modal para agregar nuevo cliente - Versión responsiva -->
                <div x-show="openModal" x-transition.opacity
                    class="fixed inset-0 flex items-center justify-center p-2 sm:p-4 bg-gray-900 bg-opacity-50 z-50">
                    <div @click.away="openModal = false"
                        class="bg-white p-4 sm:p-6 rounded-lg w-full max-w-md max-h-[90vh] overflow-y-auto">
                        <h2 class="text-lg sm:text-xl font-semibold mb-3 sm:mb-4">Nuevo Cliente</h2>
                        <form wire:submit.prevent="createClient" class="space-y-3 sm:space-y-4">
                            <div>
                                <label for="name"
                                    class="block text-xs sm:text-sm font-medium text-gray-700">Nombre</label>
                                <input type="text" id="name" wire:model="name"
                                    class="w-full p-2 text-xs sm:text-sm border border-gray-300 rounded-lg" required />
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                                <div>
                                    <label for="dni"
                                        class="block text-xs sm:text-sm font-medium text-gray-700">DNI</label>
                                    <input type="text" id="dni" wire:model="dni"
                                        class="w-full p-2 text-xs sm:text-sm border border-gray-300 rounded-lg" />
                                </div>
                                <div>
                                    <label for="ruc"
                                        class="block text-xs sm:text-sm font-medium text-gray-700">RUC</label>
                                    <input type="text" id="ruc" wire:model="ruc"
                                        class="w-full p-2 text-xs sm:text-sm border border-gray-300 rounded-lg" />
                                </div>
                            </div>
                            <div>
                                <label for="business_name"
                                    class="block text-xs sm:text-sm font-medium text-gray-700">Razón Social</label>
                                <input type="text" id="business_name" wire:model="business_name"
                                    class="w-full p-2 text-xs sm:text-sm border border-gray-300 rounded-lg" />
                            </div>
                            <div>
                                <label for="phone_number"
                                    class="block text-xs sm:text-sm font-medium text-gray-700">Número de
                                    Teléfono</label>
                                <input type="text" id="phone_number" wire:model="phone_number"
                                    class="w-full p-2 text-xs sm:text-sm border border-gray-300 rounded-lg" />
                            </div>
                            <div>
                                <label for="email" class="block text-xs sm:text-sm font-medium text-gray-700">Correo
                                    Electrónico</label>
                                <input type="text" id="email" wire:model="email"
                                    class="w-full p-2 text-xs sm:text-sm border border-gray-300 rounded-lg" />
                            </div>
                            <div class="flex justify-end space-x-2 sm:space-x-3 pt-2">
                                <button type="button" @click="openModal = false"
                                    class="px-3 py-1 sm:px-4 sm:py-2 text-xs sm:text-sm bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                                    Cancelar
                                </button>
                                <button type="submit"
                                    class="px-3 py-1 sm:px-4 sm:py-2 text-xs sm:text-sm bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                                    Guardar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                @if ($selectedClient)
                    <div x-data="{ open: false }"
                        class="mt-3 bg-white rounded-lg border border-green-300 shadow-sm hover:shadow-md transition-shadow duration-300">
                        <div @click="open = !open" class="cursor-pointer p-2 sm:p-3 flex items-center justify-between">
                            <h3 class="text-xs sm:text-sm font-semibold text-green-800 truncate">Cliente:
                                {{ $selectedClient['name'] }}</h3>
                            <svg :class="open ? 'rotate-180' : 'rotate-0'"
                                class="w-3 h-3 sm:w-4 sm:h-4 text-green-700 transition-transform duration-200"
                                fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7l5 5 5-5"></path>
                            </svg>
                        </div>

                        <div x-show="open" x-transition
                            class="p-2 sm:p-3 bg-green-50 rounded-b-lg text-xs sm:text-sm">
                            @if (!empty($selectedClient['ruc']))
                                <p class="text-green-700"><strong>RUC:</strong> {{ $selectedClient['ruc'] }}</p>
                            @elseif(!empty($selectedClient['dni']))
                                <p class="text-green-700"><strong>DNI:</strong> {{ $selectedClient['dni'] }}</p>
                            @endif
                            <p class="text-green-700 mt-1"><strong>Razón Social:</strong>
                                {{ $selectedClient['business_name'] ?? 'N/A' }}</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Estado de Factura - Versión mejorada -->
            <div>
                <h3 class="text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-2">Estado de la Factura</h3>
                <div class="flex flex-col space-y-2 sm:space-y-0 sm:flex-row sm:space-x-4">
                    <label class="inline-flex items-center">
                        <input type="radio" id="pendiente_facturacion" wire:model="status_fac"
                            value="pendiente_facturacion"
                            class="form-radio h-3 w-3 sm:h-4 sm:w-4 text-indigo-600 transition duration-200" />
                        <span class="ml-1 sm:ml-2 text-xs sm:text-sm text-gray-700">Para Facturar</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" id="no_aplicable" wire:model="status_fac" value="no_aplicable"
                            class="form-radio h-3 w-3 sm:h-4 sm:w-4 text-indigo-600 transition duration-200" />
                        <span class="ml-1 sm:ml-2 text-xs sm:text-sm text-gray-700">Sin Factura</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Buscadores de Productos y Servicios - Versión responsiva -->
        <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
            <!-- Buscador de Productos -->
            <div class="w-full sm:w-1/2">
                <label for="productSearch" class="block text-xs sm:text-sm font-medium text-gray-700">Buscar
                    Producto</label>
                <div class="relative mt-1">
                    <input type="text" id="productSearch" wire:model="search" wire:keyup="searchProduct"
                        placeholder="Ingresa el nombre del producto"
                        class="w-full px-3 py-1 sm:px-4 sm:py-2 text-xs sm:text-sm border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />

                    @if ($showlist)
                        <ul
                            class="absolute z-10 w-full bg-white border border-gray-300 mt-1 rounded-lg shadow-lg max-h-60 overflow-y-auto text-xs sm:text-sm">
                            @if (!empty($resultsProduct))
                                @foreach ($resultsProduct as $result)
                                    <li wire:click="getProduct({{ $result->id }})"
                                        class="px-3 py-1 sm:px-4 sm:py-2 cursor-pointer hover:bg-gray-100 transition truncate">
                                        {{ $result->name }}
                                    </li>
                                @endforeach
                            @else
                                <li class="px-3 py-1 sm:px-4 sm:py-2 text-gray-500">No se encontraron resultados.</li>
                            @endif
                        </ul>
                    @endif
                </div>
            </div>

            <!-- Buscador de Servicios -->
            <div class="w-full sm:w-1/2">
                <label for="serviceSearch" class="block text-xs sm:text-sm font-medium text-gray-700">Buscar
                    Servicio</label>
                <div class="relative mt-1">
                    <input type="text" id="serviceSearch" wire:model="servicobuscar" wire:keyup="searchService"
                        placeholder="Ingresa el nombre del servicio"
                        class="w-full px-3 py-1 sm:px-4 sm:py-2 text-xs sm:text-sm border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />

                    @if ($serviceshowlist)
                        <ul
                            class="absolute z-10 w-full bg-white border border-gray-300 mt-1 rounded-lg shadow-lg max-h-60 overflow-y-auto text-xs sm:text-sm">
                            @if (!empty($resultsService))
                                @foreach ($resultsService as $result)
                                    <li wire:click="getService({{ $result->id }})"
                                        class="px-3 py-1 sm:px-4 sm:py-2 cursor-pointer hover:bg-gray-100 transition truncate">
                                        {{ $result->name }}
                                    </li>
                                @endforeach
                            @else
                                <li class="px-3 py-1 sm:px-4 sm:py-2 text-gray-500">No se encontraron resultados.</li>
                            @endif
                        </ul>
                    @endif
                </div>
            </div>
        </div>

        <!-- Tabla de Productos - Versión responsiva -->
        <div class="overflow-x-auto rounded-lg shadow bg-white">
            <table class="min-w-full divide-y divide-gray-200 text-xs sm:text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-2 py-2 sm:px-4 sm:py-3 text-left font-medium text-gray-500 whitespace-nowrap">
                            Cantidad</th>
                        <th class="px-2 py-2 sm:px-4 sm:py-3 text-left font-medium text-gray-500">Descripción</th>
                        <th class="px-2 py-2 sm:px-4 sm:py-3 text-left font-medium text-gray-500 whitespace-nowrap">
                            Precio</th>
                        <th class="px-2 py-2 sm:px-4 sm:py-3 text-left font-medium text-gray-500 whitespace-nowrap">
                            Subtotal</th>
                        <th class="px-2 py-2 sm:px-4 sm:py-3 text-left font-medium text-gray-500 whitespace-nowrap">
                            Utilidad</th>
                        <th class="px-2 py-2 sm:px-4 sm:py-3 text-left font-medium text-gray-500 whitespace-nowrap">
                            Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <!-- Mostrar productos -->
                    @foreach ($products as $product)
                        <tr>
                            <td class="px-2 py-2 sm:px-4 sm:py-3 whitespace-nowrap">
                                <input type="number" wire:model="productQuantities.{{ $product->id }}"
                                    wire:change="calculateTotal"
                                    class="w-16 sm:w-20 px-1 sm:px-2 py-1 text-xs sm:text-sm border border-gray-300 rounded-md focus:ring-indigo-500" />
                            </td>
                            <td class="px-2 py-2 sm:px-4 sm:py-3 truncate max-w-[100px] sm:max-w-none">
                                {{ $product->name }}</td>
                            <td class="px-2 py-2 sm:px-4 sm:py-3 whitespace-nowrap">
                                S/.
                                <input type="number" wire:model="productPrices.{{ $product->id }}"
                                    wire:change="calculateTotal"
                                    class="w-16 sm:w-20 px-1 sm:px-2 py-1 text-xs sm:text-sm border border-gray-300 rounded-md focus:ring-indigo-500" />
                            </td>
                            <td class="px-2 py-2 sm:px-4 sm:py-3 whitespace-nowrap">
                                S/
                                {{ number_format(((float) ($productPrices[$product->id] ?? $product->sale_price)) * ((int) ($productQuantities[$product->id] ?? 0)), 2) }}
                            </td>
                            <td class="px-2 py-2 sm:px-4 sm:py-3 whitespace-nowrap">
                                S/ {{ number_format($this->calculateProductUtilidad($product), 2) }}
                            </td>
                            <td class="px-2 py-2 sm:px-4 sm:py-3 whitespace-nowrap">
                                <button wire:click="removeProduct({{ $product->id }})"
                                    class="text-red-600 hover:text-red-800 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5"
                                        viewBox="0 0 20 20" fill="currentColor">
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
                            <td class="px-2 py-2 sm:px-4 sm:py-3 whitespace-nowrap">
                                <input type="number" wire:model="serviceQuantities.{{ $service->id }}"
                                    wire:change="calculateTotal"
                                    class="w-16 sm:w-20 px-1 sm:px-2 py-1 text-xs sm:text-sm border border-gray-300 rounded-md focus:ring-indigo-500" />
                            </td>
                            <td class="px-2 py-2 sm:px-4 sm:py-3 truncate max-w-[100px] sm:max-w-none">
                                {{ $service->name }}</td>
                            <td class="px-2 py-2 sm:px-4 sm:py-3 whitespace-nowrap">
                                S/.
                                <input type="number" wire:model="servicePrices.{{ $service->id }}"
                                    wire:change="calculateTotal"
                                    class="w-16 sm:w-20 px-1 sm:px-2 py-1 text-xs sm:text-sm border border-gray-300 rounded-md focus:ring-indigo-500" />
                            </td>
                            <td class="px-2 py-2 sm:px-4 sm:py-3 whitespace-nowrap">
                                S/
                                {{ number_format(((float) ($servicePrices[$service->id] ?? $service->price)) * ((int) ($serviceQuantities[$service->id] ?? 0)), 2) }}
                            </td>
                            <td class="px-2 py-2 sm:px-4 sm:py-3 whitespace-nowrap">
                                S/ {{ number_format($this->calculateServiceUtilidad($service), 2) }}
                            </td>
                            <td class="px-2 py-2 sm:px-4 sm:py-3 whitespace-nowrap">
                                <button wire:click="removeService({{ $service->id }})"
                                    class="text-red-600 hover:text-red-800 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5"
                                        viewBox="0 0 20 20" fill="currentColor">
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

        <!-- Total y Botones - Versión responsiva -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-3 sm:gap-4">
            <div class="text-center sm:text-left">
                <h3 class="text-lg sm:text-xl font-bold text-gray-800">Total: S/ {{ number_format($total, 2) }}</h3>
                <h3 class="text-lg sm:text-xl font-bold text-gray-600">Utilidad: S/
                    {{ number_format($this->calculateUtilidadSale(), 2) }}</h3>
            </div>
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-4 w-full sm:w-auto">
                <button wire:click="cancelSale"
                    class="px-4 py-2 sm:px-6 sm:py-3 text-xs sm:text-sm bg-gray-600 text-white font-semibold rounded-md hover:bg-gray-700 transition w-full sm:w-auto">
                    Cancelar
                </button>
                <button wire:click="openConfirmationModal"
                    class="px-4 py-2 sm:px-6 sm:py-3 text-xs sm:text-sm bg-indigo-600 text-white font-semibold rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition w-full sm:w-auto">
                    Guardar Venta
                </button>
            </div>
        </div>

        <!-- Modal de confirmación - Versión responsiva -->
        @if ($showConfirmationModal)
            <div class="fixed inset-0 flex items-center justify-center z-50 p-2 sm:p-4 bg-black bg-opacity-50">
                <div class="bg-white rounded-lg shadow-xl w-full max-w-md max-h-[90vh] overflow-y-auto">
                    <div class="p-4 sm:p-6">
                        <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-3 sm:mb-4">Atención</h2>

                        @if ($validationMessage)
                            <p class="text-red-600 font-semibold mb-3 sm:mb-4 text-sm sm:text-base">
                                {{ $validationMessage }}</p>
                            <div class="flex justify-end">
                                <button wire:click="$set('showConfirmationModal', false)"
                                    class="px-4 py-2 text-xs sm:text-sm bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400">
                                    Cerrar
                                </button>
                            </div>
                        @else
                            <p class="text-gray-600 mb-4 sm:mb-6 text-sm sm:text-base">¿Está seguro de que desea crear
                                esta venta?</p>
                            <div class="flex justify-end space-x-2 sm:space-x-3">
                                <button wire:click="$set('showConfirmationModal', false)"
                                    class="px-3 py-1 sm:px-4 sm:py-2 text-xs sm:text-sm bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400">
                                    Cancelar
                                </button>
                                <button wire:click="saveSale"
                                    class="px-3 py-1 sm:px-4 sm:py-2 text-xs sm:text-sm bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    Confirmar
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        Livewire.on('clientAdded', () => {
            document.dispatchEvent(new CustomEvent('close-modal'));
        });
    });
</script>
