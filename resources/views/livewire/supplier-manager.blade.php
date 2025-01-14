<div
    class="{{ $menuAbierto ? 'ml-60' : 'ml-16' }} mt-16 max-w-7xl mx-auto p-6 bg-gradient-to-br from-blue-50 to-indigo-100 shadow-xl rounded-xl transition-all duration-300 ease-in-out">

    <!-- Success Message -->
    @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <!-- Button to create a new supplier -->
    <div class="text-center mb-8">
        <button wire:click="create()"
            class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-md transition duration-300 ease-in-out transform hover:scale-105 flex items-center justify-center">
            <!-- SVG Icon for "Create New" -->
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
            </svg>
            Crear Nuevo Proveedor
        </button>
    </div>

    <!-- Search Field -->
    <div class="mb-6">
        <input type="text" wire:model="searchTerm" wire:keydown.debounce.300ms="resetPage"
            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-3"
            placeholder="Search supplier...">
    </div>

    <!-- Supplier Form Modal -->
    @if ($isOpen)
        @include('livewire.supplier-form')
    @endif

    <!-- Suppliers Table -->
    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full bg-white border border-gray-300 shadow-md rounded-lg overflow-hidden">
            <thead class="bg-gradient-to-r from-indigo-600 to-indigo-800 text-white">
                <tr>
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Name</th>

                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Phone
                        Number</th>
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">RUC
                    </th>
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($suppliers as $supplier)
                    <tr class="border-b hover:bg-gray-100 transition duration-200">
                        <td class="px-4 py-3 text-sm text-gray-800">{{ $supplier->name }}</td>
                        <td class="px-4 py-3 text-sm text-gray-800">{{ $supplier->cellphone }}</td>
                        <td class="px-4 py-3 text-sm text-gray-800">{{ $supplier->ruc }}</td>
                        <td class="px-4 py-3 text-sm text-gray-800 flex items-center space-x-2">
                            <!-- Edit Button -->
                            <button wire:click="edit({{ $supplier->id }})"
                                class="text-indigo-600 hover:text-indigo-900 transition-colors duration-200 flex items-center">
                                <svg class="feather feather-edit w-5 h-5" fill="none" height="24"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" viewBox="0 0 24 24" width="24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                </svg>
                            </button>
                            <!-- Delete Button -->
                            <button wire:click="delete({{ $supplier->id }})"
                                class="text-red-600 hover:text-red-900 transition-colors duration-200 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                    fill="currentColor">
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

    <!-- Pagination -->
    <div class="mt-6">
        {{ $suppliers->links() }}
    </div>
</div>
