<footer class="bg-gray-800 text-white">
    <div class="container mx-auto p-6">
        <div class="flex flex-col md:flex-row justify-between gap-8">
            <!-- Sobre Nosotros -->
            <div class="md:w-1/3">
                <h2 class="text-lg font-semibold">Sobre Nosotros</h2>
                <p class="mt-2 text-gray-400">
                    Somos una empresa dedicada a ofrecer los mejores servicios y productos para nuestros clientes.
                    Tu satisfacción es nuestra prioridad.
                </p>
                <div class="mt-4">
                    <img src="{{ asset('storage/pageweb/logologin1.png') }}" alt="Logo de Linhs Llantas" class="w-32">
                </div>
            </div>

            <!-- Información de Contacto -->
            <div class="md:w-1/3">
                <h2 class="text-lg font-semibold">Contáctanos</h2>
                <ul class="mt-2 text-gray-400 space-y-1 text-sm">
                    <li><strong>Asesor:</strong> Lino Huamanvilca Saico</li>
                    <li><strong>RUC:</strong> 10248853781</li>
                    <li><strong>Dirección:</strong> Wichaypampa s/n</li>
                    <li><strong>Celular:</strong>
                        <a href="https://wa.me/51974369546" class="hover:text-white">974 369 546</a>
                    </li>
                    <li><strong>Email:</strong>
                        <a href="mailto:linhs.saico@gmail.com" class="hover:text-white">linhs.saico@gmail.com</a>
                    </li>
                </ul>
            </div>

            <!-- Enlaces y redes -->
            <div class="md:w-1/3">
                <h2 class="text-lg font-semibold">Enlaces Rápidos</h2>
                <ul class="mt-2 space-y-1 text-gray-400 text-sm">
                    <li><a href="{{ url('/') }}" class="hover:text-white">Inicio</a></li>
                    <li><a href="{{ route('wnosotros.index') }}" class="hover:text-white">Nosotros</a></li>
                    <li><a href="{{ route('wproducts.index') }}" class="hover:text-white">Productos</a></li>
                    <li><a href="{{ route('wservices.index') }}" class="hover:text-white">Servicios</a></li>
                    <li><a href="{{ route('wcontactenos.index') }}" class="hover:text-white">Contáctenos</a></li>
                    <li><a href="{{ url('/politica-de-privacidad') }}" class="hover:text-white">Política de
                            Privacidad</a></li>
                </ul>

                <h2 class="text-lg font-semibold mt-6">Síguenos</h2>
                <div class="flex space-x-4 mt-2">
                    <a href="https://www.facebook.com/linhsllanta?locale=es_LA" target="_blank" aria-label="Facebook"
                        class="text-gray-400 hover:text-white">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://www.tiktok.com/@linhs414" target="_blank" aria-label="TikTok"
                        class="text-gray-400 hover:text-white">
                        <i class="fab fa-tiktok"></i>
                    </a>
                    <a href="https://github.com/Alex-145" target="_blank" aria-label="GitHub"
                        class="text-gray-400 hover:text-white">
                        <i class="fab fa-github"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-6 border-t border-gray-700 pt-4 text-center text-sm text-gray-400">
            <p>&copy; {{ now()->year }} Linhs Llantas. Todos los derechos reservados.</p>
            <p>Desarrollado por Lino Huamanvilca</p>
        </div>
    </div>
</footer>
