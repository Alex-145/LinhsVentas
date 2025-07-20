<section class="bg-gray-50 py-16">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-semibold text-gray-800">¡Contáctenos!</h2>
            <p class="text-gray-600 mt-4">Nuestros asesores de venta están listos para ayudarte. ¡No dudes en comunicarte
                con nosotros!</p>
        </div>

        <!-- Enlaces a WhatsApp -->
        <div class="flex justify-center gap-6 mb-12">
            <a href="#" onclick="openWhatsApp('51983316063')"
                class="flex items-center bg-green-500 text-white p-4 rounded-lg shadow-lg transform transition duration-300 hover:scale-105">
                <img src="/storage/pageweb/WhatsApp.svg.webp" alt="WhatsApp" class="w-8 h-8 mr-3">
                <span class="text-lg">+51 983316063</span>
            </a>
            <a href="#" onclick="openWhatsApp('51974369546')"
                class="flex items-center bg-green-500 text-white p-4 rounded-lg shadow-lg transform transition duration-300 hover:scale-105">
                <img src="/storage/pageweb/WhatsApp.svg.webp" alt="WhatsApp" class="w-8 h-8 mr-3">
                <span class="text-lg">+51 974369546</span>
            </a>
        </div>

        <script>
            function openWhatsApp(phone) {
                const message = "Hola%2C%20estoy%20interesado%20en%20sus%20productos";
                let url = (window.innerWidth > 768) ?
                    `https://web.whatsapp.com/send?phone=${phone}&text=${message}` :
                    `https://wa.me/${phone}?text=${message}`;
                window.open(url, '_blank');
            }
        </script>

        <!-- Galería de fotos del local -->
        <div class="text-center mb-12">
            <h3 class="text-xl font-semibold text-gray-800">Visítanos en nuestro local</h3>
            <p class="text-gray-600 mt-4 mb-8">Estamos ubicados en una zona accesible y lista para atenderte. ¡Te
                esperamos!</p>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <div>
                    <img src="/storage/pageweb/taller1.jpeg" alt="Foto taller 1"
                        class="w-full h-64 object-cover rounded-lg shadow-lg">
                </div>
                <div>
                    <img src="/storage/pageweb/taller2.jpeg" alt="Foto taller 2"
                        class="w-full h-64 object-cover rounded-lg shadow-lg">
                </div>
                <div>
                    <img src="/storage/pageweb/taller3.jpeg" alt="Foto taller 3"
                        class="w-full h-64 object-cover rounded-lg shadow-lg">
                </div>
                <!-- Puedes agregar más fotos aquí si deseas -->
            </div>
        </div>

        <div class="text-center mt-12">
            <p class="text-gray-600">¡Siempre listos para ofrecerte los mejores productos y servicios! Nos aseguramos de
                ser los mejores en llantas, ¡confía en nosotros!</p>
        </div>
    </div>


</section>
