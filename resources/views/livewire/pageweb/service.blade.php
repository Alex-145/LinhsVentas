<main class="bg-gray-100 py-12">
    <div class="container mx-auto px-4">
        <!-- Hero Section -->
        <section class="text-center mb-16">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Nuestros Servicios</h1>
            <p class="text-lg text-gray-600">Ofrecemos soluciones completas para el mantenimiento y cuidado de tus llantas.</p>
        </section>

        <!-- Services Section -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Venta de Llantas -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <img src="{{ asset('storage/pageweb/venta.jpg') }}" alt="Venta de Llantas" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">Venta de Llantas</h2>
                    <p class="text-gray-600 mb-4">Llantas de las mejores marcas para todo tipo de vehículo.</p>
                    <a href="#" class="text-blue-500 hover:underline">Más información</a>
                </div>
            </div>

            <!-- Parchado Vipal -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <img src="{{ asset('storage/pageweb/parche.webp') }}" alt="Parchado Vipal" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">Parchado Vipal</h2>
                    <p class="text-gray-600 mb-4">Reparaciones con tecnología de punta y calidad garantizada.</p>
                    <a href="#" class="text-blue-500 hover:underline">Más información</a>
                </div>
            </div>

            <!-- Cambio de Llantas -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <img src="{{ asset('storage/pageweb/cambio.jpeg') }}" alt="Cambio de Llantas" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">Cambio de Llantas</h2>
                    <p class="text-gray-600 mb-4">Servicio rápido y seguro en nuestras instalaciones.</p>
                    <a href="#" class="text-blue-500 hover:underline">Más información</a>
                </div>
            </div>
        </section>

        <!-- Call to Action -->
        <section class="text-center mt-16">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">¿Listo para cuidar tus llantas?</h2>
            <p class="text-lg text-gray-600 mb-6">Visítanos hoy mismo o solicita una cotización en línea.</p>
            <a href="/contactenos" class="bg-blue-600 text-white px-6 py-3 rounded-lg shadow hover:bg-blue-700">Contáctanos</a>
        </section>
    </div>
</main>
