<div
    class="{{ $menuAbierto ? 'ml-60' : 'ml-0' }} mt-16 max-w-full sm:max-w-7xl mx-auto p-6 transition-all duration-300 ease-in-out">
    <!-- Notificación de éxito -->
    @if (session()->has('message'))
        <div class="p-4 mb-6 bg-green-50 border-l-4 border-green-500 rounded-lg shadow-sm animate-fade-in">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <span class="text-green-700">{{ session('message') }}</span>
            </div>
        </div>
    @endif

    <!-- Barra superior de acciones -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <!-- Botón de crear nuevo producto -->
        <button wire:click="create"
            class="bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white font-semibold py-2 px-6 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-[1.02] flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Nuevo Producto
        </button>

        <!-- Campo de búsqueda -->
        <div class="relative w-full md:w-96">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" wire:model="searchTerm" wire:keydown.debounce.300ms="resetPage"
                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                placeholder="Buscar productos...">
        </div>
    </div>

    <!-- Modal de creación/edición -->
    @if ($isOpen)
        @include('livewire.producto.product-modal')
    @endif

    <!-- Tabla de productos -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-indigo-600 to-indigo-800">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-indigo-100 uppercase tracking-wider">ID
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-indigo-100 uppercase tracking-wider">
                            Producto</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-indigo-100 uppercase tracking-wider">
                            Compra</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-indigo-100 uppercase tracking-wider">
                            Venta</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-indigo-100 uppercase tracking-wider">
                            Utilidad</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-indigo-100 uppercase tracking-wider">
                            Stock</th>
                        <th scope="col"
                            class="px-6 py-3 text-right text-xs font-medium text-indigo-100 uppercase tracking-wider">
                            Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($products as $product)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <!-- ID -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
                                wire:click="toggleAttributes({{ $product->id }})">
                                {{ $product->id }}
                            </td>

                            <!-- Nombre con imagen -->
                            <td class="px-6 py-4 whitespace-nowrap" wire:click="toggleAttributes({{ $product->id }})">
                                <div class="flex items-center">
                                    <div
                                        class="flex-shrink-0 h-10 w-10 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                                        @if ($product->photo_url)
                                            <img class="h-10 w-10 rounded-lg object-cover"
                                                src="{{ asset('storage/' . $product->photo_url) }}"
                                                alt="{{ $product->name }}">
                                        @else
                                            <svg class="h-6 w-6 text-indigo-500" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $product->sku ?? 'Sin SKU' }}</div>
                                    </div>
                                </div>
                            </td>

                            <!-- Precios -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                                wire:click="toggleAttributes({{ $product->id }})">
                                S/.{{ number_format($product->purchase_price, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                                wire:click="toggleAttributes({{ $product->id }})">
                                S/.{{ number_format($product->sale_price, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                                wire:click="toggleAttributes({{ $product->id }})">
                                <span class="{{ $product->profit >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    S/.{{ number_format($product->profit, 2) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                                wire:click="toggleAttributes({{ $product->id }})">
                                <span class="{{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $product->stock }}
                                </span>
                            </td>

                            <!-- Acciones -->
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-3">
                                    <!-- Editar -->
                                    <button wire:click.stop="edit({{ $product->id }})" title="Editar"
                                        class="text-indigo-600 hover:text-indigo-900 transition duration-150 p-1 rounded-full hover:bg-indigo-50">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>

                                    <!-- Cambiar foto -->
                                    <button wire:click.stop="openPhotoModal({{ $product->id }})" title="Cambiar foto"
                                        class="text-gray-600 hover:text-gray-900 transition duration-150 p-1 rounded-full hover:bg-gray-50">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </button>

                                    <!-- Cambiar estado -->
                                    <button wire:click.stop="confirmStatusChange({{ $product->id }})"
                                        title="{{ $product->status == 'published' ? 'Despublicar' : 'Publicar' }}"
                                        class="{{ $product->status == 'published' ? 'text-green-600 hover:text-green-900' : 'text-red-600 hover:text-red-900' }} transition duration-150 p-1 rounded-full hover:bg-gray-50">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>

                                    <!-- Eliminar -->
                                    <button wire:click.stop="confirmDelete({{ $product->id }})" title="Eliminar"
                                        class="text-red-600 hover:text-red-900 transition duration-150 p-1 rounded-full hover:bg-red-50">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <!-- Atributos del producto (se muestra al hacer clic) -->
                        @if ($selectedProductId2 == $product->id)
                            @livewire('product-attribute', ['product' => $product, 'productAttributes' => $productAttributes], key($product->id))
                        @endif

                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                <div class="flex flex-col items-center justify-center py-8">
                                    <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No se encontraron productos</h3>
                                    <p class="mt-1 text-sm text-gray-500">No hay productos que coincidan con tu
                                        búsqueda.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Paginación -->
    <div class="mt-6">
        {{ $products->links() }}
    </div>

    <!-- Modal para cambiar foto -->
    <div x-data="{ open: @entangle('photoModalOpen') }" x-show="open" x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" class="fixed z-50 inset-0 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Cambiar foto del producto</h3>
                            <div class="mt-4">
                                @if ($photo_url_old)
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-500 mb-2">Foto actual:</p>
                                        <img src="{{ asset('storage/' . $photo_url_old) }}" alt="Foto actual"
                                            class="w-32 h-32 object-cover mx-auto rounded">
                                    </div>
                                @endif
                                <input type="file" wire:model="photo_url"
                                    class="block w-full text-sm text-gray-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-lg file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-indigo-50 file:text-indigo-700
                                    hover:file:bg-indigo-100" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button wire:click="savePhoto" type="button"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm transition duration-150">
                        Guardar
                    </button>
                    <button @click="open = false" type="button"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition duration-150">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación para cambiar estado -->
    <div x-data="{ open: @entangle('confirmingStatusChange') }" x-show="open" x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" class="fixed z-50 inset-0 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-{{ $selectedProduct && $selectedProduct->status === 'published' ? 'red' : 'green' }}-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-{{ $selectedProduct && $selectedProduct->status === 'published' ? 'red' : 'green' }}-600"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Cambiar estado del producto</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    ¿Estás seguro de que deseas
                                    {{ $selectedProduct && $selectedProduct->status === 'published' ? 'despublicar' : 'publicar' }}
                                    este producto?
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button wire:click="toggleStatus" type="button"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-{{ $selectedProduct && $selectedProduct->status === 'published' ? 'red' : 'green' }}-600 text-base font-medium text-white hover:bg-{{ $selectedProduct && $selectedProduct->status === 'published' ? 'red' : 'green' }}-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-{{ $selectedProduct && $selectedProduct->status === 'published' ? 'red' : 'green' }}-500 sm:ml-3 sm:w-auto sm:text-sm transition duration-150">
                        {{ $selectedProduct && $selectedProduct->status === 'published' ? 'Despublicar' : 'Publicar' }}
                    </button>
                    <button @click="open = false" type="button"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition duration-150">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación para eliminar -->
    <div x-data="{ open: @entangle('showConfirmModal') }" x-show="open" x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" class="fixed z-50 inset-0 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Eliminar producto</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">¿Estás seguro de que deseas eliminar este producto?
                                    Esta acción no se puede deshacer.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button wire:click="destroy" type="button"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm transition duration-150">
                        Eliminar
                    </button>
                    <button @click="open = false" type="button"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition duration-150">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <style>
        .animate-fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .bg-gradient-to-r {
            background-image: linear-gradient(to right, var(--tw-gradient-stops));
        }

        .hover\:scale-\[1\.02\]:hover {
            transform: scale(1.02);
        }
    </style>
@endpush
