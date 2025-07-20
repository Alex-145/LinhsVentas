<div>
    <!-- Modal de Crear/Editar -->
    @if ($isOpen)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Fondo del modal -->
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75" wire:click="$set('isOpen', false)"></div>
                </div>

                <!-- Contenido del modal -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <!-- Encabezado -->
                        <div class="flex justify-between items-start">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                {{ $editMode ? 'Editar Servicio' : 'Nuevo Servicio' }}
                            </h3>
                            <button type="button" wire:click="$set('isOpen', false)"
                                class="text-gray-400 hover:text-gray-500 focus:outline-none">
                                <span class="sr-only">Cerrar</span>
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <!-- Formulario -->
                        <form wire:submit.prevent="{{ $editMode ? 'update' : 'store' }}" class="mt-4">
                            <div class="space-y-4">
                                <!-- Nombre -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                                    <input type="text" id="name" wire:model.defer="name"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                        required>
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Descripción -->
                                <div>
                                    <label for="description"
                                        class="block text-sm font-medium text-gray-700">Descripción</label>
                                    <textarea id="description" wire:model.defer="description" rows="3"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
                                    @error('description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Precio -->
                                <div>
                                    <label for="price" class="block text-sm font-medium text-gray-700">Precio</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">S/.</span>
                                        </div>
                                        <input type="number" id="price" wire:model.defer="price" step="0.01"
                                            min="0"
                                            class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md py-2 px-3"
                                            placeholder="0.00" required>
                                        <div
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm" id="price-currency">PEN</span>
                                        </div>
                                    </div>
                                    @error('price')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Botones -->
                            <div class="mt-6 flex justify-end space-x-3">
                                <button type="button" wire:click="$set('isOpen', false)"
                                    class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Cancelar
                                </button>
                                <button type="submit"
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    {{ $editMode ? 'Actualizar' : 'Guardar' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
