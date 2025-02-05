<div>
    <div class="fixed inset-0 bg-gray-800 bg-opacity-60 flex items-center justify-center z-50" wire:model="isOpen">
        <div
            class="bg-white w-full max-w-2xl mx-6 rounded-xl p-6 shadow-lg transform transition-all duration-300 scale-95 hover:scale-100">
            <div class="text-right">
                <button wire:click="$set('isOpen', false)"
                    class="text-gray-400 hover:text-gray-600 text-2xl font-semibold">&times;</button>
            </div>

            <form wire:submit.prevent="{{ $editMode ? 'update' : 'store' }}">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach (['name' => 'Nombre', 'description' => 'Descripción', 'purchase_price' => 'Precio de Compra', 'sale_price' => 'Precio de Venta', 'stock' => 'Stock'] as $field => $label)
                        <div @if ($field === 'name') class="col-span-2" @endif>
                            <label for="{{ $field }}"
                                class="text-lg font-medium text-gray-700">{{ $label }}</label>
                            @if (in_array($field, ['purchase_price', 'sale_price', 'stock']))
                                <input type="number" wire:model="{{ $field }}"
                                    class="form-input mt-2 block w-full text-sm rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    step="{{ $field === 'stock' ? '1' : '0.01' }}" required />
                            @elseif ($field === 'name')
                                <input type="text" wire:model="name"
                                    class="form-input mt-2 block w-full text-sm rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    required />
                            @else
                                <textarea wire:model="{{ $field }}"
                                    class="form-textarea mt-2 block w-full text-sm rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                            @endif
                            @error($field)
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    @endforeach

                    <!-- Categoría -->
                    <div>
                        <label for="category_id" class="text-lg font-medium text-gray-700">Categoría</label>
                        <select wire:model="category_id" wire:change="updateBrands($event.target.value)"
                            class="form-select mt-2 block w-full text-sm rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Seleccione una categoría</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Marca -->
                    <div>
                        <label for="brand_id" class="text-lg font-medium text-gray-700">Marca</label>
                        <select wire:model="brand_id"
                            class="form-select mt-2 block w-full text-sm rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            required>
                            <option value="">Seleccione una marca</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                        @error('brand_id')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit"
                        class="mt-6 w-full bg-blue-600 text-white text-lg py-3 rounded-lg shadow-lg hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
                        {{ $editMode ? 'Actualizar Producto' : 'Agregar Producto' }}
                    </button>
            </form>
        </div>
    </div>
</div>
