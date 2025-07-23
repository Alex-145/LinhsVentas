<div class="p-4">

    {{-- FILTROS --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
        <div>
            <label>Fecha Inicio</label>
            <input type="date" wire:model="fechaInicio" class="w-full border px-2 py-1 rounded">
        </div>
        <div>
            <label>Fecha Fin</label>
            <input type="date" wire:model="fechaFin" class="w-full border px-2 py-1 rounded">
        </div>
        <div>
            <label>Marca</label>
            <select wire:model="marcaSeleccionada" class="w-full border px-2 py-1 rounded">
                <option value="">-- Todas --</option>
                @foreach ($marcas as $marca)
                    <option value="{{ $marca->id }}">{{ $marca->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Categoría</label>
            <select wire:model="categoriaSeleccionada" class="w-full border px-2 py-1 rounded">
                <option value="">-- Todas --</option>
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id }}">{{ $categoria->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- BOTONES --}}
    <div class="mb-6">
        <button wire:click="aplicarFiltros" class="bg-blue-500 text-white px-4 py-2 rounded mr-2">Aplicar</button>
        <button wire:click="resetearFiltros" class="bg-gray-400 text-white px-4 py-2 rounded">Resetear</button>
    </div>

    {{-- KPIs --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white shadow rounded p-4 text-center">
            <h3 class="text-gray-600">Total Ventas</h3>
            <p class="text-xl font-bold text-green-600">S/ {{ number_format($totalVentas, 2) }}</p>
        </div>
        <div class="bg-white shadow rounded p-4 text-center">
            <h3 class="text-gray-600">Transacciones</h3>
            <p class="text-xl font-bold">{{ $totalTransacciones }}</p>
        </div>
        <div class="bg-white shadow rounded p-4 text-center">
            <h3 class="text-gray-600">Venta Promedio</h3>
            <p class="text-xl font-bold">S/ {{ number_format($ventaPromedio, 2) }}</p>
        </div>
        <div class="bg-white shadow rounded p-4 text-center">
            <h3 class="text-gray-600">Total Productos</h3>
            <p class="text-xl font-bold">{{ $totalProductos }}</p>
        </div>
    </div>

    {{-- GRÁFICOS --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white shadow rounded p-4">
            <h3 class="text-center font-bold mb-2">Ventas por Fecha</h3>
            <canvas id="ventasChart"></canvas>
        </div>
        <div class="bg-white shadow rounded p-4">
            <h3 class="text-center font-bold mb-2">Ingresos por Marca</h3>
            <canvas id="marcasChart"></canvas>
        </div>
        <div class="bg-white shadow rounded p-4 col-span-1 lg:col-span-2">
            <h3 class="text-center font-bold mb-2">Ingresos por Categoría</h3>
            <canvas id="categoriasChart"></canvas>
        </div>
    </div>

</div>



{{-- SCRIPT PARA LOS GRÁFICOS --}}
<script>
    let ventasChart, marcasChart, categoriasChart;

    window.addEventListener('chartsUpdated', event => {
        const {
            ventas,
            marcas,
            categorias
        } = event.detail;

        renderChart('ventasChart', 'Ventas por Fecha', ventas, 'bar', chart => ventasChart = chart);
        renderChart('marcasChart', 'Ingresos por Marca', marcas, 'pie', chart => marcasChart = chart);
        renderChart('categoriasChart', 'Ingresos por Categoría', categorias, 'doughnut', chart =>
            categoriasChart = chart);
    });

    function renderChart(id, label, data, type, setChartRef) {
        const ctx = document.getElementById(id)?.getContext('2d');
        if (!ctx) return;

        // 🔐 Verificamos que realmente sea un gráfico antes de destruirlo
        if (window[id] instanceof Chart) {
            window[id].destroy();
        }

        const chart = new Chart(ctx, {
            type: type,
            data: {
                labels: Object.keys(data),
                datasets: [{
                    label: label,
                    data: Object.values(data),
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(153, 102, 255, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 159, 64, 0.5)',
                    ],
                    borderColor: 'rgba(0, 0, 0, 0.1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    title: {
                        display: true,
                        text: label
                    }
                },
                scales: type === 'bar' ? {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Soles (S/.)'
                        }
                    }
                } : {}
            }
        });

        window[id] = chart;
        setChartRef(chart);
    }
</script>
