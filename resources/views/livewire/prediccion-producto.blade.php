<div
    class="{{ $menuAbierto ? 'ml-60' : 'ml-0' }} mt-16 max-w-7xl mx-auto p-8 bg-gradient-to-br from-blue-50 to-indigo-100 shadow-2xl rounded-2xl transition-all duration-300 ease-in-out">
    <form wire:submit.prevent="obtenerPrediccion" class="space-y-6">
        <!-- Sección de búsqueda de producto -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            <!-- Buscador de productos mejorado -->
            <div class="relative z-0 w-full group">
                <label for="productSearch" class="block text-sm font-medium text-gray-700 mb-1">Buscar Producto</label>
                <div class="relative mt-1">
                    <div class="flex items-center">
                        <input type="text" id="productSearch" wire:model="search"
                            wire:keyup.debounce.300ms="searchProduct" wire:keydown.enter.prevent
                            placeholder="Escribe para buscar productos..."
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                            autocomplete="off" />
                        <div class="absolute right-3 top-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>

                    @if ($showlist && !$productoSeleccionado && count($resultsProduct) > 0)
                        <ul
                            class="absolute z-10 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden divide-y divide-gray-200 max-h-72 overflow-y-auto">
                            @foreach ($resultsProduct as $product)
                                <li wire:click="selectProduct({{ $product->id }}, '{{ $product->name }}')"
                                    class="px-4 py-3 cursor-pointer hover:bg-indigo-50 transition flex items-center">
                                    <span class="flex-1">{{ $product->name }}</span>
                                    <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">ID:
                                        {{ $product->id }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                @if ($selectedProductName)
                    <div class="mt-2 flex items-center">
                        <span class="text-sm text-gray-600 mr-2">Producto seleccionado:</span>
                        <span class="font-semibold text-indigo-700">{{ $selectedProductName }}</span>
                        <button wire:click="clearProduct" class="ml-2 text-red-500 hover:text-red-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                @endif

                @error('productoId')
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Campo Año mejorado -->
            <div class="relative">
                <label for="anio" class="block text-sm font-medium text-gray-700 mb-1">Año</label>
                <div class="relative">
                    <input wire:model="anio" type="number" min="2000" max="2100" id="anio"
                        autocomplete="off"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 @error('anio') border-red-500 @enderror"
                        placeholder="Ej: 2023" />
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <span class="text-gray-500">📅</span>
                    </div>
                </div>
                @error('anio')
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Campo Mes Inicio mejorado -->
            <div class="relative">
                <label for="mesInicio" class="block text-sm font-medium text-gray-700 mb-1">Mes Inicio</label>
                <select wire:model="mesInicio" id="mesInicio"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 @error('mesInicio') border-red-500 @enderror">
                    <option value="">Seleccione un mes</option>
                    @foreach (range(1, 12) as $month)
                        <option value="{{ $month }}">{{ DateTime::createFromFormat('!m', $month)->format('F') }}
                        </option>
                    @endforeach
                </select>
                @error('mesInicio')
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Campo Meses a predecir mejorado -->
            <div class="relative">
                <label for="meses" class="block text-sm font-medium text-gray-700 mb-1">Meses a predecir</label>
                <div class="relative">
                    <input wire:model="meses" type="number" min="1" max="24" id="meses"
                        autocomplete="off"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 @error('meses') border-red-500 @enderror"
                        placeholder="Ej: 6" />
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <span class="text-gray-500 text-sm">meses</span>
                    </div>
                </div>
                @error('meses')
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        <!-- Sección de botones -->
        <div class="flex items-center space-x-4 mt-8">
            <button type="submit" wire:loading.attr="disabled"
                class="relative overflow-hidden bg-gradient-to-r from-indigo-600 to-blue-600 text-white font-semibold px-8 py-3 rounded-lg hover:from-indigo-700 hover:to-blue-700 focus:ring-4 focus:ring-blue-300 transition-all duration-300 shadow-lg hover:shadow-xl disabled:opacity-70 flex items-center justify-center min-w-48">
                <span wire:loading.remove wire:target="obtenerPrediccion">
                    Obtener Predicción
                </span>
                <span wire:loading wire:target="obtenerPrediccion" class="flex items-center">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                    Procesando...
                </span>
            </button>

            <button type="button" wire:click="resetForm"
                class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-all duration-200">
                Limpiar formulario
            </button>
        </div>

        <!-- Mensajes de error -->
        @if ($errorApi)
            <div class="mt-6 p-4 border-l-4 border-red-500 bg-red-50 rounded-r-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Error al obtener la predicción</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <p>{{ $errorApi }}</p>
                        </div>
                        <div class="mt-4">
                            <button type="button" wire:click="clearError"
                                class="text-sm font-medium text-red-700 hover:text-red-600 focus:outline-none transition">
                                Cerrar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if (!empty($predicciones))
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <!-- Demanda promedio -->
                <div class="bg-white p-4 rounded-lg shadow border border-gray-100">
                    <h3 class="text-sm font-medium text-gray-500">Demanda Promedio</h3>
                    <p class="mt-1 text-2xl font-semibold text-indigo-600">
                        {{ number_format(array_sum(array_column($predicciones, 'demanda')) / count($predicciones), 2) }}
                    </p>
                </div>

                <!-- Máxima demanda -->
                <div class="bg-white p-4 rounded-lg shadow border border-gray-100">
                    <h3 class="text-sm font-medium text-gray-500">Máxima Demanda</h3>
                    <p class="mt-1 text-2xl font-semibold text-red-600">
                        {{ max(array_column($predicciones, 'demanda')) }}
                        <span class="text-sm font-normal text-gray-500">
                            (Mes:
                            {{ $predicciones[array_search(max(array_column($predicciones, 'demanda')), array_column($predicciones, 'demanda'))]['mes'] }})
                        </span>
                    </p>
                </div>

                <!-- Tendencia general -->
                <div class="bg-white p-4 rounded-lg shadow border border-gray-100">
                    <h3 class="text-sm font-medium text-gray-500">Tendencia General</h3>
                    @php
                        $first = (float) $predicciones[0]['demanda'];
                        $last = (float) $predicciones[count($predicciones) - 1]['demanda'];
                        $trend = (($last - $first) / $first) * 100;
                    @endphp
                    <p class="mt-1 text-2xl font-semibold {{ $trend >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ round($trend, 2) }}%
                        @if ($trend >= 0)
                            <span class="text-green-500">▲</span>
                        @else
                            <span class="text-red-500">▼</span>
                        @endif
                    </p>
                </div>
            </div>
        @endif
        <!-- Loading state -->
        @if ($cargando)
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
                <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full">
                    <div class="flex items-center justify-center space-x-2">
                        <svg class="animate-spin h-8 w-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <span class="text-gray-700 font-medium">Calculando predicciones...</span>
                    </div>
                    <p class="mt-2 text-sm text-gray-500 text-center">Esto puede tomar unos segundos</p>
                </div>
            </div>
        @endif

        <!-- Error handling -->
        @if ($errorApi)
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">{{ $errorApi }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Resultados de predicción -->
        @if (!empty($predicciones))
            <div class="mt-12">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Resultados de Predicción</h2>
                    <button wire:click="exportToExcel"
                        class="flex items-center text-sm text-green-600 hover:text-green-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Exportar a Excel
                    </button>
                </div>

                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <!-- Cambia el encabezado de la tabla para ser más descriptivo -->
                            <thead class="bg-gradient-to-r from-indigo-600 to-blue-600">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                        Mes/Año
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                        Demanda Estimada (unidades)
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                        Variación Mensual
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($predicciones as $item)
                                    <tr class="hover:bg-blue-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $item['mes'] ?? 'N/A' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-700 font-semibold">
                                                {{ $item['demanda'] ?? 'N/A' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if (isset($item['tendencia']) && $item['tendencia'] > 0)
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    ▲ {{ $item['tendencia'] }}%
                                                </span>
                                            @elseif(isset($item['tendencia']) && $item['tendencia'] < 0)
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    ▼ {{ abs($item['tendencia']) }}%
                                                </span>
                                            @else
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                    →
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Solo la parte del gráfico (puedes colocarlo donde necesites) -->
                @if (!empty($predicciones) && count($predicciones) > 1)
                    <div class="mt-8 bg-white p-6 rounded-xl shadow-lg border border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Gráfico de Tendencia</h3>
                        <div wire:ignore class="h-64">
                            <canvas id="predictionChart"></canvas>
                        </div>
                    </div>

                    @push('scripts')
                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                        <script>
                            document.addEventListener('livewire:load', function() {
                                // Escuchar eventos de Livewire para actualizar el gráfico
                                Livewire.on('prediccionesActualizadas', function(data) {
                                    renderChart(data);
                                });

                                // Función para renderizar/actualizar el gráfico
                                function renderChart(data) {
                                    const ctx = document.getElementById('predictionChart').getContext('2d');
                                    const labels = data.map(item => item.mes);
                                    const values = data.map(item => item.demanda);

                                    // Destruir el gráfico anterior si existe
                                    if (window.predictionChart) {
                                        window.predictionChart.destroy();
                                    }

                                    // Crear nuevo gráfico
                                    window.predictionChart = new Chart(ctx, {
                                        type: 'line',
                                        data: {
                                            labels: labels,
                                            datasets: [{
                                                label: 'Demanda Estimada',
                                                data: values,
                                                borderColor: '#4f46e5',
                                                backgroundColor: 'rgba(79, 70, 229, 0.1)',
                                                borderWidth: 2,
                                                tension: 0.3,
                                                fill: true
                                            }]
                                        },
                                        // Modifica las opciones del gráfico para mejor visualización
                                        options: {
                                            responsive: true,
                                            maintainAspectRatio: false,
                                            plugins: {
                                                legend: {
                                                    position: 'top',
                                                },
                                                tooltip: {
                                                    mode: 'index',
                                                    intersect: false,
                                                    callbacks: {
                                                        label: function(context) {
                                                            let label = context.dataset.label || '';
                                                            if (label) {
                                                                label += ': ';
                                                            }
                                                            label += context.parsed.y.toFixed(2);
                                                            return label;
                                                        }
                                                    }
                                                }
                                            },
                                            scales: {
                                                y: {
                                                    beginAtZero: false,
                                                    title: {
                                                        display: true,
                                                        text: 'Unidades Estimadas'
                                                    }
                                                },
                                                x: {
                                                    title: {
                                                        display: true,
                                                        text: 'Período'
                                                    }
                                                }
                                            }
                                        }
                                    });
                                }

                                // Renderizar gráfico inicial si hay datos
                                @this.on('prediccionesActualizadas', (data) => {
                                    renderChart(data);
                                });

                                // Opcional: Si ya hay datos al cargar la página
                                @if (!empty($predicciones))
                                    renderChart(@json($predicciones));
                                @endif
                            });
                        </script>
                    @endpush
                @endif
            </div>
        @endif
    </form>
</div>
