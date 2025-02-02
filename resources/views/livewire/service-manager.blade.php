<div
    class="{{ $menuAbierto ? 'ml-60' : 'ml-0' }} mt-16 max-w-7xl mx-auto p-6 bg-gradient-to-br from-blue-50 to-indigo-100 shadow-xl rounded-xl transition-all duration-300 ease-in-out">

    <!-- Success Message -->
    @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <!-- Modal de confirmación -->
    <div x-data="{ open: @entangle('showConfirmModal') }" x-show="open" @keydown.window.escape="open = false"
        class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white w-full max-w-sm mx-4 rounded-lg p-6 shadow-md">
            <div class="text-center">
                <h3 class="text-lg font-semibold mb-4">¿Estás seguro de que deseas eliminar este servicio?</h3>
                <p class="mb-4 text-sm text-gray-600">Esta acción no se puede deshacer.</p>

                <div class="flex justify-center gap-4">
                    <button @click="open = false"
                        class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md focus:outline-none">Cancelar</button>
                    <button wire:click="destroy"
                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md focus:outline-none">Eliminar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Button to create a new service -->
    <div class="text-center mb-8">
        <button wire:click="create" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-md">
            Crear Nuevo Servicio
        </button>
    </div>

    <!-- Search Field -->
    <div class="mb-6">
        <input type="text" wire:model="searchTerm" wire:keydown.debounce.300ms="resetPage"
            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-3"
            placeholder="Buscar servicios...">
    </div>

    @if ($isOpen)
        @include('livewire.service-modal')
    @endif

    <!-- Services Table -->
    <div class="overflow-x-auto bg-white shadow-md rounded-lg mt-6">
        <table class="min-w-full bg-white border border-gray-300 shadow-md rounded-lg overflow-hidden">
            <thead class="bg-gradient-to-r from-indigo-600 to-indigo-800 text-white">
                <tr>
                    @foreach (['Nombre', 'Precio', 'Acciones'] as $header)
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">
                            {{ $header }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="bg-white">
                @forelse ($services as $service)
                    <tr class="border-b hover:bg-gray-100">
                        <td class="px-4 py-3">{{ $service->name }}</td>
                        <td class="px-4 py-3">${{ number_format($service->price, 2) }}</td>
                        <td class="px-4 py-3 flex gap-2">
                            <button wire:click="edit({{ $service->id }})"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-md">
                                <svg class="feather feather-edit w-5 h-5" fill="none" height="24"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" viewBox="0 0 24 24" width="24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                </svg>
                            </button>
                            <button wire:click="confirmDelete({{ $service->id }})"
                                class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-4 py-3 text-center">No se encontraron servicios.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $services->links() }}
    </div>
</div>
