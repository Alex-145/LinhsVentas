<x-index-layout>

<div class="bg-gray-50">
    <!-- Hero Section -->

    @livewire('pageweb.scam-alert')

    <section class="relative bg-gradient-to-r from-blue-600 to-blue-800 text-white">
        <div class="container mx-auto px-4 py-16 flex flex-col lg:flex-row items-center justify-between">
            <div class="lg:w-1/2 text-center lg:text-left">
                <h1 class="text-4xl font-bold mb-4">
                    Bienvenido a <span class="text-yellow-400">LINHSLLANTAS</span>
                </h1>
                <p class="text-lg mb-6">
                    Encuentra las mejores llantas y productos para el mantenimiento de tu vehículo con la mejor calidad y servicio.
                </p>
                <a href="{{ route('wproducts.index') }}" class="inline-block bg-yellow-400 hover:bg-yellow-500 text-black font-bold py-3 px-6 rounded-lg shadow-lg transition focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-opacity-50">
                    Explorar Productos
                </a>
            </div>
            <div class="lg:w-1/2 mt-10 lg:mt-0">
                @livewire('pageweb.inicio.carousel')
            </div>
        </div>
    </section>



    <!-- Featured Products Section -->
    <section class="py-16">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-8">Nuevos Productos</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                {{-- @foreach($featuredProducts as $product)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold mb-2">{{ $product->name }}</h3>
                        <p class="text-gray-700">{{ $product->description }}</p>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-blue-600 font-bold">${{ number_format($product->price, 2) }}</span>
                            <a href="/productos/{{ $product->id }}" class="text-white bg-blue-600 hover:bg-blue-700 py-2 px-4 rounded">
                                Ver más
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach --}}
            </div>
        </div>
    </section>


    <!-- Modal - Aviso contra Estafas -->
    <div id="fraud-warning-modal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center hidden z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-11/12 md:w-1/3">
            <h3 class="text-xl font-semibold mb-4">¡Alerta de Estafa!</h3>
            <p class="mb-4 text-gray-700">Por favor, ten en cuenta que no nos hacemos responsables de ventas fuera de nuestra página web oficial. No caigas en estafas. Si tienes dudas, contacta directamente con nuestro servicio al cliente.</p>
            <button onclick="closeModal()" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">Cerrar</button>
        </div>
    </div>


</div>


</x-index-layout>
