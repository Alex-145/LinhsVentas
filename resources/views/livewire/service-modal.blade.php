<div>
    <div class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50" wire:model="isOpen">
        <div class="bg-white w-full max-w-xl mx-4 rounded-lg p-4 shadow-md">
            <div class="text-right">
                <button wire:click="$set('isOpen', false)"
                    class="text-gray-500 hover:text-gray-700 text-xl font-bold">&times;</button>
            </div>

            <form wire:submit.prevent="{{ $editMode ? 'update' : 'store' }}">
                <div class="space-y-4">
                    <!-- Name Field -->
                    <div>
                        <label for="name" class="text-sm font-semibold">Nombre</label>
                        <input type="text" wire:model="name" class="form-input mt-1 block w-full text-sm" required />
                        @error('name')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Description Field -->
                    <div>
                        <label for="description" class="text-sm font-semibold">Descripción</label>
                        <textarea wire:model="description" class="form-textarea mt-1 block w-full text-sm"></textarea>
                        @error('description')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Price Field -->
                    <div>
                        <label for="price" class="text-sm font-semibold">Precio</label>
                        <input type="number" wire:model="price" class="form-input mt-1 block w-full text-sm" step="0.01" required />
                        @error('price')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="mt-4 bg-blue-600 text-white text-sm py-2 px-6 rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
                    {{ $editMode ? 'Actualizar Servicio' : 'Agregar Servicio' }}
                </button>
            </form>
        </div>
    </div>
</div>
