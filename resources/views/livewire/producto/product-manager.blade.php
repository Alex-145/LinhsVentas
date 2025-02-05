<div class="{{ $menuAbierto ? 'ml-60' : 'ml-0' }} mt-16 max-w-full sm:max-w-7xl mx-auto p-6 bg-gradient-to-br from-blue-50 to-indigo-100 shadow-xl rounded-xl transition-all duration-300 ease-in-out">

    <!-- Success Message -->
    @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <!-- Modal de confirmación -->
    <div x-data="{ open: @entangle('showConfirmModal') }" x-show="open" @keydown.window.escape="open = false"
        class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white w-full max-w-sm mx-4 rounded-lg p-6 shadow-md">
            <div class="text-center">
                <h3 class="text-lg font-semibold mb-4">¿Estás seguro de que deseas eliminar este producto?</h3>
                <p class="mb-4 text-sm text-gray-600">Esta acción no se puede deshacer.</p>

                <div class="flex justify-center gap-4">
                    <button @click="open = false"
                        class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md focus:outline-none">Cancelar</button>
                    <button wire:click="destroy"
                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md focus:outline-none">Eliminar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Button to create a new product -->
    <div class="text-center mb-8">
        <button wire:click="create"
            class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-md transition duration-300 ease-in-out transform hover:scale-105 flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
            </svg>
            Crear Nuevo Producto
        </button>
    </div>

    <!-- Search Field -->
    <div class="mb-6">
        <input type="text" wire:model="searchTerm" wire:keydown.debounce.300ms="resetPage"
            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-3"
            placeholder="Buscar productos...">
    </div>

    @if ($isOpen)
        @include('livewire.producto.product-modal')
    @endif

    <!-- Products Table -->
    <div class="overflow-x-auto bg-white shadow-md rounded-lg mt-6">
        <table class="min-w-full bg-white border border-gray-300 shadow-md rounded-lg overflow-hidden">
            <thead class="bg-gradient-to-r from-indigo-600 to-indigo-800 text-white">
                <tr>
                    @foreach (['Nombre', 'Precio de Compra', 'Precio de Venta', 'Utilidad', 'Stock', 'Acciones'] as $header)
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">
                            {{ $header }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr class="border-b hover:bg-gray-100 transition duration-200">
                        <td class="px-4 py-2 text-gray-800">{{ $product->name }}</td>
                        <td class="px-4 py-2 text-gray-800">S/.{{ $product->purchase_price }}</td>
                        <td class="px-4 py-2 text-gray-800">S/.{{ $product->sale_price }}</td>
                        <td class="px-4 py-2 text-gray-800">S/.{{ $product->profit }}</td>
                        <td class="px-4 py-2 text-gray-800">{{ $product->stock }}</td>
                        <td class="px-4 py-3 text-sm text-gray-800 flex items-center space-x-4">
                            <button wire:click="edit({{ $product->id }})"
                                class="text-indigo-600 hover:text-indigo-900 transition-colors duration-200 flex items-center">
                                <i class="fas fa-edit" style="font-size: 18px;"></i> <!-- Icono de editar -->
                            </button>
                            <button wire:click="openPhotoModal({{ $product->id }})"
                                class="text-indigo-600 hover:text-indigo-900 transition-colors duration-200 flex items-center">
                                <i class="fas fa-camera" style="font-size: 18px; color: black;"></i> <!-- Icono de cámara en negro -->
                            </button>
                            <button wire:click="confirmStatusChange({{ $product->id }})"
                                class="transition-colors duration-200 flex items-center"
                                style="color: {{ $product->status == 'published' ? 'red' : 'green' }};">
                                <i class="fas fa-eye" style="font-size: 18px;"></i> <!-- Icono de ojo -->
                            </button>
                            <button wire:click="confirmDelete({{ $product->id }})"
                                class="text-red-600 hover:text-red-900 transition-colors duration-200 flex items-center">
                                <i class="fa-regular fa-trash-can" style="font-size: 18px;"></i> <!-- Icono de basurero -->
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal para cambiar foto -->
    <div x-data="{ open: @entangle('photoModalOpen') }" x-show="open" @keydown.window.escape="open = false"
        class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white w-full max-w-md mx-4 rounded-lg p-4 shadow-md">
            <div class="text-right">
                <button @click="open = false"
                    class="text-gray-500 hover:text-gray-700 text-xl font-bold">&times;</button>
            </div>
            <h2 class="text-lg font-bold mb-4">Cambiar Foto del Producto</h2>
            <div class="text-center">
                @if ($photo_url_old)
                    <img src="{{ asset('storage/' . $photo_url_old) }}" alt="Foto actual"
                        class="w-48 h-48 object-cover mx-auto rounded mb-4">
                @endif
                <input type="file" wire:model="photo_url" class="form-input w-full mb-4" />
                <button wire:click="savePhoto"
                    class="bg-green-600 text-white text-sm py-2 px-6 rounded-lg shadow-md hover:bg-green-700 focus:outline-none focus:ring focus:ring-green-300">Guardar
                    Foto</button>
            </div>
        </div>
    </div>

    @if ($confirmingStatusChange)
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center">
            <div class="bg-white rounded-lg shadow-lg p-6 w-1/3">
                <h2 class="text-xl font-semibold mb-4">
                    ¿Estás seguro de que deseas cambiar el estado de este producto?
                </h2>
                <p class="text-gray-700 mb-6">
                    El producto será {{ $selectedProduct->status === 'published' ? 'despublicado' : 'publicado' }}.
                </p>
                <div class="flex justify-end space-x-3">
                    <button wire:click="$set('confirmingStatusChange', false)"
                        class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                        Cancelar
                    </button>
                    <button wire:click="toggleStatus"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Confirmar
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Pagination -->
    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>
