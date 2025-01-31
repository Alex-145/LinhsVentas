<div>
    @if($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 sm:p-8 md:p-10 rounded-lg shadow-lg w-11/12 sm:w-1/2 lg:w-1/3">
                <h2 class="text-xl font-bold mb-4 text-center sm:text-left">¡Advertencia de Estafa!</h2>
                <p class="mb-4 text-gray-700">
                    Nuestra empresa Linhs Llantas, con RUC: 10248853781, advierte a nuestros clientes y público en general sobre actos de estafa realizados por personas y empresas que solicitan transferencias usando nuestro nombre, pero que no tienen ninguna relación con nosotros. Hemos observado un aumento de esta modalidad de estafa, por lo que queremos reafirmar que todos los depósitos deben hacerse únicamente a la persona:  <strong>LINO HUAMANVILCA SAICO</strong>.
                </p>
                <p class="mb-4 text-gray-700">
                    Ante cualquier cambio de datos o solicitudes sospechosas, mantén una actitud crítica y desconfía de las ofertas que suenen demasiado buenas para ser verdad.
                </p>
                <button wire:click="closeModal" class="w-full sm:w-auto bg-blue-600 text-white py-2 px-4 rounded-lg text-center">
                    Cerrar
                </button>
            </div>
        </div>
    @endif
</div>
