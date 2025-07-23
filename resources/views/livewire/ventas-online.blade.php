<div> <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-indigo-600" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Ventas Online
            </h1>
            <p class="text-sm text-gray-500 mt-1">Administra y monitorea todas las transacciones de venta</p>
        </div>

        <!-- Filter and Stats -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
            <div class="flex items-center bg-white rounded-lg shadow-sm border border-gray-200 px-3 py-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                </svg>
                <select wire:model.live="filtroEstado" id="filtroEstado"
                    class="bg-transparent border-none focus:ring-0 text-sm text-gray-700">
                    @foreach ($opcionesEstado as $valor => $texto)
                        <option value="{{ $valor }}">{{ $texto }}</option>
                    @endforeach
                </select>
            </div>

            <div class="bg-indigo-50 text-indigo-800 px-3 py-2 rounded-lg text-sm font-medium">
                <span class="hidden sm:inline">Total:</span> {{ $ventas->total() }} ventas
            </div>
        </div>
    </div>

    <!-- Notification -->
    @if (session('mensaje'))
        <div
            class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg shadow-sm flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd" />
            </svg>
            {{ session('mensaje') }}
            <button class="ml-auto" wire:click="$set('flash', null)">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    @endif

    <!-- Sales Table -->
    <div class="bg-white rounded-xl shadow-md w-full overflow-x-auto">
        <table class="min-w-[900px] w-full divide-y divide-gray-200 text-xs">
            <thead class="bg-gray-50 text-[11px]">
                <tr>
                    <th class="px-4 py-2 text-left font-semibold text-gray-500 uppercase tracking-wider">Código</th>
                    <th class="px-4 py-2 text-left font-semibold text-gray-500 uppercase tracking-wider">Cliente</th>
                    <th class="px-4 py-2 text-left font-semibold text-gray-500 uppercase tracking-wider">Total</th>
                    <th class="px-4 py-2 text-left font-semibold text-gray-500 uppercase tracking-wider">Fecha</th>
                    <th class="px-4 py-2 text-left font-semibold text-gray-500 uppercase tracking-wider">Estado</th>
                    <th class="px-4 py-2 text-right font-semibold text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($ventas as $proforma)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-4 py-2 whitespace-nowrap font-mono text-gray-800">
                            {{ $proforma->codigo }}
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap">
                            <div class="font-medium text-gray-800">{{ $proforma->client->name }}</div>
                            <div class="text-[10px] text-gray-500">{{ $proforma->client->email }}</div>
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap text-gray-800">
                            S/. {{ number_format($proforma->total, 2) }}
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap text-gray-500">
                            {{ $proforma->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap">
                            @php
                                $clasesEstado = [
                                    'esperando_verificacion' => 'bg-yellow-100 text-yellow-800',
                                    'pagado' => 'bg-green-100 text-green-800',
                                    'esperando_pago' => 'bg-blue-100 text-blue-800',
                                    'cancelado' => 'bg-red-100 text-red-800',
                                    'cerrado' => 'bg-gray-100 text-gray-800',
                                    'cerrado_por_vencimiento' => 'bg-red-100 text-red-800',
                                    'solocotizacion' => 'bg-purple-100 text-purple-800',
                                ];
                            @endphp
                            <span
                                class="px-2 py-0.5 rounded-full text-[11px] font-semibold {{ $clasesEstado[$proforma->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ $opcionesEstado[$proforma->status] ?? ucfirst(str_replace('_', ' ', $proforma->status)) }}
                            </span>
                            @if ($proforma->motivo_rechazo)
                                <div class="text-[10px] text-red-600 mt-1">{{ $proforma->motivo_rechazo }}</div>
                            @endif
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap text-right">
                            <div class="flex justify-end space-x-2">
                                @if ($proforma->status === 'esperando_verificacion')
                                    <button wire:click="verComprobantes({{ $proforma->id }})"
                                        class="text-indigo-600 hover:text-indigo-900" title="Ver Comprobantes">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                @endif

                                <button wire:click="verDetalles({{ $proforma->id }})"
                                    class="text-gray-600 hover:text-gray-900" title="Ver Detalles">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-xs text-gray-400">
                            <div class="flex flex-col items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mb-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-sm">No hay ventas con el estado seleccionado</p>
                                <p class="text-[11px] mt-1">Intenta cambiar el filtro de estado</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Paginación -->
        <div class="px-6 py-3 border-t border-gray-200">
            {{ $ventas->links() }}
        </div>
    </div>


    <!-- Payment Proof Modal -->
    @if ($modalComprobantesAbierto)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
            <div class="bg-white rounded-xl shadow-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-gray-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-indigo-600"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Comprobantes de pago - {{ $proformaSeleccionada->codigo }}
                        </h2>
                        <button wire:click="cerrarModalComprobantes" class="text-gray-500 hover:text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        @foreach ($comprobantes as $comprobante)
                            <div class="border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                                @if (pathinfo($comprobante->archivo_url, PATHINFO_EXTENSION) === 'pdf')
                                    <div class="bg-gray-100 h-64 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-500"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                        <iframe src="{{ Storage::url($comprobante->archivo_url) }}"
                                            class="w-full h-64 hidden"></iframe>
                                    </div>
                                @else
                                    <img src="{{ Storage::url($comprobante->archivo_url) }}"
                                        class="w-full h-64 object-contain bg-gray-100" alt="Comprobante">
                                @endif
                                <div class="p-3 bg-gray-50 text-center">
                                    <p class="text-xs font-medium text-gray-600 truncate">
                                        {{ basename($comprobante->archivo_url) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if ($proformaSeleccionada->status === 'esperando_verificacion')
                        <div class="border-t pt-6">
                            @if (!$accion)
                                <div class="flex justify-end space-x-4">
                                    <button wire:click="prepararAccion('aprobar')"
                                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        Aprobar Pago
                                    </button>
                                    <button wire:click="prepararAccion('rechazar')"
                                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Rechazar Pago
                                    </button>
                                </div>
                            @elseif($accion === 'rechazar')
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Motivo del
                                            rechazo</label>
                                        <textarea wire:model="motivoRechazo"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500"
                                            rows="3" placeholder="Especifica el motivo del rechazo..."></textarea>
                                        @error('motivoRechazo')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="flex justify-end space-x-4">
                                        <button wire:click="$set('accion', null)"
                                            class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                                            Cancelar
                                        </button>
                                        <button wire:click="confirmarAccion"
                                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition flex items-center">
                                            Confirmar Rechazo
                                        </button>
                                    </div>
                                </div>
                            @elseif($accion === 'aprobar')
                                <div class="py-4 space-y-4">
                                    <div class="text-left">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Método de
                                            Pago</label>
                                        <select wire:model="metodo_pago"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            <option value="" disabled selected>Selecciona un método</option>
                                            <option value="Transferencia">Transferencia</option>
                                            <option value="Yape">Yape</option>
                                            <option value="Plin">Plin</option>
                                            <option value="Otro">Otro</option>
                                        </select>
                                        @error('metodo_pago')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="text-center">
                                        <p class="text-lg font-medium text-gray-700 mb-4">¿Confirmar aprobación del
                                            pago?</p>
                                        <div class="flex justify-center space-x-4">
                                            <button wire:click="$set('accion', null)"
                                                class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                                                Cancelar
                                            </button>
                                            <button wire:click="confirmarAccion"
                                                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center">
                                                Confirmar Aprobación
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <!-- Order Details Modal -->
    @if ($modalDetallesAbierto)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
            <div class="bg-white rounded-xl shadow-xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-gray-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-indigo-600"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            Detalles de Proforma - {{ $proformaSeleccionada->codigo }}
                        </h2>
                        <button wire:click="cerrarModal" class="text-gray-500 hover:text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="space-y-3">
                            <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Información del Cliente</h3>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Nombre</p>
                                <p class="text-gray-900">{{ $proformaSeleccionada->client->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Email</p>
                                <p class="text-gray-900">{{ $proformaSeleccionada->client->email }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Estado</p>
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                                    {{ $opcionesEstado[$proformaSeleccionada->status] ?? $proformaSeleccionada->status }}
                                </span>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Información de la Venta</h3>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Fecha de creación</p>
                                <p class="text-gray-900">{{ $proformaSeleccionada->created_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Fecha de vencimiento</p>
                                <p class="text-gray-900">
                                    {{ optional($proformaSeleccionada->fecha_vencimiento)->format('d/m/Y') ?? 'N/A' }}
                                </p>
                            </div>
                            @if ($proformaSeleccionada->fecha_pago)
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Fecha de pago</p>
                                    <p class="text-gray-900">
                                        {{ $proformaSeleccionada->fecha_pago->format('d/m/Y H:i') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Productos</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left font-medium text-gray-500">Producto</th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-500">Cantidad</th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-500">P. Unitario</th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-500">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($proformaSeleccionada->detailProformas as $detalle)
                                    <tr>
                                        <td class="px-4 py-3 text-gray-900">
                                            {{ $detalle->product->name ?? 'Producto eliminado' }}</td>
                                        <td class="px-4 py-3 text-gray-900">{{ $detalle->quantity }}</td>
                                        <td class="px-4 py-3 text-gray-900">S/.
                                            {{ number_format($detalle->price, 2) }}</td>
                                        <td class="px-4 py-3 text-gray-900">S/.
                                            {{ number_format($detalle->subtotal, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="bg-gray-50">
                                    <td colspan="3" class="px-4 py-3 text-right font-medium text-gray-500">Total:
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-900">S/.
                                        {{ number_format($proformaSeleccionada->total, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button wire:click="cerrarModal"
                            class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
