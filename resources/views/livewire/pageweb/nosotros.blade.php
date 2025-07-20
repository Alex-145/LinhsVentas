<div class="bg-gradient-to-br from-blue-50 to-white py-24" x-data="{ years: new Date().getFullYear() - 2015 }">
    <div class="container mx-auto px-6 max-w-7xl grid grid-cols-1 md:grid-cols-2 gap-12 items-center">

        <!-- Texto animado -->
        <div data-aos="fade-right" data-aos-duration="1000">
            <h1 class="text-5xl font-extrabold text-gray-900 mb-6">
                Nosotros
            </h1>
            <p class="text-lg text-gray-700 leading-relaxed mb-6">
                En <span class="text-blue-700 font-bold">LINHS LLANTAS</span>, hemos acompañado el crecimiento de
                <span class="text-gray-900 font-semibold">Challhuahuacho, Apurímac</span> desde <strong>2015</strong>.
                Con más de <span x-text="years" class="font-bold text-blue-700"></span> años de experiencia, somos una
                empresa líder
                en servicios de llantas para el sector minero y automotriz.
            </p>
            <p class="text-lg text-gray-700 leading-relaxed mb-8">
                Nuestro compromiso es brindarte seguridad, confianza y tecnología de última generación.
                No solo cuidamos tu vehículo, ¡cuidamos tu camino!
            </p>
            <a href="#ubicacion"
                class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl shadow-lg transition transform hover:scale-105">
                Conócenos más ↓
            </a>
        </div>

        <!-- Imagen / ilustración con animación -->
        <div class="relative" data-aos="fade-left" data-aos-duration="1000">
            <img src="/storage/pageweb/taller1.jpeg" alt="Linhs Llantas"
                class="rounded-3xl shadow-2xl w-full object-cover h-96 transform hover:scale-105 transition duration-500 ease-in-out">
            <div
                class="absolute bottom-4 right-4 bg-white px-4 py-2 rounded-full shadow-lg text-sm font-semibold text-blue-600">
                +8 años contigo
            </div>
        </div>
    </div>

    <!-- Mapa de ubicación -->
    <div id="ubicacion" class="mt-28 container mx-auto px-6 max-w-5xl">
        <h2 class="text-4xl font-bold text-center text-gray-900 mb-8" data-aos="fade-up">¿Dónde estamos?</h2>
        <div class="bg-white p-8 rounded-3xl shadow-2xl" data-aos="zoom-in-up" data-aos-delay="200">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12345.6789!2d-72.262989!3d-14.1232011!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x916c13f26ddea1e7:0x4e218fa555ebd935!2zMTTCsDA3JzI0LjQiUyA3MsKwMDcnMjQuNCJX!5e0!3m2!1ses!2spe!4v1234567890123"
                width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"
                class="rounded-lg w-full">
            </iframe>

            <!-- Botón móvil -->
            <div class="text-center mt-6">
                <a href="https://api.whatsapp.com/send?text=¡Hola! Estoy interesado en visitar Linhs Llantas. Aquí está su ubicación: https://www.google.com/maps?q=-14.1232011,-72.262989"
                    target="_blank"
                    class="inline-flex items-center justify-center px-8 py-4 bg-green-600 text-white rounded-xl hover:bg-green-700 transition-all duration-300 transform hover:scale-105 md:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Compartir ubicación por WhatsApp
                </a>
            </div>
        </div>
    </div>
</div>
