<div>
    <form wire:submit.prevent="obtenerPrediccion" class="space-y-4">
        <!-- Sección de búsqueda de producto -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- Buscador de productos -->
            <div class="relative">
                <label for="productSearch" class="block text-sm font-medium text-gray-700 mb-1">Producto</label>
                <input type="text" id="productSearch" wire:model="search" wire:keyup.debounce.300ms="searchProduct"
                    placeholder="Buscar producto..."
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    autocomplete="off" />

                @if ($showlist && !$productoSeleccionado && count($resultsProduct) > 0)
                    <ul
                        class="absolute z-10 w-full mt-1 bg-white border border-gray-200 rounded-md shadow-lg max-h-60 overflow-y-auto">
                        @foreach ($resultsProduct as $product)
                            <li wire:click="selectProduct({{ $product->id }}, '{{ $product->name }}')"
                                class="px-3 py-2 cursor-pointer hover:bg-indigo-50 text-sm">
                                {{ $product->name }}
                            </li>
                        @endforeach
                    </ul>
                @endif

                @if ($selectedProductName)
                    <div class="mt-1 text-sm text-gray-600 flex items-center">
                        <span>{{ $selectedProductName }}</span>
                        <button wire:click="clearProduct" class="ml-2 text-red-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                @endif
                @error('productoId')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Campo Año -->
            <div>
                <label for="anio" class="block text-sm font-medium text-gray-700 mb-1">Año</label>
                <input wire:model="anio" type="number" min="2000" max="2100" id="anio"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Ej: 2023" />
                @error('anio')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Campo Mes Inicio -->
            <div>
                <label for="mesInicio" class="block text-sm font-medium text-gray-700 mb-1">Mes Inicio</label>
                <select wire:model="mesInicio" id="mesInicio"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Seleccione mes</option>
                    @foreach (range(1, 12) as $month)
                        <option value="{{ $month }}">{{ DateTime::createFromFormat('!m', $month)->format('F') }}
                        </option>
                    @endforeach
                </select>
                @error('mesInicio')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Campo Meses a predecir -->
            <div>
                <label for="meses" class="block text-sm font-medium text-gray-700 mb-1">Meses a predecir</label>
                <input wire:model="meses" type="number" min="1" max="24" id="meses"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Ej: 6" />
                @error('meses')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Sección de botones -->
        <div class="flex items-center space-x-3">
            <button type="submit" wire:loading.attr="disabled"
                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <span wire:loading.remove wire:target="obtenerPrediccion">Obtener Predicción</span>
                <span wire:loading wire:target="obtenerPrediccion">Procesando...</span>
            </button>

            <button type="button" wire:click="resetForm"
                class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                Limpiar
            </button>
        </div>

        <!-- Mensajes de error -->
        @if ($errorApi)
            <div class="p-3 bg-red-50 text-red-700 rounded-md">
                {{ $errorApi }}
                <button wire:click="clearError" class="float-right font-bold">&times;</button>
            </div>
        @endif

        <!-- Resultados y gráfico (se mantiene igual que en el original) -->
        @if (!empty($predicciones))
            <div class="mt-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-gray-800">Resultados</h2>
                    <button wire:click="generateChart"
                        class="px-3 py-1 bg-green-50 text-green-700 rounded-md border border-green-200">
                        Generar Gráfico
                    </button>
                </div>

                <!-- Gráfico (se mantiene igual) -->
                <div wire:ignore class="h-96 bg-white p-4 rounded-md shadow border border-gray-100 mb-6">
                    <canvas id="predictionChart"></canvas>
                </div>

                <!-- Tabla de resultados (simplificada) -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Mes/Año</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Demanda</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Variación
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($predicciones as $item)
                                <tr>
                                    <td class="px-4 py-2 text-sm">{{ $item['mes'] ?? 'N/A' }}</td>
                                    <td class="px-4 py-2 text-sm font-medium">{{ $item['demanda'] ?? 'N/A' }}</td>
                                    <td class="px-4 py-2 text-sm">
                                        @if (isset($item['tendencia']) && $item['tendencia'] > 0)
                                            <span class="text-green-600">▲ {{ $item['tendencia'] }}%</span>
                                        @elseif(isset($item['tendencia']) && $item['tendencia'] < 0)
                                            <span class="text-red-600">▼ {{ abs($item['tendencia']) }}%</span>
                                        @else
                                            <span class="text-gray-500">→</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <!-- Loading state (simplificado) -->
        @if ($cargando)
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center">
                <div class="bg-white p-4 rounded-md shadow">
                    <p class="text-gray-700">Calculando predicciones...</p>
                </div>
            </div>
        @endif
    </form>

    <!-- Scripts del gráfico (se mantienen igual) -->
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('livewire:init', function() {
                let predictionChart = null;
                let chartInitialized = false;

                function initializeChart() {
                    const ctx = document.getElementById('predictionChart');
                    if (!ctx) return false;

                    if (predictionChart) predictionChart.destroy();

                    predictionChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: [],
                            datasets: []
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'top'
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: false,
                                    title: {
                                        display: true,
                                        text: 'Unidades'
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

                    chartInitialized = true;
                    return true;
                }

                function updateChart(data) {
                    if (!chartInitialized && !initializeChart()) return;

                    const labels = data.map(item => item.mes || '');
                    const values = data.map(item => {
                        const num = Number(item.valor_numerico);
                        return isNaN(num) ? 0 : num;
                    });

                    predictionChart.data.labels = labels;
                    predictionChart.data.datasets = [{
                        label: 'Demanda Estimada',
                        data: values,
                        borderColor: '#4f46e5',
                        backgroundColor: 'rgba(79, 70, 229, 0.1)',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true
                    }];

                    predictionChart.update('none');
                }

                Livewire.on('prediccionesActualizadas', (event) => {
                    let dataToRender = Array.isArray(event) ? event : (event?.predicciones || []);
                    updateChart(dataToRender);
                });

                Livewire.hook('component.initialized', (component) => {
                    initializeChart();
                    if (component.serverMemo?.data?.predicciones) {
                        updateChart(component.serverMemo.data.predicciones);
                    }
                });
            });
        </script>
    @endpush
</div>
