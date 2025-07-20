<tr>
    <td x-data="{ modalAbierto: false }" colspan="6"
        class="px-6 py-6 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300">

        <!-- Encabezado con icono y título -->
        <div class="flex items-center justify-between mb-4">
            <h4 class="font-bold text-xl text-gray-800 flex items-center">
                <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                Especificaciones del Producto
            </h4>
            <button @click="modalAbierto = true"
                class="flex items-center px-3 py-1.5 bg-gradient-to-r from-green-500 to-teal-500 text-white text-sm font-medium rounded-full shadow-sm hover:shadow-md hover:from-green-600 hover:to-teal-600 transition-all">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Agregar
            </button>
        </div>

        <!-- Lista de atributos -->
        <!-- Lista de atributos -->
        <div class="flex flex-wrap gap-3">
            @foreach ($productAttributes as $attributeName => $attributeData)
                @if (is_array($attributeData) && isset($attributeData['value']))
                    <div
                        class="relative group flex items-center bg-white border border-gray-200 text-gray-700 px-3 py-2 rounded-lg shadow-xs hover:shadow-sm transition-all">
                        <!-- Indicador visual -->
                        <span class="w-2 h-2 bg-indigo-500 rounded-full mr-2"></span>

                        <!-- Contenido del atributo -->
                        <div class="flex-1 min-w-0">
                            <span class="font-medium text-gray-900 truncate">{{ $attributeName }}</span>
                            <span class="mx-1 text-gray-400">:</span>
                            <span class="text-gray-600 truncate">
                                {{ is_array($attributeData) ? $attributeData['value'] : $attributeData }}
                            </span>
                        </div>

                        <!-- Menú de acciones -->
                        <div class="ml-2 flex opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                            <!-- Botón editar -->
                            @if (is_array($attributeData) && isset($attributeData['id']))
                                <button wire:click="openEditModal({{ $attributeData['id'] }})"
                                    class="p-1 text-indigo-500 hover:text-indigo-700 rounded-full hover:bg-indigo-50 transition-colors"
                                    title="Editar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </button>

                                <!-- Botón borrar -->
                                <button wire:click="confirmDeleteAttribute({{ $attributeData['id'] }})"
                                    class="p-1 text-red-500 hover:text-red-700 rounded-full hover:bg-red-50 transition-colors"
                                    title="Eliminar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <!-- Modal para agregar nuevo atributo -->
        <div x-show="modalAbierto" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div @click.away="modalAbierto = false" class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4">
                <!-- Encabezado del modal -->
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-900">Agregar nueva especificación</h3>
                    <button @click="modalAbierto = false" class="text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Formulario -->
                <form wire:submit.prevent="addAttribute" class="px-6 py-4">
                    <!-- Campo de nombre con autocompletado -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nombre del atributo</label>
                        <div class="relative">
                            <input wire:model="newAttributeName" wire:keyup.debounce.300ms="updateSuggestions"
                                type="text"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="Ej: Color, Tamaño, Peso">

                            <!-- Sugerencias -->
                            @if (!empty($suggestedAttributes))
                                <div
                                    class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-auto">
                                    @foreach ($suggestedAttributes as $suggestion)
                                        <div wire:click="selectSuggestion('{{ $suggestion->name }}')"
                                            class="px-4 py-2 cursor-pointer hover:bg-indigo-50 text-sm">
                                            {{ $suggestion->name }}
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Campo de valor -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Valor</label>
                        <input wire:model="newAttributeValue" type="text"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Ej: Rojo, 15 pulgadas, 1.5kg">
                    </div>

                    <!-- Botones de acción -->
                    <div class="flex justify-end space-x-3">
                        <button type="button" @click="modalAbierto = false"
                            class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Cancelar
                        </button>
                        <button type="submit"
                            class="px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Guardar especificación
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal para editar atributo -->
        <div x-show="$wire.editingModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div @click.away="$wire.editingModal = false" class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4">
                <!-- Encabezado del modal -->
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-900">Editar especificación</h3>
                    <button @click="$wire.editingModal = false" class="text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Formulario de edición -->
                <form wire:submit.prevent="editAttribute($wire.editingAttributeId, $wire.attributeValue)"
                    class="px-6 py-4">
                    <!-- Mostrar nombre del atributo (no editable) -->
                    <div class="mb-4">
                        @php
                            $attributeName = null;
                            foreach ($productAttributes as $name => $data) {
                                if ($data['id'] == $editingAttributeId) {
                                    $attributeName = $name;
                                    break;
                                }
                            }
                        @endphp

                        <input type="text" value="{{ $attributeName }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed"
                            readonly>

                    </div>

                    <!-- Campo de valor editable -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nuevo valor</label>
                        <input wire:model="attributeValue" type="text"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <!-- Botones de acción -->
                    <div class="flex justify-end space-x-3">
                        <button type="button" @click="$wire.editingModal = false"
                            class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Cancelar
                        </button>
                        <button type="submit"
                            class="px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Actualizar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal de confirmación para eliminar -->
        @if ($confirmingAttributeDelete)
            <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Confirmar eliminación</h3>
                    </div>
                    <div class="px-6 py-4">
                        <p class="text-gray-700 mb-4">¿Estás seguro de que deseas eliminar esta especificación?</p>
                        <div class="flex justify-end space-x-3">
                            <button wire:click="$set('confirmingAttributeDelete', false)"
                                class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                Cancelar
                            </button>
                            <button wire:click="removeAttribute($attributeToDelete)"
                                class="px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700">
                                Eliminar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </td>
</tr>
