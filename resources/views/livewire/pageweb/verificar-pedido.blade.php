<div>
    @if (session()->has('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4 max-w-xl mx-auto mt-6 text-center">
            {{ session('success') }}
        </div>
    @endif

    @if ($mensaje_error)
        <div class="text-red-600 font-semibold text-center mt-10">
            {{ $mensaje_error }}
        </div>
    @endif

    @if ($proforma && !$mensaje_error)
        <div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6 space-y-6">
            <h2 class="text-2xl font-bold text-indigo-700 text-center">Resumen de su Pedido</h2>

            <div class="grid md:grid-cols-2 gap-4 text-sm text-gray-700">
                <div>
                    <p><span class="font-semibold">Cliente:</span> {{ $proforma->client->name }}</p>
                    <p><span class="font-semibold">DNI:</span> {{ $proforma->client->dni }}</p>
                    <p><span class="font-semibold">Correo:</span> {{ $proforma->client->email ?? 'No registrado' }}</p>
                    <p><span class="font-semibold">Teléfono:</span>
                        {{ $proforma->client->phone_number ?? 'No registrado' }}</p>
                </div>
                <div>
                    <p><span class="font-semibold">Código de Pedido:</span> {{ $proforma->codigo }}</p>
                    <p><span class="font-semibold">Factura:</span> {{ $proforma->factura === 'si' ? 'Sí' : 'No' }}</p>
                    <p><span class="font-semibold">Vence el:</span> {{ $proforma->fecha_vencimiento->format('d/m/Y') }}
                    </p>
                    <p><span class="font-semibold">Total:</span> S/. {{ number_format($proforma->total, 2) }}</p>
                </div>
            </div>

            {{-- Línea de tiempo del estado --}}
            <div class="border-t pt-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Estado del Pedido</h3>
                @php
                    $estados = [
                        'esperando_pago' => 'Esperando Pago',
                        'esperando_verificacion' => 'Verificando Comprobante',
                        'pagado' => 'Verificado',
                        'cerrado' => 'Completado',
                    ];
                    $orden = array_keys($estados);
                @endphp

                <div class="flex items-center justify-between text-xs md:text-sm mt-4">
                    @foreach ($orden as $estado)
                        <div class="flex-1 text-center relative">
                            <div
                                class="h-2 w-2 mx-auto rounded-full
                                {{ $proforma->status === $estado
                                    ? 'bg-blue-600 animate-pulse'
                                    : (array_search($estado, $orden) <= array_search($proforma->status, $orden)
                                        ? 'bg-green-500'
                                        : 'bg-gray-300') }}">
                            </div>
                            <p
                                class="mt-2 {{ $proforma->status === $estado ? 'font-bold text-blue-700' : 'text-gray-600' }}">
                                {{ $estados[$estado] }}
                            </p>
                            @if (!$loop->last)
                                <div class="absolute top-1 left-1/2 w-full h-0.5 bg-gray-200 z-[-1]"></div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Detalle de productos --}}
            <div class="border-t pt-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Detalle de Productos</h3>
                <ul class="divide-y divide-gray-200 text-sm">
                    @foreach ($proforma->detailProformas as $detalle)
                        @php
                            $producto = \App\Models\Product::find($detalle->product_id);
                        @endphp
                        @if ($producto)
                            <li class="py-2 flex justify-between">
                                <div>
                                    <p class="font-semibold">{{ $producto->name }}</p>
                                    <p class="text-gray-500">Cantidad: {{ $detalle->quantity }} | Precio: S/.
                                        {{ number_format($detalle->price, 2) }}</p>
                                </div>
                                <div class="text-right font-semibold text-gray-800">
                                    S/. {{ number_format($detalle->subtotal, 2) }}
                                </div>
                            </li>
                        @else
                            <li class="py-2 text-red-500">Producto no disponible (ID: {{ $detalle->product_id }})</li>
                        @endif
                    @endforeach
                </ul>
            </div>

            {{-- Subir comprobantes --}}
            @if ($proforma->status === 'esperando_pago')
                <form wire:submit.prevent="subirComprobante" enctype="multipart/form-data" class="mt-6">
                    <label class="block text-sm font-semibold mb-2">Subir Comprobantes (JPG, PNG, PDF):</label>

                    <input type="file" wire:model="archivos_comprobantes" multiple
                        class="w-full border border-gray-300 rounded p-2">

                    @error('archivos_comprobantes.*')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    @if (count($archivos_subidos) > 0)
                        <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach ($archivos_subidos as $index => $archivo)
                                <div class="border rounded p-2 text-center bg-gray-50 shadow-sm relative">
                                    @if (in_array($archivo->getClientOriginalExtension(), ['jpg', 'jpeg', 'png']))
                                        <img src="{{ $archivo->temporaryUrl() }}"
                                            class="mx-auto h-24 object-contain rounded">
                                    @else
                                        <i class="fas fa-file-pdf text-red-500 text-4xl mb-2"></i>
                                    @endif
                                    <p class="text-xs mt-1 truncate">{{ $archivo->getClientOriginalName() }}</p>
                                    <button type="button" wire:click="eliminarArchivo({{ $index }})"
                                        class="absolute top-0 right-0 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs">
                                        &times;
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <button type="submit" class="mt-4 w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">
                        Enviar Comprobantes
                    </button>
                </form>
            @elseif ($proforma->status === 'esperando_verificacion')
                <div class="mt-6 p-4 bg-blue-50 text-blue-800 rounded-lg text-center">
                    <p class="font-semibold">Hemos recibido tus comprobantes</p>
                    <p>Estamos verificando tu pago. Te notificaremos cuando se complete la verificación.</p>
                </div>
            @endif
        </div>
    @endif
</div>
