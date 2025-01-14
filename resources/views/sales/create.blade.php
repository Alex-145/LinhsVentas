<x-app-layout>
    <div class="container">
        <h1 class="text-2xl font-bold mb-4">Crear Nueva Venta</h1>

        <form action="{{ route('sales.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="cliente" class="block text-sm font-medium text-gray-700">Cliente</label>
                @livewire('cliente-autocomplete')
            </div>

            <!-- Agrega aquí los demás campos del formulario de venta -->

            <div class="mt-4">
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">
                    Crear Venta
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
