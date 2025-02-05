<section class="bg-gray-50 py-16">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-semibold text-gray-800">¡Contáctenos!</h2>
            <p class="text-gray-600 mt-4">Nuestros asesores de venta están listos para ayudarte. ¡No dudes en comunicarte con nosotros!</p>
        </div>

        <!-- Enlaces a WhatsApp -->
        <div class="flex justify-center gap-6 mb-12">
            <a href="#" onclick="openWhatsApp('51983316063')"
               class="flex items-center bg-green-500 text-white p-4 rounded-lg shadow-lg transform transition duration-300 hover:scale-105">
                <img src="https://upload.wikimedia.org/wikipedia/commons/6/64/WhatsApp.svg"
                     alt="WhatsApp"
                     class="w-8 h-8 mr-3">
                <span class="text-lg">+51 983316063</span>
            </a>
            <a href="#" onclick="openWhatsApp('51974369546')"
               class="flex items-center bg-green-500 text-white p-4 rounded-lg shadow-lg transform transition duration-300 hover:scale-105">
                <img src="https://upload.wikimedia.org/wikipedia/commons/6/64/WhatsApp.svg"
                     alt="WhatsApp"
                     class="w-8 h-8 mr-3">
                <span class="text-lg">+51 974369546</span>
            </a>
        </div>

        <script>
        function openWhatsApp(phone) {
            // Definir el mensaje predefinido
            const message = "Hola%2C%20estoy%20interesado%20en%20sus%20productos";  // El mensaje codificado

            // Detectar si el usuario está en PC o en móvil
            let url = (window.innerWidth > 768)
                ? `https://web.whatsapp.com/send?phone=${phone}&text=${message}`  // PC: Abre WhatsApp Web
                : `https://wa.me/${phone}?text=${message}`;  // Móvil: Abre la app de WhatsApp con el mensaje

            // Asegurarse de que el enlace se abre correctamente en una nueva ventana
            window.open(url, '_blank');
        }
        </script>




        <!-- Galería de fotos del local -->
        <div class="text-center mb-12">
            <h3 class="text-xl font-semibold text-gray-800">Visítanos en nuestro local</h3>
            <p class="text-gray-600 mt-4 mb-8">Estamos ubicados en una zona accesible y lista para atenderte. ¡Te esperamos!</p>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <div>
                    <img src="ruta-de-la-imagen-1.jpg" alt="Foto 1" class="w-full h-64 object-cover rounded-lg shadow-lg">
                </div>
                <div>
                    <img src="ruta-de-la-imagen-2.jpg" alt="Foto 2" class="w-full h-64 object-cover rounded-lg shadow-lg">
                </div>
                <div>
                    <img src="ruta-de-la-imagen-3.jpg" alt="Foto 3" class="w-full h-64 object-cover rounded-lg shadow-lg">
                </div>
            </div>
        </div>

        <!-- Formulario de contacto -->
        <div class="bg-white p-8 rounded-lg shadow-xl">
            <h4 class="text-2xl font-semibold text-center text-gray-800 mb-6">Envíanos un mensaje</h4>
            <form wire:submit.prevent="submit" class="space-y-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <input type="text" name="name" wire:model="name" placeholder="Tu nombre" class="w-full p-4 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500" required>
                    </div>
                    <div>
                        <input type="email" name="email" wire:model="email" placeholder="Tu correo electrónico" class="w-full p-4 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500" required>
                    </div>
                </div>
                <div>
                    <textarea name="message" wire:model="message" rows="4" placeholder="Tu mensaje" class="w-full p-4 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500" required></textarea>
                </div>
                <div class="text-center">
                    <button type="submit" class="bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-green-600 transform transition duration-300">Enviar mensaje</button>
                </div>
            </form>
        </div>

        <div class="text-center mt-12">
            <p class="text-gray-600">¡Siempre listos para ofrecerte los mejores productos y servicios! Nos aseguramos de ser los mejores en llantas, ¡confía en nosotros!</p>
        </div>
    </div>
</section>
