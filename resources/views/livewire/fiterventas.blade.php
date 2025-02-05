<div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        @foreach (['startDate' => 'Fecha de Inicio', 'endDate' => 'Fecha de Fin'] as $field => $label)
            <div>
                <label for="{{ $field }}"
                    class="block text-sm font-medium text-gray-700 mb-2">{{ $label }}:</label>
                <input type="date" wire:model="{{ $field }}" id="{{ $field }}"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
            </div>
        @endforeach
    </div>
    <div class="space-y-2">
        <button wire:click="filterByDate"
            class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-md transition duration-300 ease-in-out transform hover:scale-105">
            Filtrar por rango
        </button>
        <button wire:click="filterThisWeek"
            class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-md transition duration-300 ease-in-out transform hover:scale-105">
            Filtrar por esta semana
        </button>
        <button wire:click="filterThisMonth"
            class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-md transition duration-300 ease-in-out transform hover:scale-105">
            Filtrar por este mes
        </button>
        <!-- Botón para activar/desactivar el filtro de ventas facturadas -->
        <button wire:click="$toggle('filterFacturado')"
            class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md transition duration-300 ease-in-out transform hover:scale-105">
            {{ $filterFacturado ? 'Desactivar filtro facturadas' : 'Activar filtro facturadas' }}
        </button>
        <!-- Botón para activar/desactivar el filtro pendiente facturación -->
        <button wire:click="$toggle('filterPendienteFacturacion')"
            class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-md transition duration-300 ease-in-out transform hover:scale-105">
            {{ $filterPendienteFacturacion ? 'Desactivar filtro pendiente facturación' : 'Activar filtro pendiente facturación' }}
        </button>
        <button wire:click="$toggle('filterNoAplicable')"
            class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-md transition duration-300 ease-in-out transform hover:scale-105">
            {{ $filterNoAplicable ? 'Desactivar filtro no_aplicable' : 'Activar filtro no_aplicable' }}
        </button>
    </div>
</div>
