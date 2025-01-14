<div
    class="{{ $menuAbierto ? 'ml-60' : 'ml-16' }} mt-16 max-w-7xl mx-auto p-6 bg-gradient-to-br from-blue-50 to-indigo-100 shadow-xl rounded-xl transition-all duration-300 ease-in-out">

    @if (session()->has('message'))
        <div class="p-2 bg-green-200 text-green-800 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}">
        <div class="mb-4">
            <label for="name" class="block font-medium">Nombre de la Marca:</label>
            <input type="text" id="name" wire:model="name" class="border rounded p-2 w-full">
            @error('name')
                <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">
            {{ $isEdit ? 'Actualizar' : 'Crear' }}
        </button>
        @if ($isEdit)
            <button type="button" wire:click="resetInput"
                class="px-4 py-2 bg-gray-600 text-white rounded ml-2">Cancelar</button>
        @endif
    </form>

    <table class="table-auto w-full mt-6 border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="border border-gray-300 px-4 py-2">ID</th>
                <th class="border border-gray-300 px-4 py-2">Nombre</th>
                <th class="border border-gray-300 px-4 py-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($brands as $brand)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ $brand->id }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $brand->name }}</td>
                    <td class="border border-gray-300 px-4 py-2">
                        <button wire:click="edit({{ $brand->id }})"
                            class="px-2 py-1 bg-yellow-500 text-white rounded">Editar</button>
                        <button wire:click="delete({{ $brand->id }})"
                            class="px-2 py-1 bg-red-600 text-white rounded">Eliminar</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
