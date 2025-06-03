<x-app-layout>
    <x-slot name="header_title">New Item Request</x-slot>
    <x-slot name="title">Request New Item</x-slot>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
            <h1 class="text-2xl font-semibold text-gray-700 dark:text-gray-200 mb-6">Create New Item Request</h1>

            <!-- Session Messages for errors -->
            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md">
                    <p class="font-bold">Please correct the following errors:</p>
                    <ul class="list-disc list-inside mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('requests.store') }}" method="POST">
                @csrf
                <div class="space-y-6">
                    <!-- Item Selection -->
                    <div>
                        <label for="item_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Select Item <span class="text-red-500">*</span></label>
                        <select name="item_id" id="item_id" required class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-100">
                            <option value="">-- Select an Item --</option>
                            @forelse ($availableItems as $item)
                                <option value="{{ $item->id }}" {{ old('item_id') == $item->id ? 'selected' : '' }} data-available-quantity="{{ $item->quantity }}">
                                    {{ $item->name }} (Available: {{ $item->quantity }}) - {{ $item->category->name ?? 'Uncategorized' }}
                                </option>
                            @empty
                                <option value="" disabled>No items currently available for request.</option>
                            @endforelse
                        </select>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Only items with available stock are listed.</p>
                    </div>

                    <!-- Requested Quantity -->
                    <div>
                        <label for="requested_quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Requested Quantity <span class="text-red-500">*</span></label>
                        <input type="number" name="requested_quantity" id="requested_quantity" value="{{ old('requested_quantity', 1) }}" required min="1" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-100">
                        <p id="quantity-warning" class="mt-1 text-xs text-red-500 hidden">Requested quantity exceeds available stock.</p>
                    </div>

                    <!-- Remarks/Reason -->
                    <div>
                        <label for="remarks" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Reason/Remarks for Request</label>
                        <textarea name="remarks" id="remarks" rows="4" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-100">{{ old('remarks') }}</textarea>
                    </div>
                </div>

                <div class="mt-8 flex justify-end space-x-3">
                    <a href="{{ route('dashboard') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded-lg">
                        Cancel
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg">
                        Submit Request
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const itemSelect = document.getElementById('item_id');
            const quantityInput = document.getElementById('requested_quantity');
            const quantityWarning = document.getElementById('quantity-warning');

            function checkQuantity() {
                const selectedOption = itemSelect.options[itemSelect.selectedIndex];
                if (!selectedOption || !selectedOption.dataset.availableQuantity) {
                    quantityWarning.classList.add('hidden');
                    return;
                }
                const availableQuantity = parseInt(selectedOption.dataset.availableQuantity, 10);
                const requestedQuantity = parseInt(quantityInput.value, 10);

                if (requestedQuantity > availableQuantity) {
                    quantityWarning.classList.remove('hidden');
                    quantityInput.setCustomValidity('Requested quantity exceeds available stock.'); // For HTML5 validation
                } else {
                    quantityWarning.classList.add('hidden');
                    quantityInput.setCustomValidity('');
                }
            }

            if(itemSelect) itemSelect.addEventListener('change', checkQuantity);
            if(quantityInput) quantityInput.addEventListener('input', checkQuantity);
            
            // Initial check in case of old input
            if(itemSelect && itemSelect.value) checkQuantity(); 
        });
    </script>
</x-app-layout> 