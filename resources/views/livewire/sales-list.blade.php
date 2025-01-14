<div
    class="{{ $menuAbierto ? 'ml-60' : 'ml-16' }} mt-16 max-w-7xl mx-auto p-6 bg-gradient-to-br from-blue-50 to-indigo-100 shadow-xl rounded-xl transition-all duration-300 ease-in-out">
    <div class="flex space-x-4">
        <!-- Div de Ganancias Totales -->
        <div class="p-4 mb-4 bg-green-100 rounded-lg shadow-inner flex-1">
            <h3 class="font-bold text-lg">Ganancias Totales</h3>
            <p class="text-xl text-green-800">S/.{{ number_format($totalGains, 2) }}</p>
        </div>

        <!-- Div de Total de Ventas -->
        <div class="p-4 mb-4 bg-blue-100 rounded-lg shadow-inner flex-1">
            <h3 class="font-bold text-lg">Total de Ventas</h3>
            <p class="text-xl text-blue-800">S/.{{ number_format($totalSales, 2) }}</p>
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
            @include('livewire.fiterventas')
        @endif

        <!-- Campo de búsqueda -->
        <div>
            <input type="text" wire:model="search" wire:keydown.debounce.300ms="loadSales"
                placeholder="Buscar por nombre de cliente"
                class="w-full py-2 px-4 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-200 ease-in-out hover:border-indigo-500 placeholder-gray-500">
        </div>
    </div>

    <div class="container mx-auto mt-8">
        @forelse ($sales as $sale)
            <div class="mt-8 overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300 shadow-md rounded-lg overflow-hidden">
                    <thead class="bg-gray-100">
                        <tr>
                            @foreach (['Fecha de Venta' => 'sale_date', 'Día de la Semana' => 'sale_date', 'Usuario' => 'user.name', 'Cliente' => 'client.name', 'Total' => 'total', 'Utilidad' => 'utilidad_sale', 'Estado de la Factura' => 'status_fac', 'Acciones' => ''] as $label => $field)
                                <th
                                    class="py-3 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ $label }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="cursor-pointer hover:bg-gray-50 transition-colors duration-200"
                            wire:key="sale-{{ $sale->id }}">
                            <td class="py-3 px-4 border-b" wire:click="selectSale({{ $sale->id }})">
                                {{ \Carbon\Carbon::parse($sale->sale_date)->format('d/m/Y') }}</td>
                            <td class="py-3 px-4 border-b" wire:click="selectSale({{ $sale->id }})">
                                {{ \Carbon\Carbon::parse($sale->sale_date)->isoFormat('dddd') }}</td>
                            <td class="py-3 px-4 border-b" wire:click="selectSale({{ $sale->id }})">
                                {{ $sale->user->name }}</td>
                            <td class="py-3 px-4 border-b" wire:click="selectSale({{ $sale->id }})">
                                {{ $sale->client->name }}</td>
                            <td class="py-3 px-4 border-b" wire:click="selectSale({{ $sale->id }})">
                                {{ number_format($sale->total, 2) }}</td>
                            <td class="py-3 px-4 border-b bg-green-100 text-green-800 font-semibold"
                                wire:click="selectSale({{ $sale->id }})">
                                {{ number_format($sale->utilidad_sale, 2) }}
                            </td>
                            <td class="py-3 px-4 border-b" wire:click="selectSale({{ $sale->id }})">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $sale->status_fac === 'pendiente_facturacion'
                                        ? 'bg-yellow-100 text-yellow-800'
                                        : ($sale->status_fac === 'no_aplicable'
                                            ? 'bg-gray-100 text-gray-800'
                                            : 'bg-green-100 text-green-800') }}">
                                    {{ ucfirst($sale->status_fac) }}
                                </span>
                            </td>
                            <td class="py-3 px-4 border-b">
                                <div class="flex items-center space-x-2">
                                    @if ($sale->status_fac === 'pendiente_facturacion')
                                        <button wire:click="confirmStatusChange({{ $sale->id }}, 'facturado')"
                                            class="text-indigo-600 hover:text-indigo-900 transition-colors duration-200"
                                            title="Marcar como Facturado">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                        <button wire:click="showClientInfo({{ $sale->id }})"
                                            class="text-blue-600 hover:text-blue-900 transition-colors duration-200"
                                            title="Ver Información del Cliente">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path
                                                    d="M10 2a6 6 0 100 12 6 6 0 000-12zM8 7a2 2 0 114 0 2 2 0 01-4 0zm2 8a5.978 5.978 0 01-4.472-2.09A4.978 4.978 0 0110 12a4.978 4.978 0 014.472 2.91A5.978 5.978 0 0110 15z" />
                                            </svg>
                                        </button>
                                    @elseif ($sale->status_fac === 'no_aplicable')
                                        <button
                                            wire:click="confirmStatusChange({{ $sale->id }}, 'pendiente_facturacion')"
                                            class="text-green-600 hover:text-green-900 transition-colors duration-200"
                                            title="Cambiar a Pendiente Facturación">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    @endif
                                    <button wire:click="confirmDelete({{ $sale->id }})"
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

                        @if ($selectedSale === $sale->id)
                            <tr>
                                <td colspan="7">
                                    <div class="p-4 bg-gray-50 rounded-lg shadow-inner">
                                        <h3 class="font-bold text-lg mb-4">Detalles de la Venta</h3>
                                        <table
                                            class="min-w-full bg-white border border-gray-300 shadow-sm rounded-lg overflow-hidden">
                                            <thead class="bg-gray-100">
                                                <tr>
                                                    @foreach (['Producto' => 'product.name', 'Cantidad' => 'quantity', 'Precio' => 'price', 'Subtotal' => 'subtotal', 'Utilidad' => 'utilidad_saledetail'] as $label => $field)
                                                        <th
                                                            class="py-2 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            {{ $label }}
                                                        </th>
                                                    @endforeach
                                                    <th
                                                        class="py-2 px-4 border-b text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Acciones
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($sale->saleDetails as $detail)
                                                    <tr class="hover:bg-gray-50">
                                                        <td class="py-2 px-4 border-b">
                                                            @if ($detail->salable instanceof App\Models\Product || $detail->salable instanceof App\Models\Service)
                                                                {{ $detail->salable->name }}
                                                            @else
                                                                No disponible
                                                            @endif
                                                        </td>

                                                        <td class="py-2 px-4 border-b">{{ $detail->quantity }}</td>
                                                        <td class="py-2 px-4 border-b">
                                                            {{ number_format($detail->price, 2) }}</td>
                                                        <td class="py-2 px-4 border-b">
                                                            {{ number_format($detail->subtotal, 2) }}</td>
                                                        <td
                                                            class="py-2 px-4 border-b bg-green-100 text-green-800 font-semibold">
                                                            {{ number_format($detail->utilidad_saledetail, 2) }}
                                                        </td>
                                                        <td class="py-2 px-4 border-b text-center">
                                                            <button
                                                                wire:click="confirmDeleteDetail({{ $detail->id }})"
                                                                class="text-red-600 hover:text-red-900 transition-colors duration-200"
                                                                title="Eliminar">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
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
                <button wire:click="deleteDetailSale({{ $detailToDelete }})"
                    class="bg-red-600 text-white px-4 py-2 rounded">Eliminar</button>
            </div>
        </div>
    </div>


    @if ($showDeleteConfirmation || $showStatusChangeConfirmation)
        <div class="fixed inset-0 flex items-center justify-center bg-gray-700 bg-opacity-50 z-50">
            <div class="bg-white p-6 rounded-lg shadow-xl">
                <h2 class="text-xl font-bold mb-4">¿Está seguro de que desea realizar esta acción?</h2>
                <div class="flex justify-end space-x-4">
                    <button wire:click="cancelAction"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded transition duration-300 ease-in-out">Cancelar</button>
                    <button wire:click="{{ $showStatusChangeConfirmation ? 'changeStatus' : 'deleteSale' }}"
                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded transition duration-300 ease-in-out">Sí,
                        {{ $showStatusChangeConfirmation ? 'cambiar' : 'eliminar' }}</button>
                </div>
            </div>
        </div>
    @endif

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
    @endif
</div>
