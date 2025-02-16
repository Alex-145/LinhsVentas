<div class="container mx-auto px-4 py-8">
    <!-- Búsqueda -->
    <!-- Campo de búsqueda sin debounce -->
    <input wire:model.live.debounce.500ms="search" type="text" placeholder="Buscar productos..."
        class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 mb-4 text-lg">
    <div class="flex flex-col sm:flex-row gap-4">
        <!-- Botón de filtros visible solo en móvil -->
        <button id="toggleFilters" class="sm:hidden mb-4 px-6 py-3 bg-blue-500 text-white rounded-full">
            Filtros
        </button>

        <!-- Filtros (ocultos por defecto en móvil) -->
        <div id="filters" class="w-full sm:w-1/4 space-y-6 hidden sm:block">
            <div class="bg-white p-6 rounded-lg shadow-lg">

                <!-- Categorías -->
                <select wire:model.live="selectedCategory"
                    class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 mb-4 text-lg">
                    <option value="">Todas las categorías</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>

                <!-- Marcas -->
                <div>
                    <h3 class="text-xl font-semibold mb-3">Marcas</h3>
                    @foreach ($brands->take(5) as $brand)
                        <label class="flex items-center mb-2">
                            <input type="checkbox" wire:model.live="selectedBrands" value="{{ $brand->id }}"
                                class="mr-2">
                            <span class="text-lg">{{ $brand->name }}</span>
                        </label>
                    @endforeach
                    @if ($brands->count() > 5)
                        <button wire:click="showMoreBrands"
                            class="text-blue-500 mt-4 hover:text-blue-700 transition">Ver más</button>
                    @endif
                </div>

                <!-- Atributos -->
                <div>
                    <h3 class="text-xl font-semibold mb-3">Atributos</h3>
                    @foreach ($attributes as $attribute)
                        <div class="mb-4" x-data="{ showAllValues_{{ $attribute->id }}: false }">
                            <strong class="text-lg">{{ $attribute->name }}</strong>
                            <div class="mt-2">
                                @php
                                    // Obtener los valores únicos de los productos relacionados con este atributo
                                    $uniqueValues = $attribute->products->pluck('pivot.value')->filter()->unique();
                                    \Log::debug($uniqueValues);
                                @endphp

                                @if ($uniqueValues->isNotEmpty())
                                    @foreach ($uniqueValues->take(5) as $value)
                                        <label class="block mb-2">
                                            <input type="checkbox"
                                                wire:model.live="selectedAttributes.{{ $attribute->id }}.{{ $value }}"
                                                value="{{ $value }}" class="mr-2">
                                            <span class="text-lg">{{ $value }}</span>
                                        </label>
                                    @endforeach
                                @endif

                                <!-- Sección de "Ver más" -->
                                <div x-show="showAllValues_{{ $attribute->id }}">
                                    @foreach ($uniqueValues->slice(5) as $value)
                                        <label class="block mb-2">
                                            <input type="checkbox"
                                                wire:model.live="selectedAttributes.{{ $attribute->id }}.{{ $value }}"
                                                value="{{ $value }}" class="mr-2">
                                            <span class="text-lg">{{ $value }}</span>
                                        </label>
                                    @endforeach
                                </div>

                                @if ($uniqueValues->count() > 5)
                                    <button
                                        @click="showAllValues_{{ $attribute->id }} = !showAllValues_{{ $attribute->id }}"
                                        class="text-blue-500 mt-2 hover:text-blue-700 transition">
                                        <span
                                            x-text="showAllValues_{{ $attribute->id }} ? 'Ver menos' : 'Ver más'"></span>
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Productos -->
        <div class="w-full sm:w-3/4">
            <div class="w-full grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @foreach ($products as $product)
                    <div
                        class="bg-white rounded-xl shadow-md overflow-hidden transition-transform duration-300 hover:scale-105 hover:shadow-xl">
                        <div class="relative">
                            <a href="{{ route('product.show', $product->id) }}">
                                <img src="{{ asset('storage/' . $product->photo_url) }}" alt="{{ $product->name }}"
                                    class="w-full h-64 object-cover transition-opacity duration-300 hover:opacity-90">
                            </a>

                            @if ($product->brand)
                                <div class="absolute top-2 right-2 bg-white rounded-full p-1 shadow-md">
                                    <img src="{{ asset('storage/' . $product->brand->url_imgbrand) }}"
                                        alt="{{ $product->brand->name }}" class="w-14 h-14 object-contain">
                                </div>
                            @endif
                        </div>

                        <div class="p-5">
                            <span class="text-xs text-gray-500">{{ $product->brand->name }}</span>

                            <h2 class="text-lg font-bold text-gray-900 mb-1">{{ $product->name }}</h2>

                            @if ($product->stock > 0)
                                <div class="flex items-center justify-between mt-4">
                                    <span
                                        class="text-xl font-bold text-blue-600">S/.{{ number_format($product->sale_price, 2) }}</span>
                                </div>
                            @endif

                            @if ($product->stock <= 0)
                                <span class="block text-center text-red-600 font-bold mt-2">Agotado</span>
                            @elseif (isset($cart[$product->id]) && $cart[$product->id]['quantity'] >= $product->stock)
                                <span class="block text-center text-yellow-600 font-bold mt-2">Stock limitado</span>
                            @else
                                <button wire:click="addToCart({{ $product->id }})"
                                    class="w-full mt-4 px-4 py-2 rounded-full font-semibold text-white transition-all duration-300
                                    {{ $product->inCart ? 'bg-gray-500 hover:bg-gray-600' : 'bg-green-500 hover:bg-green-600' }}">
                                    {{ $product->inCart ? 'Añadir uno más' : 'Añadir al carrito' }}
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    <!-- Paginación -->
    <div class="mt-8 flex justify-center">
        {{ $products->links() }}
    </div>
</div>

<script>
    // Toggle filtros visibility
    document.getElementById('toggleFilters').addEventListener('click', function() {
        var filters = document.getElementById('filters');
        filters.classList.toggle('hidden');
    });
</script>
