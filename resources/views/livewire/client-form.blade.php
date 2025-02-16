<div class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50">
    <div class="bg-white p-6 rounded-lg w-96 shadow-xl">
        <h2 class="text-xl font-semibold mb-4">Nuevo Cliente</h2>
        <form wire:submit.prevent="store">
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                <input type="text" id="name" wire:model="name" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="Ingrese el Nombre" required />
                @error('name') <span class="text-red-500">{{ $message }}</span>@enderror
            </div>
            <div class="mb-4">
                <label for="dni" class="block text-sm font-medium text-gray-700">DNI</label>
                <input type="text" id="dni" wire:model="dni" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="Ingrese DNI" />
                @error('dni') <span class="text-red-500">{{ $message }}</span>@enderror
            </div>
            <div class="mb-4">
                <label for="ruc" class="block text-sm font-medium text-gray-700">RUC</label>
                <input type="text" id="ruc" wire:model="ruc" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="Ingrese RUC" />
                @error('ruc') <span class="text-red-500">{{ $message }}</span>@enderror
            </div>
            <div class="mb-4">
                <label for="business_name" class="block text-sm font-medium text-gray-700">Razón Social</label>
                <input type="text" id="business_name" wire:model="business_name" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="Ingrese la Razón Social" />
                @error('business_name') <span class="text-red-500">{{ $message }}</span>@enderror
            </div>
            <div class="mb-4">
                <label for="phone_number" class="block text-sm font-medium text-gray-700">Número de Teléfono</label>
                <input type="text" id="phone_number" wire:model="phone_number" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="Ingrese el Número de Teléfono" />
                @error('phone_number') <span class="text-red-500">{{ $message }}</span>@enderror
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                <input type="email" id="email" wire:model="email" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="Ingrese el Correo Electrónico" />
                @error('email') <span class="text-red-500">{{ $message }}</span>@enderror
            </div>
            <div class="flex justify-end">
                <button type="button" wire:click="closeModal" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                    Cancelar
                </button>
                <button type="submit" class="ml-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>
