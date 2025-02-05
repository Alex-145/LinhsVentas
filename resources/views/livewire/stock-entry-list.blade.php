<div
    class="{{ $menuAbierto ? 'ml-60' : 'ml-0' }} mt-16 max-w-7xl mx-auto p-6 bg-gradient-to-br from-blue-50 to-indigo-100 shadow-xl rounded-xl transition-all duration-300 ease-in-out">
    <div class="flex space-x-4">
        <!-- Div de Compras en Soles -->
        <div class="p-4 mb-4 bg-yellow-100 rounded-lg shadow-inner flex-1">
            <h3 class="font-bold text-lg">Compras Totales (S/.)</h3>
            <p class="text-xl text-yellow-800">S/.{{ number_format($totalExpenses, 2) }}</p>
        </div>

        <!-- Div de Compras en Dólares -->
        <div class="p-4 mb-4 bg-purple-100 rounded-lg shadow-inner flex-1">
            <h3 class="font-bold text-lg">Compras Totales ($)</h3>
            <p class="text-xl text-purple-800">$ {{ number_format($totalExpensesInDollars, 2) }}</p>
        </div>
    </div>


    <div class="space-y-4">
        <!-- Botón de filtros -->
        <div class="flex justify-end">
            <button wire:click="openModal"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-6 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50">
                Filtros
            </button>
        </div>

        <!-- Modal de filtros -->
        @if ($isOpen)
            @include('livewire.fiterentries')
        @endif

        <!-- Campo de búsqueda -->
        <div>
            <input type="text" wire:model="search" wire:keydown.debounce.300ms="loadStockEntries"
                placeholder="Buscar por nombre de proveedor"
                class="w-full py-2 px-4 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-200 ease-in-out hover:border-indigo-500 placeholder-gray-500">
        </div>
    </div>



    <div class="container mx-auto mt-8">
        @forelse ($stockEntries as $stockEntrie)
            <div class="mt-8 overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300 shadow-md rounded-lg overflow-hidden">
                    <thead class="bg-gray-100">
                        <tr>
                            @foreach (['Fecha de Compra' => 'reception_date', 'Usuario' => 'user.name', 'Proveedor' => 'supplier.name'] as $label => $field)
                                <th
                                    class="py-3 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ $label }}
                                </th>
                            @endforeach

                            <!-- Validación para moneda 'dolar' -->
                            @if ($stockEntrie->currency === 'dolar')
                                <th
                                    class="py-3 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Valor del Dólar
                                </th>
                                <th
                                    class="py-3 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total en S/.
                                </th>
                                <th
                                    class="py-3 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total en USD
                                </th>
                            @else
                                <!-- Para moneda 'sol', mostramos solo el total en soles -->
                                <th
                                    class="py-3 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total en S/.
                                </th>
                            @endif

                            <th
                                class="py-3 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr class="cursor-pointer hover:bg-gray-50 transition-colors duration-200"
                            wire:key="stockEntrie-{{ $stockEntrie->id }}">

                            <!-- Fecha de Compra -->
                            <td class="py-3 px-4 border-b" wire:click="selectStockEntry({{ $stockEntrie->id }})">
                                {{ \Carbon\Carbon::parse($stockEntrie->reception_date)->format('d/m/Y') }}
                            </td>

                            <!-- Usuario -->
                            <td class="py-3 px-4 border-b" wire:click="selectStockEntry({{ $stockEntrie->id }})">
                                {{ $stockEntrie->user->name }}
                            </td>

                            <!-- Proveedor -->
                            <td class="py-3 px-4 border-b" wire:click="selectStockEntry({{ $stockEntrie->id }})">
                                {{ $stockEntrie->supplier->name }}
                            </td>

                            <!-- Condición para mostrar el total en soles o el total en dólares -->
                            @if ($stockEntrie->currency === 'dolar')
                                <!-- Valor del Dólar -->
                                <td class="py-3 px-4 border-b" wire:click="selectStockEntry({{ $stockEntrie->id }})">
                                    ${{ number_format($stockEntrie->dollar_value, 2) }}
                                </td>

                                <!-- Total en S/ -->
                                <td class="py-3 px-4 border-b" wire:click="selectStockEntry({{ $stockEntrie->id }})">
                                    S/.{{ number_format($stockEntrie->total_soles, 2) }}
                                </td>

                                <!-- Total en USD -->
                                <td class="py-3 px-4 border-b" wire:click="selectStockEntry({{ $stockEntrie->id }})">
                                    ${{ number_format($stockEntrie->total_dollar, 2) }}
                                </td>
                            @else
                                <!-- Solo mostramos el total en soles para moneda sol -->
                                <td class="py-3 px-4 border-b" wire:click="selectStockEntry({{ $stockEntrie->id }})">
                                    S/.{{ number_format($stockEntrie->total_soles, 2) }}
                                </td>
                            @endif

                            <!-- Acciones -->
                            <td class="py-3 px-4 border-b">
                                <div class="flex items-center space-x-2">
                                    <button wire:click="confirmDelete({{ $stockEntrie->id }})"
                                        class="text-red-600 hover:text-red-900 transition-colors duration-200"
                                        title="Eliminar">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        @if ($selectedStockEntry === $stockEntrie->id)
                            <tr>
                                <td colspan="7">
                                    <div class="p-4 bg-gray-50 rounded-lg shadow-inner">
                                        <h3 class="font-bold text-lg mb-4">Detalles</h3>
                                        <table class="min-w-full bg-white border border-gray-300 shadow-sm rounded-lg overflow-hidden">
                                            <thead class="bg-gray-100">
                                                <tr>
                                                    @foreach (['Producto' => 'product.name', 'Cantidad' => 'quantity'] as $label => $field)
                                                        <th class="py-2 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            {{ $label }}
                                                        </th>
                                                    @endforeach

                                                    <!-- Condición para mostrar el precio y subtotal en soles y dólares en caso de moneda "dolar" -->
                                                    @if ($stockEntrie->currency === 'dolar')
                                                        <th class="py-2 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            Precio en S/.
                                                        </th>
                                                        <th class="py-2 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            Precio en USD
                                                        </th>
                                                        <th class="py-2 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            Subtotal en S/.
                                                        </th>
                                                        <th class="py-2 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            Subtotal en USD
                                                        </th>
                                                    @else
                                                        <th class="py-2 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            Precio en S/.
                                                        </th>
                                                        <th class="py-2 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            Subtotal en S/.
                                                        </th>
                                                    @endif

                                                    <th class="py-2 px-4 border-b text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Acciones
                                                    </th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <!-- Verifica si existen detalles de entrada en stock antes de iterar -->
                                                @if ($stockEntrie->stockEntryDetails && $stockEntrie->stockEntryDetails->count() > 0)
                                                    @foreach ($stockEntrie->stockEntryDetails as $detail)
                                                        <tr class="hover:bg-gray-50">
                                                            <td class="py-2 px-4 border-b">
                                                                {{ $detail->product->name }}
                                                            </td>
                                                            <td class="py-2 px-4 border-b">{{ $detail->quantity }}</td>

                                                            <!-- Verificación de la moneda -->
                                                            @if ($stockEntrie->currency === 'dolar')
                                                                <td class="py-2 px-4 border-b">S/.
                                                                    {{ number_format($detail->purchase_pricesol, 2) }}
                                                                </td>
                                                                <td class="py-2 px-4 border-b">$
                                                                    {{ number_format($detail->purchase_pricedolar, 2) }}
                                                                </td>
                                                                <td class="py-2 px-4 border-b">S/.
                                                                    {{ number_format($detail->subtotalsol, 2) }}
                                                                </td>
                                                                <td class="py-2 px-4 border-b">$
                                                                    {{ number_format($detail->subtotaldolar, 2) }}
                                                                </td>
                                                            @else
                                                                <td class="py-2 px-4 border-b">S/.
                                                                    {{ number_format($detail->purchase_pricesol, 2) }}
                                                                </td>
                                                                <td class="py-2 px-4 border-b">S/.
                                                                    {{ number_format($detail->subtotalsol, 2) }}
                                                                </td>
                                                            @endif

                                                            <td class="py-2 px-4 border-b text-center">
                                                                <button wire:click="confirmDeleteDetail({{ $detail->id }})"
                                                                    class="text-red-600 hover:text-red-900 transition-colors duration-200"
                                                                    title="Eliminar">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                                        <path fill-rule="evenodd"
                                                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                                            clip-rule="evenodd" />
                                                                    </svg>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="6" class="py-2 px-4 text-center text-sm text-gray-500">
                                                            No hay detalles disponibles.
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>

                                        </table>

                                    </div>
                                </td>
                            </tr>
                        @endif

                    </tbody>
                </table>
            </div>
        @empty
            <p class="mt-8 text-lg text-gray-600">No hay ventas registradas.</p>
        @endforelse

    </div>

    <div x-data="{ open: @entangle('showDeleteConfirmationde') }" x-show="open"
        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-lg font-bold mb-4">¿Estás seguro de eliminar este detalle?</h2>
            <div class="flex justify-end">
                <button wire:click="$set('showDeleteConfirmationde', false)"
                    class="bg-gray-300 text-gray-700 px-4 py-2 rounded mr-2">Cancelar</button>
                <button wire:click="deleteDetailStockEntry({{ $detailToDelete }})"
                    class="bg-red-600 text-white px-4 py-2 rounded">Eliminar</button>
            </div>
        </div>
    </div>


    @if ($showDeleteConfirmation)
        <div class="fixed inset-0 flex items-center justify-center bg-gray-700 bg-opacity-50 z-50">
            <div class="bg-white p-6 rounded-lg shadow-xl">
                <h2 class="text-xl font-bold mb-4">¿Está seguro de que desea realizar esta acción?</h2>
                <div class="flex justify-end space-x-4">
                    <button wire:click="cancelAction"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded transition duration-300 ease-in-out">Cancelar</button>
                    <button wire:click="deleteStockEntry"
                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded transition duration-300 ease-in-out">Sí,
                        eliminar</button>
                </div>
            </div>
        </div>
    @endif

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
</div>
