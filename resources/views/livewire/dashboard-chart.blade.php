<div
    class="{{ $menuAbierto ? 'ml-60' : 'ml-0' }} mt-16 max-w-full mx-auto p-4 bg-white shadow-md rounded-lg transition-all duration-300 ease-in-out">
    <h1 class="text-xl font-bold mb-2 text-gray-800">Dashboard de Ventas</h1>
    <div x-data="{ mostrarFiltros: false }" class="mb-4">
        <!-- Botón de Mostrar/Ocultar -->
        <button @click="mostrarFiltros = !mostrarFiltros"
            class="mb-2 px-3 py-1 text-xs bg-blue-500 text-white rounded hover:bg-blue-600">
            <span x-show="!mostrarFiltros">Mostrar Filtros</span>
            <span x-show="mostrarFiltros">Ocultar Filtros</span>
        </button>

        <!-- Sección de Filtros -->
        <div x-show="mostrarFiltros" x-transition class="bg-white p-3 rounded-lg shadow-sm border border-gray-100">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                <h3 class="text-sm font-semibold text-gray-700">Filtros</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-2 w-full">
                    <!-- Filtro por Fecha -->
                    <div>
                        <input type="date" id="fechaInicio" wire:model="fechaInicio"
                            class="text-xs w-full rounded-md border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-1 px-2">
                    </div>
                    <div>
                        <input type="date" id="fechaFin" wire:model="fechaFin"
                            class="text-xs w-full rounded-md border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-1 px-2">
                    </div>

                    <!-- Filtro por Marca -->
                    <div>
                        <select id="marca" wire:model="marcaSeleccionada"
                            class="text-xs w-full rounded-md border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-1 px-2">
                            <option value="">Todas Marcas</option>
                            @foreach ($marcas as $marca)
                                <option value="{{ $marca->id }}">{{ $marca->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filtro por Categoría -->
                    <div>
                        <select id="categoria" wire:model="categoriaSeleccionada"
                            class="text-xs w-full rounded-md border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-1 px-2">
                            <option value="">Todas Categorías</option>
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}">{{ $categoria->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="flex space-x-2 mt-2 md:mt-0">
                    <button wire:click="aplicarFiltros"
                        class="text-xs px-3 py-1 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        Aplicar
                    </button>
                    <button wire:click="resetearFiltros"
                        class="text-xs px-3 py-1 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200">
                        Resetear
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de KPIs/Contadores Compactos -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 mb-4">
        <!-- Ventas Totales -->
        <div class="bg-white p-3 rounded-lg shadow-sm border border-gray-100">
            <div class="flex items-center space-x-2">
                <div class="bg-blue-50 p-2 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Ventas Totales</p>
                    <p class="text-sm font-semibold text-gray-800">S/. {{ number_format($totalVentas, 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Ventas Promedio -->
        <div class="bg-white p-3 rounded-lg shadow-sm border border-gray-100">
            <div class="flex items-center space-x-2">
                <div class="bg-green-50 p-2 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Venta Promedio</p>
                    <p class="text-sm font-semibold text-gray-800">S/. {{ number_format($ventaPromedio, 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Productos Vendidos -->
        <div class="bg-white p-3 rounded-lg shadow-sm border border-gray-100">
            <div class="flex items-center space-x-2">
                <div class="bg-purple-50 p-2 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-purple-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Productos Vendidos</p>
                    <p class="text-sm font-semibold text-gray-800">{{ number_format($totalProductos) }}</p>
                </div>
            </div>
        </div>

        <!-- Transacciones -->
        <div class="bg-white p-3 rounded-lg shadow-sm border border-gray-100">
            <div class="flex items-center space-x-2">
                <div class="bg-orange-50 p-2 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-orange-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Transacciones</p>
                    <p class="text-sm font-semibold text-gray-800">{{ number_format($totalTransacciones) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos con wire:ignore para evitar que Livewire los modifique -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Ventas Totales -->
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100" wire:ignore.self>
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Ventas Totales por Fecha (S/.)</h3>
            <div class="h-80">
                <canvas id="ventasChart"></canvas>
            </div>
        </div>

        <!-- Ingresos por Marca -->
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100" wire:ignore>
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Ingresos por Marca (S/.)</h3>
            <div class="h-80">
                <canvas id="marcaChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Ingresos por Categoría (Ancho completo) -->
    <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 mb-8" wire:ignore>
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Ingresos por Categoría (S/.)</h3>
        <div class="h-72">
            <canvas id="categoriaChart"></canvas>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('livewire:init', () => {
                Livewire.on('chartsUpdated', (data) => {
                    // Verifica que los datos lleguen correctamente
                    console.log('Datos recibidos:', data);

                    if (data && data.ventas && data.marcas && data.categorias) {
                        dashboardCharts.updateCharts({
                            ventas: data.ventas,
                            marcas: data.marcas,
                            categorias: data.categorias
                        });
                    } else {
                        console.error('Datos incompletos recibidos:', data);
                        dashboardCharts.destroyAllCharts();
                    }
                });
            });

            // Verificación adicional para el inicializado
            document.addEventListener('DOMContentLoaded', () => {
                // Solo intentar inicializar si los elementos canvas existen
                if (document.getElementById('ventasChart') &&
                    document.getElementById('marcaChart') &&
                    document.getElementById('categoriaChart')) {

                    dashboardCharts.init();
                }
            });

            const dashboardCharts = {
                instances: {},
                fontFamily: "'Inter', 'Segoe UI', 'Helvetica', sans-serif",
                colors: {
                    primary: {
                        base: '#4F46E5',
                        light: '#818CF8'
                    },
                    secondary: {
                        base: '#EC4899',
                        light: '#F472B6'
                    },
                    other: ['#0EA5E9', '#F59E0B', '#4F46E5', '#EC4899', '#10B981', '#8B5CF6', '#06B6D4', '#EF4444'],
                    otherHover: ['#38BDF8', '#FBBF24', '#818CF8', '#F472B6', '#34D399', '#A78BFA', '#22D3EE', '#F87171'],
                },

                destroyAllCharts() {
                    Object.keys(this.instances).forEach(chartName => {
                        this.destroyChart(chartName);
                    });
                    this.instances = {};
                },

                destroyChart(name) {
                    if (this.instances[name] && typeof this.instances[name].destroy === 'function') {
                        this.instances[name].destroy();
                        delete this.instances[name];
                        return true;
                    }
                    return false;
                },

                createGradient(ctx, from, to) {
                    const gradient = ctx.createLinearGradient(0, 0, 0, ctx.canvas.height);
                    gradient.addColorStop(0, from);
                    gradient.addColorStop(1, to);
                    return gradient;
                },

                commonOptions() {
                    return {
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: {
                            duration: 1000,
                            easing: 'easeOutQuart'
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                                align: 'end',
                                labels: {
                                    boxWidth: 12,
                                    usePointStyle: true,
                                    pointStyle: 'circle',
                                    padding: 20,
                                    font: {
                                        family: this.fontFamily,
                                        size: 12,
                                        weight: '500'
                                    }
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(17, 24, 39, 0.9)',
                                titleColor: '#F9FAFB',
                                bodyColor: '#E5E7EB',
                                padding: 12,
                                cornerRadius: 8,
                                displayColors: false,
                                usePointStyle: true,
                                callbacks: {
                                    label: ctx => 'S/. ' + ctx.raw.toLocaleString('es-PE', {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    })
                                }
                            },
                            datalabels: {
                                color: '#4B5563',
                                font: {
                                    family: this.fontFamily,
                                    weight: '600',
                                    size: 11
                                },
                                formatter: value => value < 1000 ? 'S/. ' + value.toLocaleString('es-PE') : 'S/. ' + (
                                    value / 1000).toFixed(1) + 'k'
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false,
                                    drawBorder: false
                                },
                                ticks: {
                                    font: {
                                        family: this.fontFamily,
                                        size: 12
                                    },
                                    color: '#6B7280',
                                    padding: 10
                                }
                            },
                            y: {
                                grid: {
                                    color: 'rgba(229, 231, 235, 0.5)',
                                    drawBorder: false
                                },
                                ticks: {
                                    font: {
                                        family: this.fontFamily,
                                        size: 12
                                    },
                                    color: '#6B7280',
                                    padding: 10,
                                    callback: value => value >= 1000 ? 'S/. ' + (value / 1000) + 'k' : 'S/. ' + value
                                },
                                beginAtZero: true
                            }
                        }
                    };
                },

                initVentasChart(data) {
                    const ctx = document.getElementById('ventasChart')?.getContext('2d');
                    if (!ctx) return;

                    // Destruir gráfico existente si hay uno
                    this.destroyChart('ventas');

                    const gradient = this.createGradient(ctx, 'rgba(79, 70, 229, 0.2)', 'rgba(79, 70, 229, 0)');
                    this.instances.ventas = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: Object.keys(data),
                            datasets: [{
                                label: 'Ventas Totales',
                                data: Object.values(data),
                                borderColor: this.colors.primary.base,
                                backgroundColor: gradient,
                                borderWidth: 3,
                                tension: 0.4,
                                pointRadius: 4,
                                pointBackgroundColor: '#fff',
                                pointBorderColor: this.colors.primary.base,
                                pointBorderWidth: 2,
                                pointHoverRadius: 6,
                                pointHoverBackgroundColor: this.colors.primary.base,
                                pointHoverBorderColor: '#fff',
                                pointHoverBorderWidth: 2,
                                fill: true
                            }]
                        },
                        options: {
                            ...this.commonOptions(),
                            plugins: {
                                ...this.commonOptions().plugins,
                                datalabels: {
                                    display: false
                                }
                            },
                            interaction: {
                                mode: 'index',
                                intersect: false
                            },
                            scales: {
                                ...this.commonOptions().scales,
                                y: {
                                    ...this.commonOptions().scales.y,
                                    title: {
                                        display: true,
                                        text: 'Ventas (S/.)',
                                        font: {
                                            family: this.fontFamily,
                                            size: 13,
                                            weight: '500'
                                        },
                                        color: '#6B7280',
                                        padding: {
                                            bottom: 10
                                        }
                                    }
                                }
                            }
                        }
                    });
                },

                initMarcaChart(data) {
                    const ctx = document.getElementById('marcaChart')?.getContext('2d');
                    if (!ctx) return;

                    // Destruir gráfico existente si hay uno
                    this.destroyChart('marca');

                    this.instances.marca = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: Object.keys(data),
                            datasets: [{
                                label: 'Ingresos',
                                data: Object.values(data),
                                backgroundColor: this.colors.secondary.base,
                                hoverBackgroundColor: this.colors.secondary.light,
                                borderRadius: 8,
                                borderSkipped: false,
                                barPercentage: 0.6,
                                categoryPercentage: 0.7
                            }]
                        },
                        options: {
                            ...this.commonOptions(),
                            plugins: {
                                ...this.commonOptions().plugins,
                                legend: {
                                    display: false
                                },
                                datalabels: {
                                    anchor: 'end',
                                    align: 'top',
                                    offset: 4,
                                    display: ctx => ctx.dataIndex < 5
                                }
                            },
                            scales: {
                                ...this.commonOptions().scales,
                                y: {
                                    ...this.commonOptions().scales.y,
                                    title: {
                                        display: true,
                                        text: 'Ingresos (S/.)',
                                        font: {
                                            family: this.fontFamily,
                                            size: 13,
                                            weight: '500'
                                        },
                                        color: '#6B7280',
                                        padding: {
                                            bottom: 10
                                        }
                                    }
                                }
                            }
                        }
                    });
                },

                initCategoriaChart(data) {
                    const ctx = document.getElementById('categoriaChart')?.getContext('2d');
                    if (!ctx) return;

                    // Destruir gráfico existente si hay uno
                    this.destroyChart('categoria');

                    const sortedKeys = Object.keys(data).sort((a, b) => data[b] - data[a]);
                    const topKeys = sortedKeys.slice(0, 8);
                    const topValues = topKeys.map(k => data[k]);

                    this.instances.categoria = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: topKeys,
                            datasets: [{
                                label: 'Ingresos',
                                data: topValues,
                                backgroundColor: topKeys.map((_, i) => this.colors.other[i % this.colors
                                    .other.length]),
                                hoverBackgroundColor: topKeys.map((_, i) => this.colors.otherHover[i % this
                                    .colors.otherHover.length]),
                                borderRadius: 8,
                                borderSkipped: false,
                                barPercentage: 0.75,
                                categoryPercentage: 0.8
                            }]
                        },
                        options: {
                            ...this.commonOptions(),
                            indexAxis: 'y',
                            plugins: {
                                ...this.commonOptions().plugins,
                                legend: {
                                    display: false
                                },
                                datalabels: {
                                    align: 'right',
                                    anchor: 'end',
                                    formatter: value => 'S/. ' + value.toLocaleString('es-PE', {
                                        minimumFractionDigits: 2
                                    }),
                                    color: '#111827',
                                    font: {
                                        weight: '600'
                                    },
                                    padding: {
                                        right: 6
                                    }
                                }
                            },
                            scales: {
                                x: {
                                    ...this.commonOptions().scales.y,
                                    title: {
                                        display: true,
                                        text: 'Ingresos (S/.)',
                                        font: {
                                            family: this.fontFamily,
                                            size: 13,
                                            weight: '500'
                                        },
                                        color: '#6B7280',
                                        padding: {
                                            top: 10
                                        }
                                    }
                                },
                                y: {
                                    ...this.commonOptions().scales.x,
                                    ticks: {
                                        font: {
                                            family: this.fontFamily,
                                            size: 12,
                                            weight: '500'
                                        },
                                        color: '#4B5563'
                                    }
                                }
                            }
                        }
                    });
                },

                updateCharts(data) {
                    // Verificar si hay datos para mostrar
                    const hasData = Object.keys(data.ventas).length > 0 ||
                        Object.keys(data.marcas).length > 0 ||
                        Object.keys(data.categorias).length > 0;

                    if (!hasData) {
                        this.destroyAllCharts();
                        return;
                    }

                    // Destruir todos los gráficos existentes primero
                    this.destroyAllCharts();

                    // Crear nuevos gráficos solo si hay datos
                    if (Object.keys(data.ventas).length > 0) {
                        this.initVentasChart(data.ventas);
                    }
                    if (Object.keys(data.marcas).length > 0) {
                        this.initMarcaChart(data.marcas);
                    }
                    if (Object.keys(data.categorias).length > 0) {
                        this.initCategoriaChart(data.categorias);
                    }
                },

                init() {
                    // Solo inicializar gráficos si los filtros están aplicados
                    if (@json($filtrosAplicados)) {
                        const ventas = @json($ventasPorFecha);
                        const marcas = @json($ingresosPorMarca);
                        const categorias = @json($ingresosPorCategoria);

                        // Verificar si hay datos antes de crear gráficos
                        if (Object.keys(ventas).length > 0) {
                            this.initVentasChart(ventas);
                        }
                        if (Object.keys(marcas).length > 0) {
                            this.initMarcaChart(marcas);
                        }
                        if (Object.keys(categorias).length > 0) {
                            this.initCategoriaChart(categorias);
                        }
                    }
                }
            };

            // Inicialización cuando el DOM está listo
            document.addEventListener('DOMContentLoaded', () => {
                dashboardCharts.init();
            });

            // Escuchar eventos de Livewire
            document.addEventListener('livewire:init', () => {
                Livewire.on('chartsUpdated', (data) => {
                    dashboardCharts.updateCharts(data);
                });
            });

            // Limpiar gráficos cuando el componente se destruye
            document.addEventListener('livewire:before-destroy', () => {
                dashboardCharts.destroyAllCharts();
            });
        </script>
    @endpush


</div>
