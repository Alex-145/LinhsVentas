<div
    class="{{ $menuAbierto ? 'ml-60' : 'ml-0' }} mt-16 max-w-7xl mx-auto p-6 bg-gradient-to-br from-blue-50 to-indigo-100 shadow-xl rounded-xl transition-all duration-300 ease-in-out">
    <div x-data="{ openForm: @entangle('openForm'), openDeleteConfirm: false }" @keydown.escape.window="openForm = false" class="max-w-4xl mx-auto p-6">

        @if (session()->has('message'))
            <div class="alert alert-success p-4 mb-4 rounded-md bg-green-100 text-green-700">
                {{ session('message') }}
            </div>
        @endif

        <button @click="$wire.create()"
            class="mb-4 px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
            Crear nueva Marca
        </button>

        <div x-show="openForm" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white shadow-md rounded-lg p-6 max-w-lg w-full">
                <form wire:submit.prevent="save">
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nombre de la
                                Marca</label>
                            <input type="text" id="name" wire:model="name"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @error('name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700">Categoría</label>
                            <select id="category_id" wire:model="category_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Seleccione una categoría</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="url_imgbrand" class="block text-sm font-medium text-gray-700">Imagen de la Marca</label>
                            <input type="file" id="url_imgbrand" wire:model="url_imgbrand"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @error('url_imgbrand')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex justify-between">
                            <button @click="openForm = false" type="button"
                                class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition">
                                Cancelar
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                                Guardar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div x-show="openDeleteConfirm" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white shadow-md rounded-lg p-6 max-w-lg w-full">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">¿Estás seguro de que quieres eliminar esta marca?
                </h3>
                <div class="flex justify-between">
                    <button @click="openDeleteConfirm = false" type="button"
                        class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition">
                        Cancelar
                    </button>
                    <button wire:click="delete" type="button"
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                        Eliminar
                    </button>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg mt-8 p-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Listado de Marcas</h3>
            <table class="w-full table-auto text-gray-700">
                <thead>
                    <tr class="text-left border-b">
                        <th class="py-2 px-4">Nombre</th>
                        <th class="py-2 px-4">Categoría</th>
                        <th class="py-2 px-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($brands as $brand)
                        <tr class="border-b">
                            <td class="py-2 px-4">{{ $brand->name }}</td>
                            <td class="py-2 px-4">{{ $brand->category->name }}</td>
                            <td class="py-2 px-4">
                                <button wire:click="edit({{ $brand->id }})"
                                    class="inline-block px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition">Editar</button>
                                <button
                                    @click="openDeleteConfirm = true; $wire.set('brandToDelete', {{ $brand->id }})"
                                    class="inline-block ml-2 px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">Eliminar</button>
                                <button wire:click="openPhotoModal({{ $brand->id }})"
                                    class="inline-block ml-2 px-4 py-2">
                                    <svg xmlns="http://www.w3.org/1999/xlink" viewBox="0 0 487 487" xml:space="preserve"
                                        class="feather feather-edit w-5 h-5">
                                        <path
                                            d="M308.1,277.95c0,35.7-28.9,64.6-64.6,64.6s-64.6-28.9-64.6-64.6s28.9-64.6,64.6-64.6S308.1,242.25,308.1,277.95z
                                                        M440.3,116.05c25.8,0,46.7,20.9,46.7,46.7v122.4v103.8c0,27.5-22.3,49.8-49.8,49.8H49.8c-27.5,0-49.8-22.3-49.8-49.8v-103.9
                                                        v-122.3l0,0c0-25.8,20.9-46.7,46.7-46.7h93.4l4.4-18.6c6.7-28.8,32.4-49.2,62-49.2h74.1c29.6,0,55.3,20.4,62,49.2l4.3,18.6H440.3z
                                                        M97.4,183.45c0-12.9-10.5-23.4-23.4-23.4c-13,0-23.5,10.5-23.5,23.4s10.5,23.4,23.4,23.4C86.9,206.95,97.4,196.45,97.4,183.45z
                                                        M358.7,277.95c0-63.6-51.6-115.2-115.2-115.2s-115.2,51.6-115.2,115.2s51.6,115.2,115.2,115.2S358.7,341.55,358.7,277.95z" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-2 px-4 text-center">No hay marcas disponibles.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <!-- Modal para cambiar foto -->
    <div x-data="{ open: @entangle('photoModalOpen') }" x-show="open" @keydown.window.escape="open = false"
        class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white w-full max-w-md mx-4 rounded-lg p-4 shadow-md">
            <div class="text-right">
                <button @click="open = false"
                    class="text-gray-500 hover:text-gray-700 text-xl font-bold">&times;</button>
            </div>
            <h2 class="text-lg font-bold mb-4">Cambiar Foto de la Marca</h2>
            <div class="text-center">
                @if ($url_imgbrand_old)
                    <img src="{{ asset('storage/' . $url_imgbrand_old) }}" alt="Foto actual"
                        class="w-48 h-48 object-cover mx-auto rounded mb-4">
                @endif
                <input type="file" wire:model="url_imgbrand" class="form-input w-full mb-4" />
                <button wire:click="savePhoto"
                    class="bg-green-600 text-white text-sm py-2 px-6 rounded-lg shadow-md hover:bg-green-700 focus:outline-none focus:ring focus:ring-green-300">Guardar
                    Foto</button>
            </div>
        </div>
    </div>
</div>
