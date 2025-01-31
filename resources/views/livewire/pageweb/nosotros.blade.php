<div class="bg-gradient-to-br from-gray-50 to-gray-200 py-16" x-data="{ activeTab: 'historia', years: new Date().getFullYear() - 2015 }">
    <!-- Sección de Introducción -->
    <div class="container mx-auto px-4">
        <h1 class="text-5xl font-extrabold text-center text-gray-900 mb-8 animate-fade-in">
            Nosotros
        </h1>
        <p class="text-xl text-gray-700 text-center max-w-2xl mx-auto leading-relaxed animate-fade-in-up">
            En <span class="font-bold text-blue-700">LINHS LLANTAS</span>, nos enorgullece ser parte de la historia
            de nuestra querida ciudad de <span class="font-bold text-gray-900">Challhuahuacho, Apurímac</span>. Desde nuestros
            inicios en el año <span class="font-bold text-gray-900">2015</span>, hemos crecido junto a la comunidad, ofreciendo
            servicios de calidad y productos que garantizan la seguridad y satisfacción de nuestros clientes.
        </p>
    </div>

    <!-- Pestañas de Información -->
    <div class="mt-16">
        <div class="flex justify-center space-x-4">
            <button
                @click="activeTab = 'historia'"
                :class="{ 'bg-blue-700 text-white shadow-lg': activeTab === 'historia' }"
                class="px-8 py-3 rounded-xl font-semibold text-gray-700 hover:bg-blue-700 hover:text-white transition-all duration-300 transform hover:scale-105">
                Nuestra Historia
            </button>
            <button
                @click="activeTab = 'galeria'"
                :class="{ 'bg-blue-700 text-white shadow-lg': activeTab === 'galeria' }"
                class="px-8 py-3 rounded-xl font-semibold text-gray-700 hover:bg-blue-700 hover:text-white transition-all duration-300 transform hover:scale-105">
                Galería
            </button>
        </div>

        <div class="mt-12">
            <!-- Historia -->
            <div
                x-show="activeTab === 'historia'"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-y-4"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                class="bg-white p-8 rounded-xl shadow-2xl animate-fade-in-up">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Nuestra Historia</h2>
                <p class="text-gray-700 leading-relaxed">
                    En <strong class="text-blue-700">LinhsLlantas</strong>, nos enorgullece ser parte de la comunidad de
                    <strong class="text-gray-900">Challhuahuacho, Apurímac</strong>. Desde el <strong class="text-gray-900">2015</strong>, hemos estado
                    comprometidos con ofrecer soluciones de calidad en el mundo de las llantas. Con más de <span
                        x-text="years" class="font-bold text-blue-700"></span> años de experiencia, nos hemos
                    convertido en un referente de confianza para la venta, reparación y mantenimiento de llantas en la
                    región.
                </p>
                <p class="text-gray-700 mt-6 leading-relaxed">
                    Nuestra misión es simple: brindar productos y servicios que garanticen la seguridad y el rendimiento
                    de tu vehículo. Con un equipo dedicado y herramientas de última generación, estamos aquí para cuidar
                    de ti y de tu viaje.
                </p>
            </div>

            <!-- Galería -->
            <div
                x-show="activeTab === 'galeria'"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-y-4"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                class="bg-white p-8 rounded-xl shadow-2xl animate-fade-in-up">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Galería</h2>
                <div
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($fotosLocal as $foto)
                        <img src="{{ asset('img/' . $foto) }}" alt="Local" class="rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                    @endforeach
                    @foreach ($fotosCiudad as $foto)
                        <img src="{{ asset('img/' . $foto) }}" alt="Ciudad" class="rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Mapa de Ubicación -->
    <div class="mt-16 container mx-auto px-4">
        <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Ubicación</h2>
        <div class="bg-white p-8 rounded-xl shadow-2xl">
            <!-- Mapa -->
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12345.6789!2d-72.262989!3d-14.1232011!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x916c13f26ddea1e7:0x4e218fa555ebd935!2zMTTCsDA3JzI0LjQiUyA3MsKwMDcnMjQuNCJX!5e0!3m2!1ses!2spe!4v1234567890123"
                width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"
                class="rounded-lg mb-6">
            </iframe>

            <!-- Botón de Compartir Ubicación (solo en móvil) -->
            <a
                href="https://api.whatsapp.com/send?text=¡Hola! Estoy interesado en visitar LinhsLlantas. Aquí está su ubicación: https://www.google.com/maps?q=-14.1232011,-72.262989"
                target="_blank"
                class="inline-flex items-center justify-center px-8 py-4 bg-green-600 text-white rounded-xl hover:bg-green-700 transition-all duration-300 transform hover:scale-105 md:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Compartir Ubicación por WhatsApp
            </a>
        </div>
    </div>
</div>
