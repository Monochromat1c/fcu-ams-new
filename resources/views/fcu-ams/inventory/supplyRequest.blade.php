@extends('layouts.layout')

@section('content')
<link rel="stylesheet" href="{{ asset('css/stockin.css') }}">
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">

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
        <div class="mb-3 2xl:max-w-7xl 2xl:mx-auto">
            @include('layouts.messageWithoutTimerForError')
        </div>
        <div class="request-form bg-white m-3 shadow-md rounded-md p-5 2xl:max-w-7xl 2xl:mx-auto">
            <form id="supply-request-form" method="POST" action="{{ route('inventory.supply.request.store') }}" onsubmit="return validateForm()">
                @csrf
                <div class="">
                    <h3 class="text-lg font-semibold mb-3">Request Details</h3>
                    <div class="mb-4">
                        <label for="item_id" class="block text-gray-700 font-bold mb-2">Items:</label>
                        <button type="button" class="ml-auto rounded-md border-2 border-slate-300 text-left px-3 py-2 bg-slate-50 text-black w-full"
                            onclick="document.getElementById('defaultModal').classList.toggle('hidden')">
                            Add Items to Request
                        </button>
                        <div class="overflow-y-auto max-h-64 hidden mt-3" id="selected-items-container">
                            <div class="max-w-4xl mx-auto overflow-x-auto overflow-y-auto rounded-lg border-2 border-slate-300">
                                <table class="min-w-full divide-y divide-gray-200 border">
                                    <thead>
                                        <tr class="bg-gradient-to-r from-blue-400 to-blue-500 text-white">
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Item</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Unit</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Unit Price</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Quantity</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Total Price</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200" id="selected-items">
                                    </tbody>
                                    <tfoot>
                                        <tr class="bg-gray-50">
                                            <td colspan="4" class="px-6 py-4 text-right font-semibold text-gray-900">Overall Total:</td>
                                            <td id="main-overall-total" class="px-6 py-4 text-left font-semibold text-gray-900">₱0.00</td>
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
                                        Add Items to Request
                                    </h3>
                                    <button type="button"
                                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 flex items-center justify-center close-modal-button">
                                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                </div>
                                <!-- Modal body -->
                                <div class="p-6">
                                    <div class="sm:flex sm:items-center sm:justify-between mb-6">
                                        <h3 class="text-lg font-medium text-gray-900">Add New Item</h3>
                                    </div>
                                    <div class="flex gap-4 mb-6">
                                        <div class="flex-1 relative">
                                            <input type="text" id="new_item_name" class="block w-full px-4 py-2 border-2 border-slate-300 rounded-md shadow-sm focus:border-blue-500 bg-slate-50 focus:ring-1 focus:ring-blue-500 sm:text-sm transition duration-150 ease-in-out" placeholder="Item Name" required>
                                            <div id="suggestions-container" class="absolute w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg z-50 max-h-60 overflow-y-auto hidden">
                                                <ul id="suggestions-list" class="py-1">
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <input type="number" id="new_item_quantity" class="block w-full px-4 py-2 border-2 border-slate-300 rounded-md shadow-sm focus:border-blue-500 bg-slate-50 focus:ring-1 focus:ring-blue-500 sm:text-sm transition duration-150 ease-in-out" min="1" placeholder="Quantity" required>
                                        </div>
                                        <button type="button" id="add-item-button" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                                            Add Item
                                        </button>
                                    </div>
                                    
                                    <!-- Added Items Table -->
                                    <div class="max-w-5xl mx-auto overflow-x-auto overflow-y-auto rounded-lg border-2 border-slate-300">
                                        <div class="max-h-[400px] overflow-y-auto">
                                            <table class="min-w-full divide-y divide-gray-200" id="added-items-table">
                                                <thead class="sticky top-0 bg-gradient-to-r from-blue-400 to-blue-500 text-white">
                                                    <tr>
                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Item Name</th>
                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Unit</th>
                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Unit Price</th>
                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Quantity</th>
                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Total Price</th>
                                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="added-items-table-body" class="bg-white divide-y divide-gray-200">
                                                </tbody>
                                                <tfoot>
                                                    <tr class="bg-gray-50">
                                                        <td colspan="4" class="px-6 py-4 text-right font-semibold text-gray-900">Overall Total:</td>
                                                        <td id="modal-overall-total" class="px-6 py-4 text-left font-semibold text-gray-900">₱0.00</td>
                                                        <td></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal footer -->
                                <div class="flex items-center justify-end p-4 border-t border-gray-200">
                                    <button type="button"
                                        class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 mr-2 close-modal-button">
                                        Cancel
                                    </button>
                                    <button type="button"
                                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center done-button">
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
                    <button type="button" id="submit-request-button" class="ml-auto rounded-md shadow-md px-5 py-2 bg-blue-600 hover:shadow-md hover:bg-blue-500
                        transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white">Submit Request</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function validateForm() {
        const items = document.querySelectorAll('#selected-items input[name^="items"]');
        if (items.length === 0) {
            alert('Please add at least one item to the request');
            return false;
        }
        return true;
    }

    function submitForm() {
        if (validateForm()) {
            const form = document.getElementById('supply-request-form');
            form.submit();
        }
    }

    function formatPrice(price) {
        if (!price || isNaN(price)) return 'N/A';
        return new Intl.NumberFormat('en-PH', {
            style: 'currency',
            currency: 'PHP'
        }).format(price);
    }

    function calculateTotalPrice(quantity, unitPrice) {
        if (!unitPrice || isNaN(unitPrice)) return 'N/A';
        return quantity * unitPrice;
    }

    function calculateOverallTotal(tableBody) {
        let total = 0;
        const rows = tableBody.querySelectorAll('tr');
        
        rows.forEach(row => {
            const unitPrice = row.getAttribute('data-unit-price');
            const quantity = row.getAttribute('data-quantity');
            
            if (unitPrice && unitPrice !== 'N/A' && !isNaN(unitPrice)) {
                total += parseFloat(unitPrice) * parseFloat(quantity);
            }
        });
        
        return total;
    }

    function updateOverallTotals() {
        // Update modal total
        const modalTableBody = document.getElementById('added-items-table-body');
        const modalTotal = calculateOverallTotal(modalTableBody);
        document.getElementById('modal-overall-total').textContent = formatPrice(modalTotal);

        // Update main view total
        const mainTableBody = document.getElementById('selected-items');
        const mainTotal = calculateOverallTotal(mainTableBody);
        document.getElementById('main-overall-total').textContent = formatPrice(mainTotal);
    }

    function updateSelectedItems() {
        const selectedItemsContainer = document.getElementById('selected-items');
        const rows = document.querySelectorAll('#added-items-table-body tr');
        selectedItemsContainer.innerHTML = '';
        const itemsContainer = document.getElementById('selected-items-container');

        if (rows.length === 0) {
            itemsContainer.classList.add('hidden');
            return;
        }

        rows.forEach((row, index) => {
            const name = row.getAttribute('data-name');
            const quantity = row.getAttribute('data-quantity');
            const unit = row.getAttribute('data-unit');
            const unitPrice = row.getAttribute('data-unit-price');
            const totalPrice = unitPrice !== 'N/A' ? calculateTotalPrice(quantity, unitPrice) : 'N/A';

            const selectedRow = document.createElement('tr');
            selectedRow.setAttribute('data-name', name);
            selectedRow.setAttribute('data-quantity', quantity);
            selectedRow.setAttribute('data-unit', unit);
            selectedRow.setAttribute('data-unit-price', unitPrice);
            selectedRow.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    ${name}
                    <input type="hidden" name="items[${index}][name]" value="${name}">
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    ${unit}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    ${unitPrice !== 'N/A' ? formatPrice(unitPrice) : 'N/A'}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    ${quantity}
                    <input type="hidden" name="items[${index}][quantity]" value="${quantity}">
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    ${totalPrice !== 'N/A' ? formatPrice(totalPrice) : 'N/A'}
                </td>
            `;
            selectedItemsContainer.appendChild(selectedRow);
        });

        itemsContainer.classList.remove('hidden');
        updateOverallTotals();
    }

    let searchTimeout = null;
    let selectedItemData = null;

    function searchItems(query) {
        if (searchTimeout) {
            clearTimeout(searchTimeout);
        }

        searchTimeout = setTimeout(() => {
            if (!query.trim()) {
                document.getElementById('suggestions-container').classList.add('hidden');
                return;
            }

            console.log('Searching for:', query);
            const url = '{{ url("/inventory/search-items") }}?query=' + encodeURIComponent(query);
            console.log('Fetching from:', url);
            
            fetch(url)
                .then(response => {
                    console.log('Response status:', response.status);
                    console.log('Response headers:', response.headers);
                    return response.text().then(text => {
                        try {
                            console.log('Raw response:', text);
                            return JSON.parse(text);
                        } catch (e) {
                            console.error('JSON parse error:', e);
                            throw new Error('Invalid JSON response');
                        }
                    });
                })
                .then(items => {
                    console.log('Parsed items:', items);
                    const suggestionsList = document.getElementById('suggestions-list');
                    const suggestionsContainer = document.getElementById('suggestions-container');
                    
                    if (!items || items.length === 0) {
                        suggestionsContainer.classList.add('hidden');
                        return;
                    }

                    suggestionsList.innerHTML = '';
                    items.forEach(item => {
                        const li = document.createElement('li');
                        li.className = 'px-4 py-2 hover:bg-blue-50 cursor-pointer';
                        const displayName = `${item.brand} - ${item.items_specs}`;
                        li.innerHTML = `
                            <div class="flex justify-between items-center">
                                <div>
                                    <span class="font-medium">${displayName}</span>
                                    <span class="text-gray-500">(${item.unit})</span>
                                </div>
                                <div class="text-right">
                                    <span class="text-blue-600">${formatPrice(item.price)}</span>
                                    <span class="text-gray-500 ml-2">${item.quantity} left</span>
                                </div>
                            </div>
                        `;
                        li.addEventListener('click', () => {
                            document.getElementById('new_item_name').value = displayName;
                            selectedItemData = {
                                name: displayName,
                                unit: item.unit,
                                price: item.price
                            };
                            suggestionsContainer.classList.add('hidden');
                            document.getElementById('new_item_quantity').focus();
                        });
                        suggestionsList.appendChild(li);
                    });
                    
                    suggestionsContainer.classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error fetching items:', error);
                });
        }, 300);
    }

    document.addEventListener('DOMContentLoaded', function () {
        console.log('DOM Content Loaded');
        // Set default request date to today
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();
        today = yyyy + '-' + mm + '-' + dd;
        document.getElementById('request_date').value = today;

        let rowCounter = 0;
        const addItemButton = document.getElementById('add-item-button');
        const addedItemsTableBody = document.getElementById('added-items-table-body');
        const modal = document.getElementById('defaultModal');
        const form = document.getElementById('supply-request-form');

        // Prevent form submission on enter key in the modal
        modal.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                if (document.activeElement === document.getElementById('new_item_name') ||
                    document.activeElement === document.getElementById('new_item_quantity')) {
                    addItemButton.click();
                }
                return false;
            }
        });

        // Handle enter key in the main form
        form.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                return false;
            }
        });

        // Close modal buttons
        document.querySelectorAll('.close-modal-button').forEach(button => {
            button.addEventListener('click', function() {
                modal.classList.add('hidden');
            });
        });

        // Done button
        document.querySelector('.done-button').addEventListener('click', function() {
            updateSelectedItems();
            modal.classList.add('hidden');
        });

        addItemButton.addEventListener('click', function(e) {
            e.preventDefault();
            const itemName = document.getElementById('new_item_name').value.trim();
            const itemQuantity = document.getElementById('new_item_quantity').value;

            if (!itemName || !itemQuantity || itemQuantity < 1) {
                alert('Please enter both item name and a valid quantity');
                return;
            }

            const totalPrice = selectedItemData ? calculateTotalPrice(itemQuantity, selectedItemData.price) : 'N/A';

            const newRow = document.createElement('tr');
            newRow.setAttribute('data-name', itemName);
            newRow.setAttribute('data-quantity', itemQuantity);
            newRow.setAttribute('data-unit', selectedItemData ? selectedItemData.unit : 'N/A');
            newRow.setAttribute('data-unit-price', selectedItemData ? selectedItemData.price : 'N/A');
            
            newRow.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${itemName}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${selectedItemData ? selectedItemData.unit : 'N/A'}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${selectedItemData ? formatPrice(selectedItemData.price) : 'N/A'}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${itemQuantity}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${selectedItemData ? formatPrice(totalPrice) : 'N/A'}</td>
                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                    <button type="button" class="delete-row-button inline-flex items-center p-2 border border-transparent rounded-full text-red-600 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150 ease-in-out">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </td>
            `;

            // Add delete functionality to the new row
            const deleteButton = newRow.querySelector('.delete-row-button');
            deleteButton.addEventListener('click', function() {
                newRow.remove();
                updateSelectedItems();
                updateOverallTotals();
            });

            addedItemsTableBody.appendChild(newRow);
            updateSelectedItems();
            updateOverallTotals();

            // Clear input fields and selected item data
            document.getElementById('new_item_name').value = '';
            document.getElementById('new_item_quantity').value = '';
            selectedItemData = null;
            document.getElementById('new_item_name').focus();
            
            rowCounter++;
        });

        // Add event listener for opening the modal
        document.querySelector('button[onclick*="defaultModal"]').addEventListener('click', function(e) {
            e.preventDefault();
            modal.classList.remove('hidden');
            setTimeout(() => {
                document.getElementById('new_item_name').focus();
            }, 100);
        });

        // Add submit button handler
        document.getElementById('submit-request-button').addEventListener('click', function(e) {
            e.preventDefault();
            submitForm();
        });

        const itemNameInput = document.getElementById('new_item_name');
        const suggestionsContainer = document.getElementById('suggestions-container');

        if (!itemNameInput) {
            console.error('Item name input not found!');
            return;
        }

        // Add input event listener for search
        itemNameInput.addEventListener('input', function() {
            const query = this.value.trim();
            console.log('Input event triggered:', query);
            if (query.length >= 2) {
                searchItems(query);
            } else {
                suggestionsContainer.classList.add('hidden');
            }
        });

        // Close suggestions when clicking outside
        document.addEventListener('click', function(e) {
            if (!itemNameInput.contains(e.target) && !suggestionsContainer.contains(e.target)) {
                suggestionsContainer.classList.add('hidden');
            }
        });
    });
</script>
@endsection
