<div
    class="{{ $menuAbierto ? 'ml-60' : 'ml-16' }} mt-16 max-w-7xl mx-auto p-6 bg-gradient-to-br from-blue-50 to-indigo-100 shadow-xl rounded-xl transition-all duration-300 ease-in-out">

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
            <!-- SVG Icon for "Create New" -->
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
                        <td class="px-4 py-3 text-sm text-gray-800 flex items-center space-x-2">
                            <button wire:click="edit({{ $product->id }})"
                                class="text-indigo-600 hover:text-indigo-900 transition-colors duration-200 flex items-center">
                                <svg class="feather feather-edit w-5 h-5" fill="none" height="24"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" viewBox="0 0 24 24" width="24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                </svg>
                            </button>
                            <button wire:click="openPhotoModal({{ $product->id }})"
                                class="text-indigo-600 hover:text-indigo-900 transition-colors duration-200 flex items-center">
                                <svg xmlns="http://www.w3.org/1999/xlink" viewBox="0 0 487 487" xml:space="preserve"
                                    class="feather feather-edit w-5 h-5">
                                    <path
                                        d="M308.1,277.95c0,35.7-28.9,64.6-64.6,64.6s-64.6-28.9-64.6-64.6s28.9-64.6,64.6-64.6S308.1,242.25,308.1,277.95z
                                                M440.3,116.05c25.8,0,46.7,20.9,46.7,46.7v122.4v103.8c0,27.5-22.3,49.8-49.8,49.8H49.8c-27.5,0-49.8-22.3-49.8-49.8v-103.9
                                                v-122.3l0,0c0-25.8,20.9-46.7,46.7-46.7h93.4l4.4-18.6c6.7-28.8,32.4-49.2,62-49.2h74.1c29.6,0,55.3,20.4,62,49.2l4.3,18.6H440.3z
                                                M97.4,183.45c0-12.9-10.5-23.4-23.4-23.4c-13,0-23.5,10.5-23.5,23.4s10.5,23.4,23.4,23.4C86.9,206.95,97.4,196.45,97.4,183.45z
                                                M358.7,277.95c0-63.6-51.6-115.2-115.2-115.2s-115.2,51.6-115.2,115.2s51.6,115.2,115.2,115.2S358.7,341.55,358.7,277.95z" />
                                </svg>
                            </button>
                            <button wire:click="confirmDelete({{ $product->id }})"
                                class="text-red-600 hover:text-red-900 transition-colors duration-200 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
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
    <!-- Pagination -->
    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>
