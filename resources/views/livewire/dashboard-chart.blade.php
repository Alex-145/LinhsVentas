<div
    class="{{ $menuAbierto ? 'ml-60' : 'ml-0' }} mt-16 max-w-full mx-auto p-4 bg-white shadow-md rounded-lg transition-all duration-300 ease-in-out">

    <h1 class="text-xl font-bold mb-4 text-center">Dashboard de Ventas</h1>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Ventas por Fecha --}}
        <div class="bg-gray-50 p-4 rounded-lg shadow">
            <h3 class="text-base font-semibold mb-2">Historial de Ventas</h3>
            <canvas id="ventasChart" class="w-full h-64"></canvas>
        </div>

        {{-- Ingresos por Marca --}}
        <div class="bg-gray-50 p-4 rounded-lg shadow">
            <h3 class="text-base font-semibold mb-2">Ingresos por Marca</h3>
            <canvas id="marcaChart" class="w-full h-64"></canvas>
        </div>

        {{-- Ingresos por Categoría --}}
        <div class="bg-gray-50 p-4 rounded-lg shadow col-span-1 md:col-span-2">
            <h3 class="text-base font-semibold mb-2">Ingresos por Categoría</h3>
            <canvas id="categoriaChart" class="w-full h-64"></canvas>
        </div>
    </div>

    <script>
        new Chart(document.getElementById('ventasChart'), {
            type: 'line',
            data: {
                labels: @json(array_keys($ventasPorFecha)),
                datasets: [{
                    label: 'Ventas Totales',
                    data: @json(array_values($ventasPorFecha)),
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true
            }
        });

        new Chart(document.getElementById('marcaChart'), {
            type: 'bar',
            data: {
                labels: @json(array_keys($ingresosPorMarca)),
                datasets: [{
                    label: 'Ingresos por Marca',
                    data: @json(array_values($ingresosPorMarca)),
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                }]
            },
            options: {
                responsive: true
            }
        });

        new Chart(document.getElementById('categoriaChart'), {
            type: 'bar',
            data: {
                labels: @json(array_keys($ingresosPorCategoria)),
                datasets: [{
                    label: 'Ingresos por Categoría',
                    data: @json(array_values($ingresosPorCategoria)),
                    backgroundColor: 'rgba(255, 206, 86, 0.6)',
                }]
            },
            options: {
                responsive: true
            }
        });
    </script>
</div>
