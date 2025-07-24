<div class="px-2 sm:px-4">
    <!-- Sección de Resumen Financiero -->
    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 mb-4">
        <!-- Div de Ganancias Totales -->
        <div class="p-3 sm:p-4 bg-green-100 rounded-lg shadow-inner flex-1">
            <h3 class="font-bold text-sm sm:text-lg">Ganancias Totales</h3>
            <p class="text-base sm:text-xl text-green-800">S/.{{ number_format($totalGains, 2) }}</p>
        </div>

        <!-- Div de Total de Ventas -->
        <div class="p-3 sm:p-4 bg-blue-100 rounded-lg shadow-inner flex-1">
            <h3 class="font-bold text-sm sm:text-lg">Total de Ventas</h3>
            <p class="text-base sm:text-xl text-blue-800">S/.{{ number_format($totalSales, 2) }}</p>
        </div>
    </div>

    <!-- Sección de Controles -->
    <div class="space-y-3 sm:space-y-4">
        <!-- Botones de Acción -->
        <div class="flex flex-col sm:flex-row justify-end gap-2 sm:gap-4">
            @if (!$isPendienteFacturacion)
                <button wire:click="openModal"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-1 sm:py-2 px-3 sm:px-6 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-[1.02] hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50 text-xs sm:text-sm">
                    Filtros
                </button>
            @endif

            <a href="https://api-seguridad.sunat.gob.pe/v1/clientessol/4f3b88b3-d9d6-402a-b85d-6a0bc857746a/oauth2/loginMenuSol?lang=es-PE&showDni=true&showLanguages=false&originalUrl=https://e-menu.sunat.gob.pe/cl-ti-itmenu/AutenticaMenuInternet.htm&state=rO0ABXNyABFqYXZhLnV0aWwuSGFzaE1hcAUH2sHDFmDRAwACRgAKbG9hZEZhY3RvckkACXRocmVzaG9sZHhwP0AAAAAAAAx3CAAAABAAAAADdAAEZXhlY3B0AAZwYXJhbXN0AEsqJiomL2NsLXRpLWl0bWVudS9NZW51SW50ZXJuZXQuaHRtJmI2NGQyNmE4YjVhZjA5MTkyM2IyM2I2NDA3YTFjMWRiNDFlNzMzYTZ0AANleGVweA=="
                target="_blank"
                class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-1 sm:py-2 px-3 sm:px-4 rounded-lg shadow-md flex items-center justify-center gap-1 sm:gap-2 transition duration-300 ease-in-out transform hover:scale-[1.02] hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50 text-xs sm:text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>SUNAT</span>
            </a>
        </div>

        <!-- Modal de filtros -->
        @if ($isOpen)
            @include('livewire.fiterventas')
        @endif

        <!-- Campo de búsqueda -->
        <div>
            <input type="text" wire:model="search" wire:keydown.debounce.300ms="loadSales"
                placeholder="Buscar por nombre de cliente"
                class="w-full py-1 sm:py-2 px-3 sm:px-4 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-200 ease-in-out hover:border-indigo-500 placeholder-gray-500 text-xs sm:text-sm">
        </div>
    </div>

    <!-- Tabla de Ventas -->
    <div class="container mx-auto mt-4 sm:mt-6">
        @forelse ($sales as $sale)
            <div class="mt-4 sm:mt-6 overflow-x-auto">
                <div class="min-w-full bg-white border border-gray-300 shadow-sm rounded-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-100">
                                <tr>
                                    @foreach (['ID' => 'id', 'Fecha' => 'sale_date', 'Día' => 'sale_date', 'Usuario' => 'user.name', 'Cliente' => 'client.name', 'Total' => 'total', 'Utilidad' => 'utilidad_sale', 'Estado' => 'status_fac', 'Acciones' => ''] as $label => $field)
                                        <th
                                            class="py-2 px-2 sm:px-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                            {{ $label }}
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="cursor-pointer hover:bg-gray-50 transition-colors duration-200"
                                    wire:key="sale-{{ $sale->id }}">
                                    <td class="py-2 px-2 sm:px-3 border-b text-xs sm:text-sm"
                                        wire:click="selectSale({{ $sale->id }})">
                                        {{ $sale->id }}
                                    </td>
                                    <td class="py-2 px-2 sm:px-3 border-b text-xs sm:text-sm"
                                        wire:click="selectSale({{ $sale->id }})">
                                        {{ \Carbon\Carbon::parse($sale->sale_date)->format('d/m/Y') }}
                                    </td>
                                    <td class="py-2 px-2 sm:px-3 border-b text-xs sm:text-sm"
                                        wire:click="selectSale({{ $sale->id }})">
                                        {{ \Carbon\Carbon::parse($sale->sale_date)->isoFormat('ddd') }}
                                    </td>
                                    <td class="py-2 px-2 sm:px-3 border-b text-xs sm:text-sm truncate max-w-[80px] sm:max-w-none"
                                        wire:click="selectSale({{ $sale->id }})">
                                        {{ $sale->user->name }}
                                    </td>
                                    <td class="py-2 px-2 sm:px-3 border-b text-xs sm:text-sm truncate max-w-[80px] sm:max-w-none"
                                        wire:click="selectSale({{ $sale->id }})">
                                        {{ $sale->client->name }}
                                    </td>
                                    <td class="py-2 px-2 sm:px-3 border-b text-xs sm:text-sm"
                                        wire:click="selectSale({{ $sale->id }})">
                                        {{ number_format($sale->total, 2) }}
                                    </td>
                                    <td class="py-2 px-2 sm:px-3 border-b bg-green-100 text-green-800 font-semibold text-xs sm:text-sm"
                                        wire:click="selectSale({{ $sale->id }})">
                                        {{ number_format($sale->utilidad_sale, 2) }}
                                    </td>
                                    <td class="py-2 px-2 sm:px-3 border-b text-xs sm:text-sm"
                                        wire:click="selectSale({{ $sale->id }})">
                                        <span
                                            class="px-1 sm:px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            {{ $sale->status_fac === 'pendiente_facturacion'
                                                ? 'bg-yellow-100 text-yellow-800'
                                                : ($sale->status_fac === 'no_aplicable'
                                                    ? 'bg-gray-100 text-gray-800'
                                                    : 'bg-green-100 text-green-800') }}">
                                            {{ $sale->status_fac === 'pendiente_facturacion' ? 'Pendiente' : ($sale->status_fac === 'no_aplicable' ? 'No Aplica' : 'Facturado') }}
                                        </span>
                                    </td>
                                    <td class="py-2 px-2 sm:px-3 border-b text-xs sm:text-sm">
                                        <div class="flex items-center gap-1 sm:gap-2">
                                            @if ($sale->status_fac === 'pendiente_facturacion')
                                                <button
                                                    wire:click="confirmStatusChange({{ $sale->id }}, 'facturado')"
                                                    class="text-indigo-600 hover:text-indigo-900 transition-colors duration-200"
                                                    title="Marcar como Facturado">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </button>
                                                <button wire:click="showClientInfo({{ $sale->id }})"
                                                    class="text-blue-600 hover:text-blue-900 transition-colors duration-200"
                                                    title="Ver Información del Cliente">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </button>
                                            @elseif ($sale->status_fac === 'no_aplicable')
                                                <button
                                                    wire:click="confirmStatusChange({{ $sale->id }}, 'pendiente_facturacion')"
                                                    class="text-green-600 hover:text-green-900 transition-colors duration-200"
                                                    title="Cambiar a Pendiente Facturación">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                    </svg>
                                                </button>
                                            @endif
                                            <button wire:click="confirmDelete({{ $sale->id }})"
                                                class="text-red-600 hover:text-red-900 transition-colors duration-200"
                                                title="Eliminar">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                            <button wire:click="generateSalePdf({{ $sale->id }})"
                                                class="text-yellow-600 hover:text-yellow-900 transition-colors duration-200"
                                                title="Generar PDF">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                @if ($selectedSale === $sale->id)
                                    <tr>
                                        <td colspan="9" class="p-0">
                                            <div class="p-2 sm:p-3 bg-gray-50 rounded-b-lg">
                                                <h3 class="font-bold text-sm sm:text-base mb-2 sm:mb-3">Detalles de la
                                                    Venta</h3>
                                                <div class="overflow-x-auto">
                                                    <table
                                                        class="min-w-full bg-white border border-gray-200 shadow-xs rounded-lg">
                                                        <thead class="bg-gray-100">
                                                            <tr>
                                                                @foreach (['ID' => 'id', 'Producto' => 'product.name', 'Cant.' => 'quantity', 'Precio' => 'price', 'Subtotal' => 'subtotal', 'Utilidad' => 'utilidad_saledetail'] as $label => $field)
                                                                    <th
                                                                        class="py-1 px-2 sm:px-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                                                        {{ $label }}
                                                                    </th>
                                                                @endforeach
                                                                <th
                                                                    class="py-1 px-2 sm:px-3 border-b text-center text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                                                    Acciones
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($sale->saleDetails as $detail)
                                                                <tr class="hover:bg-gray-50">
                                                                    <td
                                                                        class="py-1 px-2 sm:px-3 border-b text-xs sm:text-sm">
                                                                        {{ $detail->id }}
                                                                    </td>
                                                                    <td
                                                                        class="py-1 px-2 sm:px-3 border-b text-xs sm:text-sm truncate max-w-[100px] sm:max-w-none">
                                                                        @if ($detail->salable instanceof App\Models\Product || $detail->salable instanceof App\Models\Service)
                                                                            {{ $detail->salable->name }}
                                                                        @else
                                                                            No disponible
                                                                        @endif
                                                                    </td>
                                                                    <td
                                                                        class="py-1 px-2 sm:px-3 border-b text-xs sm:text-sm">
                                                                        {{ $detail->quantity }}
                                                                    </td>
                                                                    <td
                                                                        class="py-1 px-2 sm:px-3 border-b text-xs sm:text-sm">
                                                                        {{ number_format($detail->price, 2) }}
                                                                    </td>
                                                                    <td
                                                                        class="py-1 px-2 sm:px-3 border-b text-xs sm:text-sm">
                                                                        {{ number_format($detail->subtotal, 2) }}
                                                                    </td>
                                                                    <td
                                                                        class="py-1 px-2 sm:px-3 border-b bg-green-100 text-green-800 font-semibold text-xs sm:text-sm">
                                                                        {{ number_format($detail->utilidad_saledetail, 2) }}
                                                                    </td>
                                                                    <td class="py-1 px-2 sm:px-3 border-b text-center">
                                                                        <button
                                                                            wire:click="confirmDeleteDetail({{ $detail->id }})"
                                                                            class="text-red-600 hover:text-red-900 transition-colors duration-200"
                                                                            title="Eliminar">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                class="h-4 w-4 sm:h-5 sm:w-5 inline"
                                                                                viewBox="0 0 20 20"
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
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @empty
            <p class="mt-4 sm:mt-6 text-sm sm:text-base text-gray-600 text-center">No hay ventas registradas.</p>
        @endforelse
    </div>

    <!-- Botón de Exportar -->
    <div class="mt-4 sm:mt-6 flex justify-center sm:justify-start">
        <button wire:click="exportSalesReport"
            class="bg-green-600 hover:bg-green-700 text-white font-semibold py-1 sm:py-2 px-3 sm:px-6 rounded-lg shadow-md flex items-center gap-1 sm:gap-2 transition duration-300 ease-in-out transform hover:scale-[1.02] hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 text-xs sm:text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <span>Exportar Detalle Completo</span>
        </button>
    </div>

    <!-- Botón de Calcular Diezmo -->
    @if ($sales->isNotEmpty())
        <div class="mt-4 sm:mt-6 flex justify-center sm:justify-start">
            <button wire:click="calculateTithe"
                class="bg-green-500 hover:bg-green-600 text-white font-bold py-1 sm:py-2 px-3 sm:px-4 rounded-md transition duration-300 ease-in-out transform hover:scale-[1.02] text-xs sm:text-sm">
                Calcular Diezmo
            </button>
        </div>

        @if ($tithe > 0)
            <div
                class="mt-2 sm:mt-3 p-2 sm:p-3 bg-green-100 border-l-4 border-green-500 text-green-700 text-sm sm:text-base">
                <p class="font-bold">El diezmo calculado es: S/. {{ number_format($tithe, 2) }}</p>
            </div>
        @endif
    @endif

    <!-- Modales -->
    <div x-data="{ open: @entangle('showDeleteConfirmationde') }" x-show="open"
        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-50 p-2 sm:p-4">
        <div class="bg-white p-4 sm:p-6 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-base sm:text-lg font-bold mb-3 sm:mb-4">¿Estás seguro de eliminar este detalle?</h2>
            <div class="flex justify-end gap-2 sm:gap-3">
                <button wire:click="$set('showDeleteConfirmationde', false)"
                    class="bg-gray-300 text-gray-700 px-3 sm:px-4 py-1 sm:py-2 rounded text-xs sm:text-sm">Cancelar</button>
                <button wire:click="deleteDetailSale({{ $detailToDelete }})"
                    class="bg-red-600 text-white px-3 sm:px-4 py-1 sm:py-2 rounded text-xs sm:text-sm">Eliminar</button>
            </div>
        </div>
    </div>

    @if ($showDeleteConfirmation || $showStatusChangeConfirmation)
        <div class="fixed inset-0 flex items-center justify-center bg-gray-700 bg-opacity-50 z-50 p-2 sm:p-4">
            <div class="bg-white p-4 sm:p-6 rounded-lg shadow-xl w-full max-w-md">
                <h2 class="text-lg sm:text-xl font-bold mb-3 sm:mb-4">Confirmación</h2>
                <p class="text-sm sm:text-base mb-4 sm:mb-5">¿Está seguro de que desea realizar esta acción?</p>
                <div class="flex justify-end gap-2 sm:gap-4">
                    <button wire:click="cancelAction"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-3 sm:px-4 py-1 sm:py-2 rounded transition duration-300 ease-in-out text-xs sm:text-sm">
                        Cancelar
                    </button>
                    <button wire:click="{{ $showStatusChangeConfirmation ? 'changeStatus' : 'deleteSale' }}"
                        class="bg-red-500 hover:bg-red-600 text-white px-3 sm:px-4 py-1 sm:py-2 rounded transition duration-300 ease-in-out text-xs sm:text-sm">
                        Sí, {{ $showStatusChangeConfirmation ? 'cambiar' : 'eliminar' }}
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if ($tithe > 0)
        <div class="fixed inset-0 flex items-center justify-center bg-gray-700 bg-opacity-50 z-50 p-2 sm:p-4">
            <div class="bg-white p-4 sm:p-6 rounded-lg shadow-xl w-full max-w-md">
                <h2 class="text-xl sm:text-2xl font-bold mb-3 sm:mb-4">Diezmo Calculado</h2>
                <p class="text-2xl sm:text-3xl font-semibold text-green-600 mb-4 sm:mb-5 text-center">
                    S/. {{ number_format($tithe, 2) }}
                </p>
                <div class="flex justify-end">
                    <button wire:click="$set('tithe', 0)"
                        class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 sm:px-6 py-1 sm:py-2 rounded-md transition duration-300 ease-in-out transform hover:scale-[1.02] text-xs sm:text-sm">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if ($selectedClient)
        <div class="fixed inset-0 flex items-center justify-center bg-gray-700 bg-opacity-50 z-50 p-2 sm:p-4">
            <div class="bg-white p-4 sm:p-6 rounded-lg shadow-xl w-full max-w-md">
                <h2 class="text-lg sm:text-xl font-bold mb-3 sm:mb-4">Información del Cliente</h2>
                <div class="space-y-2 sm:space-y-3 text-sm sm:text-base">
                    <p><strong>Nombre:</strong> {{ $selectedClient['name'] }}</p>
                    <p><strong>DNI/RUC:</strong> {{ $selectedClient['dni_ruc'] }}</p>
                    <p><strong>Razón Social:</strong> {{ $selectedClient['business_name'] }}</p>
                    <p><strong>Teléfono:</strong> {{ $selectedClient['phone_number'] }}</p>
                </div>
                <div class="flex justify-end mt-4 sm:mt-5">
                    <button wire:click="$set('selectedClient', null)"
                        class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 sm:px-6 py-1 sm:py-2 rounded-md transition duration-300 ease-in-out transform hover:scale-[1.02] text-xs sm:text-sm">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
