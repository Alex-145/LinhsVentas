<div class="max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-lg">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
        <!-- Imagen del producto -->
        <div>
            <img src="{{ asset('storage/' . $product->photo_url) }}" alt="{{ $product->name }}"
                class="w-full h-auto rounded-lg shadow-md">
        </div>

        <!-- Detalles del producto -->
        <div>
            @if ($product->brand)
                <div class="flex justify-center mb-4">
                    <img src="{{ asset('storage/' . $product->brand->url_imgbrand) }}" alt="{{ $product->brand->name }}"
                        class="w-24 h-24 object-contain">
                </div>
            @endif
            <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-2">
                <i class="fas fa-tag text-blue-600"></i> {{ $product->name }}
            </h1>

            @if ($product->brand)
                <p class="text-gray-600 text-sm flex items-center gap-2 mt-2">
                    <i class="fas fa-industry text-gray-500"></i> Marca: {{ $product->brand->name }}
                </p>
            @endif
            @if ($product->stock > 0)
                <p class="text-green-600 mt-2 flex items-center gap-2">
                    <i class="fas fa-box text-green-500"></i> Stock disponible: {{ $product->stock }}
                </p>
            @else
                <p class="text-red-600 font-bold mt-2 flex items-center gap-2">
                    <i class="fas fa-exclamation-circle text-red-500"></i> Producto agotado
                </p>
            @endif

            <!-- Precio -->
            @if ($product->stock > 0)
                <div class="flex items-center justify-between mt-4">
                    <span class="text-2xl font-bold text-blue-600 flex items-center gap-2">
                        S/.{{ number_format($product->sale_price, 2) }}
                    </span>
                </div>
                <!-- Botón de añadir al carrito -->
                @if (isset($cart[$product->id]) && $cart[$product->id]['quantity'] >= $product->stock)
                    <span class="block text-center text-yellow-600 font-bold mt-2">Stock limitado</span>
                @else
                    <button wire:click="addToCart"
                        class="w-full mt-4 px-4 py-2 rounded-full font-semibold text-white transition-all duration-300
            {{ isset($cart[$product->id]) ? 'bg-gray-500 hover:bg-gray-600' : 'bg-green-500 hover:bg-green-600' }}">
                        <i class="fas fa-cart-plus"></i>
                        {{ isset($cart[$product->id]) ? 'Añadir uno más' : 'Añadir al carrito' }}
                    </button>
                @endif
            @endif




        </div>
    </div>

    <!-- Atributos del producto -->
    <div class="mt-6">
        <h3 class="text-lg font-semibold text-gray-700 flex items-center gap-2">
            <i class="fas fa-list text-gray-600"></i> Características:
        </h3>
        <ul class="mt-2 text-gray-600 space-y-1">
            @foreach ($product->attributes as $attribute)
                <li class="flex items-center gap-2">
                    <i class="fas fa-check-circle text-green-500"></i> {{ $attribute->name }}:
                    {{ $attribute->pivot->value }}
                </li>
            @endforeach
        </ul>
    </div>
</div>
