<div
    class="{{ $menuAbierto ? 'ml-60' : 'ml-0' }} mt-16 max-w-7xl mx-auto p-6 bg-gradient-to-br from-blue-50 to-indigo-100 shadow-xl rounded-xl transition-all duration-300 ease-in-out">

    @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <div class="text-center mb-8">
        <button wire:click="create()"
            class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-md transition duration-300 ease-in-out transform hover:scale-105 flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
            </svg>
            Crear Nuevo Cliente
        </button>
    </div>

    <div class="mb-6">
        <input type="text" wire:model="searchTerm" wire:keydown.debounce.300ms="resetPage"
            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-3"
            placeholder="Buscar cliente...">
    </div>

    @if ($isOpen)
        @include('livewire.client-form')
    @endif

    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full bg-white border border-gray-300 shadow-md rounded-lg overflow-hidden">
            <thead class="bg-gradient-to-r from-indigo-600 to-indigo-800 text-white">
                <tr>
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Nombre</th>
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">DNI</th>
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">RUC</th>
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Razón Social</th>
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Teléfono</th>
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Correo</th>
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clients as $client)
                    <tr class="border-b hover:bg-gray-100 transition duration-200">
                        <td class="px-4 py-3 text-sm text-gray-800">{{ $client->name }}</td>
                        <td class="px-4 py-3 text-sm text-gray-800">{{ $client->dni }}</td>
                        <td class="px-4 py-3 text-sm text-gray-800">{{ $client->ruc }}</td>
                        <td class="px-4 py-3 text-sm text-gray-800">{{ $client->business_name }}</td>
                        <td class="px-4 py-3 text-sm text-gray-800">{{ $client->phone_number }}</td>
                        <td class="px-4 py-3 text-sm text-gray-800">{{ $client->email }}</td>
                        <td class="px-4 py-3 text-sm text-gray-800 flex items-center space-x-2">
                            <button wire:click="edit({{ $client->id }})"
                                class="text-indigo-600 hover:text-indigo-900 transition-colors duration-200 flex items-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                            </button>
                            <button wire:click="delete({{ $client->id }})"
                                class="text-red-600 hover:text-red-900 transition-colors duration-200 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $clients->links() }}
    </div>
</div>
