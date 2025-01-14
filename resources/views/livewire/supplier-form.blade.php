<div class="fixed inset-0 z-50 flex justify-center items-center bg-gray-900 bg-opacity-50">
    <div class="bg-white rounded-lg p-6 w-96">
        <h3 class="text-lg font-bold text-gray-900 mb-4">{{ $supplier_id ? 'Edit' : 'Create' }} Supplier</h3>
        <form wire:submit.prevent="store">
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Supplier Name</label>
                <input wire:model="name" type="text" id="name"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2"
                    required>
            </div>
            <div class="mb-4">
                <label for="cellphone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                <input wire:model="cellphone" type="text" id="cellphone" inputmode="numeric" pattern="\d*"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2">
            </div>
            <div class="mb-4">
                <label for="ruc" class="block text-sm font-medium text-gray-700">RUC</label>
                <input wire:model="ruc" type="text" id="ruc" inputmode="numeric" pattern="\d*"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2">
            </div>
            <div class="flex justify-end space-x-2">
                <button type="button" wire:click="closeModal"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-900 font-bold py-2 px-4 rounded-md">Cancel</button>
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-md">{{ $supplier_id ? 'Update' : 'Create' }}</button>
            </div>
        </form>
    </div>
</div>
