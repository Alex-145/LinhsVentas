<section class="py-16">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-8">Productos Más Vendidos</h2>

        <!-- Carrusel de productos con botones -->
        <div class="relative group" x-data="{ scrollEl: null }" x-init="scrollEl = $refs.scrollContainer">
            <!-- Botón izquierda mejorado -->
            <button @click="scrollEl.scrollBy({ left: -300, behavior: 'smooth' })"
                class="absolute left-0 top-1/2 transform -translate-y-1/2 z-10
       bg-gradient-to-l from-blue-600 via-blue-700 to-blue-800
       text-white p-3 rounded-full shadow-lg
       hover:from-blue-500 hover:to-blue-700
       hover:shadow-2xl hover:scale-110 transition-all duration-300
       ring-2 ring-white/10 backdrop-blur-sm
       focus:outline-none hidden md:block group">

                <i class="fas fa-chevron-left text-xl group-hover:animate-pulse"></i>
            </button>


            <!-- Carrusel -->
            <div x-ref="scrollContainer"
                class="flex overflow-x-auto space-x-6 scrollbar-hide scroll-smooth snap-x snap-mandatory pb-4 px-1"
                style="scrollbar-width: none;">
                @foreach ($topProducts as $product)
                    @if ($product)
                        <a href="{{ url('/wproductshow/' . $product->id) }}"
                            class="min-w-[250px] max-w-[250px] bg-white rounded-xl shadow-lg snap-start hover:shadow-2xl transform hover:scale-105 transition-all duration-300 flex-shrink-0">
                            @if ($product->photo_url)
                                <img src="{{ asset('storage/' . $product->photo_url) }}" alt="{{ $product->name }}"
                                    class="w-full h-40 object-cover rounded-t-xl">
                            @else
                                <img src="{{ asset('storage/default-image.jpg') }}" alt="Producto sin imagen"
                                    class="w-full h-40 object-cover rounded-t-xl">
                            @endif

                            <div class="p-4 text-left">
                                <h3 class="text-lg font-semibold text-gray-800">{{ $product->name }}</h3>

                                @if ($product->brand)
                                    <p class="text-sm text-gray-500 mt-1">
                                        <i class="fas fa-industry text-gray-400 mr-1"></i>{{ $product->brand->name }}
                                    </p>
                                @endif

                                <p class="text-gray-600 mt-2 text-sm">
                                    {{ Str::limit($product->description, 60) }}
                                </p>

                                @if ($product->stock > 0)
                                    <p class="text-green-600 mt-2 text-sm flex items-center gap-1">
                                        <i class="fas fa-box"></i> {{ $product->stock }} en stock
                                    </p>
                                    <p class="text-blue-600 font-bold text-lg mt-1">
                                        S/.{{ number_format($product->sale_price, 2) }}
                                    </p>
                                @else
                                    <p class="text-red-600 font-bold mt-2 text-sm">
                                        <i class="fas fa-exclamation-circle"></i> Agotado
                                    </p>
                                @endif
                            </div>
                        </a>
                    @endif
                @endforeach
            </div>

            <!-- Botón derecha mejorado -->
            <button @click="scrollEl.scrollBy({ left: 300, behavior: 'smooth' })"
                class="absolute right-0 top-1/2 transform -translate-y-1/2 z-10
       bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800
       text-white p-3 rounded-full shadow-lg
       hover:from-blue-500 hover:to-blue-700
       hover:shadow-2xl hover:scale-110 transition-all duration-300
       ring-2 ring-white/10 backdrop-blur-sm
       focus:outline-none hidden md:block group">

                <i class="fas fa-chevron-right text-xl group-hover:animate-pulse"></i>
            </button>


            <!-- Indicador para pantallas pequeñas -->
            <div class="mt-4 text-center md:hidden text-gray-500 text-sm">
                Desliza para ver más →
            </div>
        </div>
    </div>
</section>
