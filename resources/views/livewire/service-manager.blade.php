<div> <!-- Notificación Toast -->
    @if (session()->has('notify'))
        <div class="fixed top-4 right-4 z-50 max-w-sm w-full transition-all duration-500" wire:poll.5s="$refresh">
            <div
                class="border-l-4 p-4 rounded-lg shadow-lg flex items-start
                @if (session('notify.type') === 'success') bg-green-100 border-green-500 text-green-700
                @elseif (session('notify.type') === 'error') bg-red-100 border-red-500 text-red-700
                @elseif (session('notify.type') === 'info') bg-blue-100 border-blue-500 text-blue-700 @endif
            ">
                <div class="flex-shrink-0">
                    @if (session('notify.type') === 'success')
                        <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    @elseif (session('notify.type') === 'error')
                        <svg class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    @elseif (session('notify.type') === 'info')
                        <svg class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    @endif
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium">{{ session('notify.message') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- MODAL: Confirmar eliminación -->
    @if ($showConfirmModal)
        <div class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white w-full max-w-md mx-4 rounded-lg p-6 shadow-xl">
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                        <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mt-3">¿Eliminar servicio?</h3>
                    <p class="mt-2 text-sm text-gray-500">Esta acción eliminará permanentemente el servicio. ¿Estás
                        seguro?</p>
                    <div class="mt-5 flex justify-center space-x-4">
                        <button wire:click="$set('showConfirmModal', false)" type="button"
                            class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm text-gray-700 bg-white hover:bg-gray-50">
                            Cancelar
                        </button>
                        <button wire:click="forceDelete" type="button"
                            class="px-4 py-2 rounded-md text-sm text-white bg-red-600 hover:bg-red-700">
                            Eliminar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- MODAL: Advertencia de dependencias -->
    @if ($showDependenciesWarning)
        <div class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white w-full max-w-md mx-4 rounded-lg p-6 shadow-xl">
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100">
                        <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mt-3">¡Advertencia!</h3>
                    <p class="mt-2 text-sm text-gray-500">
                        Este servicio está asociado a <strong>{{ $dependenciesCount }}</strong> ventas.
                        Si lo eliminas, estas ventas perderán la referencia.
                    </p>
                    <div class="mt-5 flex justify-center space-x-4">
                        <button wire:click="$set('showDependenciesWarning', false)" type="button"
                            class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm text-gray-700 bg-white hover:bg-gray-50">
                            Cancelar
                        </button>
                        <button wire:click="forceDelete" type="button"
                            class="px-4 py-2 rounded-md text-sm text-white bg-red-600 hover:bg-red-700">
                            Eliminar de todos modos
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4 sm:gap-6">
        <!-- Título y descripción -->
        <div class="flex-1 min-w-0">
            <h1 class="text-2xl font-bold text-gray-800">Gestor de Servicios</h1>
            <p class="text-sm text-gray-600 mt-1">Administra los servicios que ofreces a tus clientes</p>
        </div>

        <!-- Barra de búsqueda -->
        <div class="w-full sm:w-auto flex-1 max-w-md">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" wire:model.debounce.300ms="searchTerm" wire:keydown.debounce.300ms="resetPage"
                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    placeholder="Buscar servicios...">
            </div>
        </div>

        <!-- Botón Nuevo Servicio -->
        <div class="w-full sm:w-auto">
            <button wire:click="create"
                class="w-full sm:w-auto flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md transition-colors duration-200 shadow-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Nuevo Servicio
            </button>
        </div>
    </div>



    @if ($isOpen)
        @include('livewire.service-modal')
    @endif

    <!-- Tabla de servicios -->
    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nombre
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Descripción
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Precio
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($services as $service)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-medium text-gray-900">{{ $service->name }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-gray-600 text-sm line-clamp-2">
                                    {{ $service->description ?? 'Sin descripción' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    S/.{{ number_format($service->price, 2) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <button wire:click="edit({{ $service->id }})"
                                        class="text-indigo-600 hover:text-indigo-900 p-1 rounded-full hover:bg-indigo-50"
                                        title="Editar">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </button>
                                    <button wire:click="confirmDelete({{ $service->id }})"
                                        class="text-red-600 hover:text-red-900 p-1 rounded-full hover:bg-red-50"
                                        title="Eliminar">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                No se encontraron servicios. Crea tu primer servicio haciendo clic en "Nuevo Servicio".
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="bg-gray-50 px-6 py-3 border-t border-gray-200">
            {{ $services->links() }}
        </div>
    </div>
</div>
