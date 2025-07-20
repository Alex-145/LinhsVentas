<div>
    <!-- Modal de Producto -->
    <div x-data="{ open: @entangle('isOpen') }" x-show="open" x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed z-50 inset-0 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Fondo oscuro -->
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-800 bg-opacity-75"></div>
            </div>

            <!-- Contenido del modal -->
            <div
                class="inline-block align-bottom bg-white rounded-xl shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <!-- Encabezado -->
                <div class="px-6 pt-6 pb-2 flex justify-between items-center border-b border-gray-200">
                    <h3 class="text-2xl font-bold text-gray-900">
                        {{ $editMode ? 'Editar Producto' : 'Nuevo Producto' }}
                    </h3>
                    <button @click="open = false" wire:click="$set('isOpen', false)"
                        class="text-gray-400 hover:text-gray-500 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Formulario -->
                <form wire:submit.prevent="{{ $editMode ? 'update' : 'store' }}" class="px-6 py-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nombre -->
                        <div class="col-span-2">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre del
                                Producto</label>
                            <div class="relative rounded-md shadow-sm">
                                <input type="text" wire:model="name" id="name" required
                                    class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-4 pr-10 py-3 sm:text-sm border-gray-300 rounded-lg"
                                    placeholder="Ej: Laptop HP 15-dw1024la">
                                @error('name')
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                @enderror
                            </div>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Descripción -->
                        <div class="col-span-2">
                            <label for="description"
                                class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                            <textarea wire:model="description" id="description" rows="3"
                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-4 pr-10 py-3 sm:text-sm border-gray-300 rounded-lg"
                                placeholder="Descripción detallada del producto"></textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Precio de Compra -->
                        <div>
                            <label for="purchase_price" class="block text-sm font-medium text-gray-700 mb-1">Precio de
                                Compra</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">S/.</span>
                                </div>
                                <input type="number" wire:model="purchase_price" id="purchase_price" step="0.01"
                                    required
                                    class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-12 pr-10 py-3 sm:text-sm border-gray-300 rounded-lg"
                                    placeholder="0.00">
                                @error('purchase_price')
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                @enderror
                            </div>
                            @error('purchase_price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Precio de Venta -->
                        <div>
                            <label for="sale_price" class="block text-sm font-medium text-gray-700 mb-1">Precio de
                                Venta</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">S/.</span>
                                </div>
                                <input type="number" wire:model="sale_price" id="sale_price" step="0.01" required
                                    class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-12 pr-10 py-3 sm:text-sm border-gray-300 rounded-lg"
                                    placeholder="0.00">
                                @error('sale_price')
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                @enderror
                            </div>
                            @error('sale_price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Stock -->
                        <div>
                            <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stock
                                Disponible</label>
                            <div class="relative rounded-md shadow-sm">
                                <input type="number" wire:model="stock" id="stock" step="1" required
                                    class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-4 pr-10 py-3 sm:text-sm border-gray-300 rounded-lg"
                                    placeholder="0">
                                @error('stock')
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                @enderror
                            </div>
                            @error('stock')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Categoría -->
                        <div>
                            <label for="category_id"
                                class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
                            <div class="flex space-x-2">
                                <select wire:model="category_id" wire:change="updateBrands($event.target.value)"
                                    id="category_id"
                                    class="flex-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-3 pr-10 py-3 sm:text-sm border-gray-300 rounded-lg">
                                    <option value="">Seleccione categoría</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <button type="button" wire:click="openCategoryModal"
                                    class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                </button>
                            </div>
                            @error('category_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Marca -->
                        <div>
                            <label for="brand_id" class="block text-sm font-medium text-gray-700 mb-1">Marca</label>
                            <div class="flex space-x-2">
                                <select wire:model="brand_id" id="brand_id"
                                    class="flex-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-3 pr-10 py-3 sm:text-sm border-gray-300 rounded-lg">
                                    <option value="">Seleccione marca</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                                <button type="button" wire:click="openBrandModal"
                                    class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                </button>
                            </div>
                            @error('brand_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Botón de envío -->
                    <div class="mt-8">
                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-lg font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150">
                            {{ $editMode ? 'Actualizar Producto' : 'Crear Producto' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- <!-- Modales para categorías y marcas (similares al modal principal) -->
    @if ($showCategoryModal)
        <!-- Modal para categorías -->
    @endif

    @if ($showBrandModal)
        <!-- Modal para marcas -->
    @endif --}}
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
    </style>
@endpush
