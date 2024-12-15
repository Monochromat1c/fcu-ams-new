@extends('layouts.layout')
@section('content')
<link rel="stylesheet" href="{{ asset('css/stockin.css') }}">
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

<div class="grid grid-cols-6">
    @include('layouts.sidebar')
    <div class="content min-h-screen bg-slate-200 col-span-5">
        <!-- Header -->
        <div class="bg-white m-3 shadow-md rounded-md 2xl:max-w-7xl 2xl:mx-auto">
            <div class="px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex justify-between">
                    <h1 class="text-2xl font-semibold text-gray-900 mx-auto">Request Supplies</h1>
                </div>
            </div>
        </div>
        <div class="request-form bg-white m-3 shadow-md rounded-md p-5 2xl:max-w-7xl 2xl:mx-auto">
            <form method="POST" action="{{ route('inventory.supply.request.store') }}">
                @csrf
                <div class="">
                    <div class="mb-3">
                        @include('layouts.messageWithoutTimerForError')
                    </div>
                    <h3 class="text-lg font-semibold mb-3">Request Details</h3>
                    <div class="mb-4">
                        <label for="item_id" class="block text-gray-700 font-bold mb-2">Items:</label>
                        <button type="button" class="ml-auto rounded-md border-2 border-slate-300 text-left px-3 py-2 bg-slate-50 text-black w-full"
                            onclick="document.getElementById('defaultModal').classList.toggle('hidden')">
                            Select Items to Request
                        </button>
                        <div class="overflow-y-auto max-h-64 hidden mt-3" id="selected-items-container">
                            <div class="max-w-4xl mx-auto overflow-x-auto overflow-y-auto rounded-lg border-2 border-slate-300">
                                <table class="min-w-full divide-y divide-gray-200 border">
                                    <thead>
                                        <tr class="bg-gradient-to-r from-blue-400 to-blue-500 text-white">
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Item</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Quantity</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Price</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200" id="selected-items">
                                    </tbody>
                                    <tfoot>
                                        <tr class="font-bold bg-gray-50">
                                            <td class="px-6 py-3 invisible" colspan="">Overall Price:</td>
                                            <td class="px-6 py-3 invisible" colspan="">Overall Price:</td>
                                            <td class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider" colspan="">Overall Price:</td>
                                            <td class="px-6 py-3 text-sm font-semibold text-gray-900" id="overall-price">₱0.00</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div id="defaultModal" style="min-height:100vh; background-color: rgba(0, 0, 0, 0.5);" tabindex="-1" aria-hidden="true"
                        class="modalBg flex fixed top-0 left-0 right-0 bottom-0 z-50 p-4 w-full md:inset-0 hidden">
                        <div class="relative my-auto mx-auto p-4 w-full max-w-4xl h-full md:h-auto">
                            <!-- Modal content -->
                            <div class="relative bg-white rounded-lg shadow-xl dark:bg-white border-0">
                                <!-- Modal header -->
                                <div class="flex items-center justify-between p-4 border-b rounded-t">
                                    <h3 class="text-xl font-semibold text-gray-900">
                                        Select Items to Request
                                    </h3>
                                    <div class="flex items-center space-x-4">
                                        <div class="relative">
                                            <input type="text" id="modal-search" placeholder="Search items..." 
                                                class="pl-10 pr-4 py-2 rounded-lg border-2 border-slate-300 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 w-64">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 absolute left-3 top-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                        </div>
                                        <button type="button"
                                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 flex items-center justify-center"
                                            onclick="document.getElementById('defaultModal').classList.toggle('hidden')">
                                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                    </div>
                                </div>
                                <!-- Modal body -->
                                <div class="p-6">
                                    <div class="max-w-5xl mx-auto overflow-x-auto overflow-y-auto rounded-lg border-2 border-slate-300">
                                        <div class="max-h-[60vh] overflow-y-auto">
                                            <table class="min-w-full divide-y divide-gray-200">
                                                <thead>
                                                    <tr class="bg-gradient-to-r from-blue-400 to-blue-500 text-white">
                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Item</th>
                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Quantity</th>
                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Unit</th>
                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Unit Price</th>
                                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white divide-y divide-gray-200">
                                                    @foreach($inventories as $inventory)
                                                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                                {{ $inventory->brand->brand }}
                                                                {{ $inventory->items_specs }}</td>
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                                {{ $inventory->quantity }}</td>
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                                {{ $inventory->unit->unit }}</td>
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                                ₱{{ number_format($inventory->unit_price, 2) }}</td>
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                                <div class="flex items-center gap-4">
                                                                    <label class="inline-flex items-center">
                                                                        <input type="checkbox"
                                                                            id="item_{{ $inventory->id }}" 
                                                                            class="form-checkbox item-checkbox h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500"
                                                                            data-id="{{ $inventory->id }}"
                                                                            data-brand="{{ $inventory->brand->brand }}"
                                                                            data-specs="{{ $inventory->items_specs }}"
                                                                            data-price="{{ $inventory->unit_price }}"
                                                                            onchange="handleItemSelection(this)">
                                                                    </label>
                                                                    <input type="number" 
                                                                        id="quantity_{{ $inventory->id }}"
                                                                        class="quantity-input hidden w-24 px-3 py-1.5 text-sm border border-gray-300 rounded-md focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                                                                        min="1"
                                                                        max="{{ $inventory->quantity }}"
                                                                        placeholder="Qty"
                                                                        onchange="updateSelectedItems()">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal footer -->
                                <div class="flex items-center justify-end p-4 border-t border-gray-200">
                                    <button type="button"
                                        class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 mr-2"
                                        onclick="document.getElementById('defaultModal').classList.toggle('hidden')">
                                        Cancel
                                    </button>
                                    <button type="button"
                                        class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5"
                                        onclick="document.getElementById('defaultModal').classList.toggle('hidden')">
                                        Done
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(isset($departments))
                        <div class="mb-4">
                            <label for="department_id" class="block text-gray-700 font-bold mb-2">Department:</label>
                            <select id="department_id" name="department_id" class="w-full p-2 border-2 border-slate-300 rounded-md bg-slate-50" required>
                                <option value="">Select a department</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" 
                                        {{ isset($userDepartment) && $userDepartment && $userDepartment->id == $department->id ? 'selected' : '' }}>
                                        {{ $department->department }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @else
                        <div class="alert alert-warning">No departments available</div>
                    @endif

                    <div class="mb-4">
                        <label for="request_date" class="block text-gray-700 font-bold mb-2">Request Date:</label>
                        <input type="date" id="request_date" name="request_date" class="w-full p-2 border-2 border-slate-300 rounded-md bg-slate-50" required>
                    </div>

                    <div class="mb-4">
                        <label for="requester" class="block text-gray-700 font-bold mb-2">Requester Name:</label>
                        <input type="text" id="requester" name="requester" 
                            value="{{ $user->first_name }} {{ $user->middle_name }} {{ $user->last_name }}" 
                            class="w-full p-2 border-2 border-slate-300 rounded-md bg-slate-50" required>
                    </div>

                    <div class="mb-4">
                        <label for="notes" class="block text-gray-700 font-bold mb-2">Notes (Optional):</label>
                        <textarea id="notes" name="notes" rows="3" class="w-full p-2 border-2 border-slate-300 rounded-md bg-slate-50"></textarea>
                    </div>
                </div>

                <div class="space-x-2 flex">
                    <button type="submit" class="ml-auto rounded-md shadow-md px-5 py-2 bg-blue-600 hover:shadow-md hover:bg-blue-500
                        transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white">Submit Request</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function handleItemSelection(checkbox) {
        const id = checkbox.dataset.id;
        const quantityInput = document.getElementById(`quantity_${id}`);
        
        if (checkbox.checked) {
            quantityInput.classList.remove('hidden');
            quantityInput.value = 1;
            updateSelectedItems();
        } else {
            quantityInput.classList.add('hidden');
            quantityInput.value = '';
            updateSelectedItems();
        }
    }

    function updateSelectedItems() {
        const selectedItemsContainer = document.getElementById('selected-items');
        const checkboxes = document.querySelectorAll('.item-checkbox:checked');
        let overallPrice = 0;
        selectedItemsContainer.innerHTML = '';

        checkboxes.forEach(checkbox => {
            const id = checkbox.dataset.id;
            const quantityInput = document.getElementById(`quantity_${id}`);
            const quantity = parseInt(quantityInput.value) || 0;
            const price = parseFloat(checkbox.dataset.price);
            const total = quantity * price;
            overallPrice += total;

            // Add to selected items table
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    ${checkbox.dataset.brand} ${checkbox.dataset.specs}
                    <input type="hidden" name="items[${id}][id]" value="${id}">
                    <input type="hidden" name="items[${id}][quantity]" value="${quantity}">
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${quantity}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">₱${price.toFixed(2)}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">₱${total.toFixed(2)}</td>
            `;
            selectedItemsContainer.appendChild(row);
        });

        // Update overall price
        document.getElementById('overall-price').textContent = `₱${overallPrice.toFixed(2)}`;
        
        // Show/hide the selected items container
        const container = document.getElementById('selected-items-container');
        container.classList.toggle('hidden', checkboxes.length === 0);
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Set default request date to today
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();
        today = yyyy + '-' + mm + '-' + dd;
        document.getElementById('request_date').value = today;

        // Search functionality for modal
        const modalSearchInput = document.getElementById('modal-search');
        modalSearchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#defaultModal tbody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    });
</script>
@endsection
