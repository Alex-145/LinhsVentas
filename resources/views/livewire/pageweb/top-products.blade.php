<section class="py-16">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-8">Productos Más Vendidos</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($topProducts as $product)
                @if($product) <!-- Verificamos si el producto existe -->
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        @if ($product->photo_url) <!-- Verificamos si existe una foto para el producto -->
                            <img src="{{ asset('storage/' . $product->photo_url) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                        @else
                            <!-- Si no hay foto, podemos mostrar una imagen predeterminada o dejar en blanco -->
                            <img src="{{ asset('storage/default-image.jpg') }}" alt="Producto sin imagen" class="w-full h-48 object-cover">
                        @endif

                        <div class="p-4">
                            <h3 class="text-lg font-semibold mb-2">{{ $product->name }}</h3>

                            @if ($product->brand)
                                <p class="text-gray-600 text-sm flex items-center gap-2">
                                    <i class="fas fa-industry text-gray-500"></i> Marca: {{ $product->brand->name }}
                                </p>
                            @endif

                            <p class="text-gray-700 mt-2">{{ $product->description }}</p>

                            @if ($product->stock > 0)
                                <p class="text-green-600 mt-2 flex items-center gap-2">
                                    <i class="fas fa-box text-green-500"></i> Stock disponible: {{ $product->stock }}
                                </p>
                                <div class="flex items-center justify-between mt-4">
                                    <span class="text-2xl font-bold text-blue-600 flex items-center gap-2">
                                        S/.{{ number_format($product->sale_price, 2) }}
                                    </span>
                                </div>
                            @else
                                <p class="text-red-600 font-bold mt-2 flex items-center gap-2">
                                    <i class="fas fa-exclamation-circle text-red-500"></i> Producto agotado
                                </p>
                            @endif

                            <!-- Botón de añadir al carrito -->
                            <button wire:click="addToCart"
                                class="w-full mt-4 px-4 py-2 rounded-full font-semibold text-white transition-all duration-300
                                {{ isset($cart[$product->id]) ? 'bg-gray-500 hover:bg-gray-600' : 'bg-green-500 hover:bg-green-600' }}">
                                <i class="fas fa-cart-plus"></i>
                                {{ isset($cart[$product->id]) ? 'Añadir uno más' : 'Añadir al carrito' }}
                            </button>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</section>
