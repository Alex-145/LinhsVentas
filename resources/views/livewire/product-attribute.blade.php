<tr>
    <td x-data="{ modalAbierto: false }" colspan="6"
        class="px-6 py-6 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-2xl shadow-md hover:shadow-lg transition-all duration-300">
        <!-- Título compacto con ícono -->
        <h4 class="font-bold text-2xl text-gray-900 mb-4 flex items-center">
            <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z">
                </path>
            </svg>
            Detalles
        </h4>
        <!-- Lista de atributos tipo "chip" -->
        <div class="flex flex-wrap gap-2">
            @foreach ($productAttributes as $attributeName => $attributeValue)
                @php
                    $attribute = App\Models\Attribute::where('name', $attributeName)->first();
                @endphp
                <div
                    class="flex items-center space-x-2 bg-gray-100 text-gray-700 px-3 py-1.5 rounded-full shadow-sm hover:bg-gray-200 transition">
                    <!-- Icono decorativo -->
                    <span class="w-2 h-2 bg-indigo-500 rounded-full"></span>

                    <!-- Nombre y valor -->
                    <span class="font-medium text-gray-900">{{ $attributeName }}</span>:
                    <span class="text-gray-600">{{ $attributeValue }}</span>

                    <!-- Botones de acciones -->
                    <div class="flex space-x-1">
                        <!-- Botón editar -->
                        <button class="text-indigo-500 hover:text-indigo-700 transition-colors duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                </path>
                            </svg>
                        </button>

                        <!-- Botón borrar -->
                        @if ($attribute)
                            <button wire:click="removeAttribute({{ $attribute->id }})"
                                class="text-red-500 hover:text-red-700 transition-colors duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>


        <!-- Botón "Agregar detalle" -->
        <div class="mt-4 flex justify-end">
            <button @click="modalAbierto = true"
                class="px-4 py-2 bg-gradient-to-r from-green-400 to-teal-400 text-white font-semibold rounded-lg shadow-sm hover:shadow-md hover:from-green-500 hover:to-teal-500 transition-all duration-300 flex items-center">
                <svg class="w-4 h-4 mr-2 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Agregar
            </button>
        </div>

        <!-- Modal -->
        <div x-show="modalAbierto" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Agregar Detalle</h2>

                <!-- Formulario -->
                <form wire:submit.prevent="addAttribute">
                    <div class="mb-4 relative">
                        <label class="block text-gray-700 font-medium mb-1">Nombre del Atributo</label>
                        <input wire:keyup="updateSuggestions" wire:model="newAttributeName" type="text"
                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400"
                            placeholder="Escribe el nombre del atributo">

                        <!-- Mostrar las sugerencias si existen -->
                        @if (!empty($suggestedAttributes))
                            <div class="mt-1 bg-white shadow-md rounded-lg w-full absolute z-10 border border-gray-300">
                                @foreach ($suggestedAttributes as $suggestion)
                                    <div wire:click="selectSuggestion('{{ $suggestion->name }}')"
                                        class="cursor-pointer px-4 py-2 hover:bg-indigo-100">
                                        {{ $suggestion->name }}
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>





                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">Valor</label>
                        <input wire:model="newAttributeValue" type="text"
                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    </div>

                    <div class="flex justify-end space-x-2">
                        <button type="button" @click="modalAbierto = false"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-all">
                            Cancelar
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-indigo-500 text-white font-semibold rounded-lg hover:bg-indigo-600 transition-all">
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </td>
</tr>
