<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold mb-8 text-center text-gray-800">Nuestros Productos</h1>

    <div class="flex flex-col md:flex-row mb-8 space-y-4 md:space-y-0 md:space-x-4">
        <div class="md:w-1/4">
            <input wire:model.debounce.300ms="search" type="text" placeholder="Buscar productos..."
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="md:w-1/4">
            <select wire:model="selectedCategory" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Todas las categorías</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        @foreach ($products as $product)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden transition-transform duration-300 hover:scale-105">
                <div class="relative">
                    <img src="{{ asset('storage/' . $product->photo_url) }}" alt="{{ $product->name }}"
                        class="w-full h-64 object-cover">
                    @if ($product->brand)
                        <div class="absolute top-0 right-0 m-2">
                            <img src="{{ asset('storage/' . $product->brand->url_imgbrand) }}"
                                alt="{{ $product->brand->name }}" class="w-16 h-16 object-contain bg-white rounded-full p-2">
                        </div>
                    @endif
                </div>
                <div class="p-6">
                    <h2 class="text-xl font-semibold mb-2 text-gray-800">{{ $product->name }}</h2>
                    <p class="text-gray-600 mb-4 h-12 overflow-hidden">{{ Str::limit($product->description, 50) }}</p>
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-2xl font-bold text-blue-600">S/.{{ number_format($product->sale_price, 2) }}</span>
                        <span class="text-sm text-gray-500">{{ $product->brand->name }}</span>
                    </div>
                    @if ($product->stock <= 0)
                        <span class="block text-center text-red-500 font-semibold mb-2">Agotado</span>
                    @elseif (isset($cart[$product->id]) && $cart[$product->id]['quantity'] >= $product->stock)
                        <span class="block text-center text-yellow-500 font-semibold mb-2">No hay más disponible</span>
                    @else
                        <button wire:click="addToCart({{ $product->id }})"
                            class="w-full {{ $product->inCart ? 'bg-gray-500' : 'bg-green-500' }} text-white px-4 py-2 rounded-full hover:bg-opacity-90 transition duration-300">
                            {{ $product->inCart ? 'Añadir uno más' : 'Añadir al carrito' }}
                        </button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $products->links() }}
    </div>
</div>

