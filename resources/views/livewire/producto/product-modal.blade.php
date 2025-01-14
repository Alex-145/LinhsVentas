<div>
    <div class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50" wire:model="isOpen">
        <div class="bg-white w-full max-w-xl mx-4 rounded-lg p-4 shadow-md">
            <div class="text-right">
                <button wire:click="$set('isOpen', false)"
                    class="text-gray-500 hover:text-gray-700 text-xl font-bold">&times;</button>
            </div>

            <form wire:submit.prevent="{{ $editMode ? 'update' : 'store' }}">
                <div class="grid grid-cols-2 gap-3">
                    @foreach (['name' => 'Nombre', 'description' => 'Descripción', 'purchase_price' => 'Precio de Compra', 'sale_price' => 'Precio de Venta', 'stock' => 'Stock'] as $field => $label)
                        <div>
                            <label for="{{ $field }}" class="text-sm font-semibold">{{ $label }}</label>
                            @if (in_array($field, ['purchase_price', 'sale_price', 'stock']))
                                <input type="number" wire:model="{{ $field }}"
                                    class="form-input mt-1 block w-full text-sm"
                                    step="{{ $field === 'stock' ? '1' : '0.01' }}" required />
                            @elseif ($field === 'name')
                                <input type="text" wire:model="name" class="form-input mt-1 block w-full text-sm"
                                    required />
                            @else
                                <textarea wire:model="{{ $field }}" class="form-textarea mt-1 block w-full text-sm"></textarea>
                            @endif
                            @error($field)
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    @endforeach

                    <div>
                        <label for="category_id" class="text-sm font-semibold">Categoría</label>
                        <select wire:model="category_id" class="form-select mt-1 block w-full text-sm" required>
                            <option value="">Seleccione una categoría</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="brand_id" class="text-sm font-semibold">Marca</label>
                        <select wire:model="brand_id" class="form-select mt-1 block w-full text-sm" required>
                            <option value="">Seleccione una marca</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                        @error('brand_id')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <button type="submit"
                    class="mt-4 bg-blue-600 text-white text-sm py-2 px-6 rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
                    {{ $editMode ? 'Actualizar Producto' : 'Agregar Producto' }}
                </button>
            </form>
        </div>
    </div>
</div>
