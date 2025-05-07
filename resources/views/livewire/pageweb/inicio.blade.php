<x-index-layout>

<div class="bg-gray-50">
    <!-- Hero Section -->

    @livewire('pageweb.scam-alert')
    <section class="relative bg-gradient-to-r from-blue-600 to-blue-800 text-white overflow-hidden h-screen">
        <!-- Imagen de fondo con gradiente encima -->
        <div class="absolute right-0 top-0 h-full w-1/2 hidden lg:block">
            <div class="relative h-full w-full">
                <img src="{{ asset('storage/pageweb/llantalogoinicio.jpg') }}" alt="Llantas" class="absolute inset-0 h-full w-full object-cover z-0">
                <div class="absolute inset-0 bg-gradient-to-l from-transparent to-blue-800 opacity-90 z-10"></div>
            </div>
        </div>

        <!-- Contenido del hero -->
        <div class="container mx-auto px-4 h-full flex flex-col lg:flex-row items-center relative z-20">
            <div class="lg:w-1/2 text-center lg:text-left lg:pl-12">
                <h1 class="text-5xl font-extrabold leading-tight mb-6 tracking-tight drop-shadow-lg">
                    Bienvenido a <span class="text-yellow-400">LINHSLLANTAS</span>
                </h1>
                <p class="text-xl text-blue-100 font-light mb-8 leading-relaxed max-w-xl mx-auto lg:mx-0 drop-shadow">
                    Te ofrecemos una amplia gama de llantas y productos especializados para el mantenimiento de tu vehículo. Calidad, seguridad y servicio garantizados.
                </p>
                <a href="{{ route('wproducts.index') }}" class="inline-block bg-yellow-400 hover:bg-yellow-500 text-black font-semibold py-3 px-8 rounded-full shadow-xl transition-all duration-300 transform hover:scale-105">
                    Explorar Productos
                </a>
            </div>
        </div>
    </section>








    @livewire('pageweb.top-products')



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
