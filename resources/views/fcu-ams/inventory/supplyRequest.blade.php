@extends('layouts.layout')

@section('content')
<link rel="stylesheet" href="{{ asset('css/stockin.css') }}">
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">

<div x-data="{ sidebarOpen: true }" class="grid grid-cols-6">
    <div x-show="sidebarOpen" class="col-span-1">
        @include('layouts.sidebar')
    </div>
    <div :class="{ 'col-span-5': sidebarOpen, 'col-span-6': !sidebarOpen }" class="bg-slate-200 content min-h-screen">
        <!-- Header -->
        <nav class="bg-white flex justify-between py-3 px-4 m-3 2xl:max-w-7xl 2xl:mx-auto shadow-md rounded-md">
            <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <h1 class="my-auto text-3xl">Request Supplies</h1>
            <div class="w-10"></div>
        </nav>
        <div class="mb-3 2xl:max-w-7xl 2xl:mx-auto">
            @include('layouts.messageWithoutTimerForError')
        </div>
        <div class="request-form bg-white m-3 shadow-md rounded-md p-5 2xl:max-w-7xl 2xl:mx-auto">
            <form id="supply-request-form" method="POST" action="{{ route('inventory.supply.request.store') }}">
                @csrf
                <input type="hidden" id="selected_items" name="selected_items" />
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
                        class="modalBg flex overflow-y-auto fixed top-0 left-0 right-0 bottom-0 z-50 p-4 w-full md:inset-0 hidden">
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
                                                <!-- Add loading spinner -->
                                                <div id="suggestions-loading" class="hidden">
                                                    <div class="flex items-center justify-center p-4">
                                                        <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-500"></div>
                                                        <span class="ml-2 text-gray-600">Searching...</span>
                                                    </div>
                                                </div>
                                                <ul id="suggestions-list" class="py-1">
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <input type="number" id="new_item_quantity" class="block w-full rounded-md border-0 py-1.5 pl-3 pr-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" placeholder="Quantity" min="1" required>
                                        </div>
                                        <button type="button" id="add-item-button" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                                            Add Item
                                        </button>
                                        {{-- DO NOT REMOVE THIS BUTTON, IT WILL AFFECT THE FUNCTIONALITY OF THE ITEM NOT FOUND MODAL --}}
                                        <button type="button" id="request-new-item-button" class="hidden px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out">
                                            Request New Item
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
                                        class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 close-modal-button">
                                        Cancel
                                    </button>
                                    <button type="button"
                                        class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center done-button">
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
                        <input type="datetime-local" id="request_date" name="request_date" class="w-full p-2 border-2 border-slate-300 rounded-md bg-slate-50" required>
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
    <!-- Empty Field Validation Modal -->
    <div id="validationModal" style="min-height:100vh; background-color: rgba(0, 0, 0, 0.5);" tabindex="-1" aria-hidden="true"
        class="modalBg flex fixed top-0 left-0 right-0 bottom-0 z-50 p-4 w-full md:inset-0 hidden">
        <div class="relative my-auto mx-auto p-4 w-full max-w-md h-full md:h-auto">
            <div class="relative bg-white rounded-lg shadow-xl dark:bg-white border-0">
                <div class="flex items-center justify-between p-4 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900">
                        Validation Error
                    </h3>
                    <button type="button" class="close-validation-modal text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 flex items-center justify-center">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="p-6">
                    <p class="text-gray-700">Please enter both item name and a valid quantity.</p>
                </div>
                <div class="flex items-center justify-end p-4 border-t border-gray-200">
                    <button type="button" class="close-validation-modal text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                        OK
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Quantity Validation Modal -->
    <div id="quantityValidationModal" style="min-height:100vh; background-color: rgba(0, 0, 0, 0.5);" tabindex="-1" aria-hidden="true"
        class="modalBg flex fixed top-0 left-0 right-0 bottom-0 z-50 p-4 w-full md:inset-0 hidden">
        <div class="relative my-auto mx-auto p-4 w-full max-w-md h-full md:h-auto">
            <div class="relative bg-white rounded-lg shadow-xl dark:bg-white border-0">
                <div class="flex items-center justify-between p-4 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-red-600">
                        Quantity Validation Error
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 flex items-center justify-center">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
                <div class="p-6">
                    <p class="text-gray-700">The requested quantity exceeds the available stock. Maximum available quantity is <span id="maxQuantitySpan" class="font-semibold"></span>.</p>
                </div>
                <div class="flex items-center justify-end p-4 border-t border-gray-200">
                    <button type="button"
                        class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                        OK
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Insufficient Stock Warning Modal -->
    <div id="insufficientStockModal" style="min-height:100vh; background-color: rgba(0, 0, 0, 0.5);" tabindex="-1" aria-hidden="true"
        class="modalBg flex fixed top-0 left-0 right-0 bottom-0 z-50 p-4 w-full md:inset-0 hidden">
        <div class="relative my-auto mx-auto p-4 w-full max-w-md h-full md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-yellow-600">
                        ⚠️ Insufficient Stock Warning
                    </h3>
                    <button type="button" onclick="closeInsufficientStockModal()"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 flex items-center justify-center">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6">
                    <p id="insufficientStockMessage" class="text-gray-700"></p>
                    <p class="mt-4 text-sm text-gray-600">Your request will be forwarded to the admin for approval.</p>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center justify-end p-4 border-t border-gray-200">
                    <button type="button" onclick="closeInsufficientStockModal()"
                        class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                        Continue
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Item Not Found Modal -->
    <div id="itemNotFoundModal" style="min-height:100vh; background-color: rgba(0, 0, 0, 0.5);" tabindex="-1" aria-hidden="true"
        class="modalBg flex fixed top-0 left-0 right-0 bottom-0 z-50 p-4 w-full md:inset-0 hidden">
        <div class="relative my-auto mx-auto p-4 w-full max-w-md h-full md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 border-b rounded-t bg-red-500">
                    <h3 class="text-xl font-semibold text-white">
                        Item Not Found in Inventory
                    </h3>
                    <button type="button" class="text-white bg-transparent hover:bg-red-600 hover:text-gray-100 rounded-lg text-sm w-8 h-8 flex items-center justify-center item-not-found-close-button">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div>
                            <p id="itemNotFoundMessage" class="text-gray-700 font-medium"></p>
                            <p class="text-sm text-gray-500 mt-1">Please try searching with a different keyword or check if the item name is correct.</p>
                        </div>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center justify-end p-4 border-t border-gray-200">
                    <button type="button" class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-sm font-medium px-5 py-2.5 hover:scale-105 transition-all duration-200 item-not-found-close-button">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Brand Modal -->
    <x-add-item-modal 
        title="Add New Brand"
        id="add-brand-modal"
        route="{{ route('brand.add') }}"
        field="brand"
    />
    
    <!-- Add Unit Modal -->
    <x-add-item-modal 
        title="Add New Unit"
        id="add-unit-modal"
        route="{{ route('unit.add') }}"
        field="unit"
    />

    <!-- Add Supplier Modal -->
    <x-add-item-modal 
        title="Add New Supplier"
        id="add-supplier-modal"
        route="{{ route('supplier.add') }}"
        field="supplier"
    />
</div>

<script>
    function showQuantityValidationModal(maxQuantity) {
        document.getElementById('maxQuantitySpan').textContent = maxQuantity;
        document.getElementById('quantityValidationModal').classList.remove('hidden');
    }
    
    function closeQuantityValidationModal() {
        document.getElementById('quantityValidationModal').classList.add('hidden');
    }

    function showValidationModal() {
        const modal = document.getElementById('validationModal');
        modal.classList.remove('hidden');
    }
    
    document.querySelectorAll('.close-validation-modal').forEach(button => {
        button.addEventListener('click', function() {
            document.getElementById('validationModal').classList.add('hidden');
        });
    });

    function submitForm() {
        const form = document.getElementById('supply-request-form');
        form.submit();
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
        const rows = document.querySelectorAll('#added-items-table tbody tr');
        const items = [];

        rows.forEach(row => {
            const isNewItem = row.getAttribute('data-is-new-item') === 'true';
            const item = {
                name: row.getAttribute('data-name'),
                quantity: row.getAttribute('data-quantity'),
                is_new_item: isNewItem
            };

            if (isNewItem) {
                item.brand_id = row.getAttribute('data-brand-id');
                item.unit_id = row.getAttribute('data-unit-id');
                item.supplier_id = row.getAttribute('data-supplier-id');
                item.unit_price = row.getAttribute('data-unit-price');
            }

            items.push(item);
        });

        document.querySelector('#selected_items').value = JSON.stringify({ items: items });
    }

    function showInsufficientStockModal(itemName, currentStock, requestedQuantity, unit) {
        const message = `Insufficient stock for ${itemName}. Current stock: ${currentStock}. Your request: ${requestedQuantity}.`;
        document.getElementById('insufficientStockMessage').textContent = message;
        document.getElementById('insufficientStockModal').classList.remove('hidden');
    }

    function closeInsufficientStockModal() {
        document.getElementById('insufficientStockModal').classList.add('hidden');
    }

    let searchTimeout = null;
    let selectedItemData = null;

    function updateQuantityField(selectedItem) {
        const quantityInput = document.getElementById('new_item_quantity');
        quantityInput.value = 1;
    }

    function searchItems(query) {
        if (searchTimeout) {
            clearTimeout(searchTimeout);
        }

        const suggestionsContainer = document.getElementById('suggestions-container');
        const loadingSpinner = document.getElementById('suggestions-loading');
        const suggestionsList = document.getElementById('suggestions-list');

        if (!query.trim()) {
            suggestionsContainer.classList.add('hidden');
            return;
        }

        // Show loading spinner and container
        suggestionsContainer.classList.remove('hidden');
        loadingSpinner.classList.remove('hidden');
        suggestionsList.classList.add('hidden');

        searchTimeout = setTimeout(() => {
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
                    
                    // Hide loading spinner and show suggestions list
                    loadingSpinner.classList.add('hidden');
                    suggestionsList.classList.remove('hidden');
                    
                    if (!items || items.length === 0) {
                        suggestionsList.innerHTML = '<li class="px-4 py-2 text-gray-500">No items found</li>';
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
                                    <span class="text-gray-500 ml-2">${item.quantity} left${item.quantity == 0 ? ' <span class="text-red-500 font-medium">(Pre-Order)</span>' : ''}</span>
                                </div>
                            </div>
                        `;
                        li.addEventListener('click', () => {
                            document.getElementById('new_item_name').value = displayName;
                            selectedItemData = {
                                name: displayName,
                                unit: item.unit,
                                price: item.price,
                                quantity: item.quantity
                            };
                            updateQuantityField(selectedItemData);
                            suggestionsContainer.classList.add('hidden');
                            document.getElementById('new_item_quantity').focus();
                        });
                        suggestionsList.appendChild(li);
                    });
                })
                .catch(error => {
                    console.error('Error fetching items:', error);
                    loadingSpinner.classList.add('hidden');
                    suggestionsList.classList.remove('hidden');
                    suggestionsList.innerHTML = '<li class="px-4 py-2 text-red-500">Error loading items</li>';
                });
        }, 300);
    }

    function showItemNotFoundModal(itemName) {
        document.getElementById('itemNotFoundMessage').textContent = `The item "${itemName}" was not found in the inventory.`;
        document.getElementById('itemNotFoundModal').classList.remove('hidden');
    }

    function populateDropdowns() {
        // Populate brands dropdown
        fetch('{{ route("inventory.brands") }}')
            .then(response => response.json())
            .then(brands => {
                const brandSelect = document.getElementById('brand_id_not_found');
                brands.forEach(brand => {
                    const option = new Option(brand.brand, brand.id);
                    brandSelect.add(option);
                });
            });

        // Populate units dropdown
        fetch('{{ route("inventory.units") }}')
            .then(response => response.json())
            .then(units => {
                const unitSelect = document.getElementById('unit_id_not_found');
                units.forEach(unit => {
                    const option = new Option(unit.unit, unit.id);
                    unitSelect.add(option);
                });
            });

        // Populate suppliers dropdown
        fetch('{{ route("inventory.suppliers") }}')
            .then(response => response.json())
            .then(suppliers => {
                const supplierSelect = document.getElementById('supplier_id_not_found');
                suppliers.forEach(supplier => {
                    const option = new Option(supplier.supplier, supplier.id);
                    supplierSelect.add(option);
                });
            });
    }

    function submitRequestedItem(event) {
        event.preventDefault();
        
        const formData = {
            brand_id: document.getElementById('brand_id_not_found').value,
            items_specs: document.getElementById('items_specs_not_found').value,
            unit_id: document.getElementById('unit_id_not_found').value,
            quantity: document.getElementById('quantity_not_found').value,
            unit_price: document.getElementById('unit_price_not_found').value,
            supplier_id: document.getElementById('supplier_id_not_found').value,
        };

        fetch('{{ route("inventory.request.item.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('itemNotFoundModal').classList.add('hidden');
                // You might want to show a success message here
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // You might want to show an error message here
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        console.log('DOM Content Loaded');
        // Set default request date to current date and time
        var now = new Date();
        var year = now.getFullYear();
        var month = String(now.getMonth() + 1).padStart(2, '0');
        var day = String(now.getDate()).padStart(2, '0');
        var hours = String(now.getHours()).padStart(2, '0');
        var minutes = String(now.getMinutes()).padStart(2, '0');
        var datetime = `${year}-${month}-${day}T${hours}:${minutes}`;
        document.getElementById('request_date').value = datetime;

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

        // Handle form submission
        const supplyRequestForm = document.getElementById('supply-request-form');
        const submitButton = document.getElementById('submit-request-button');

        submitButton.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Get all items from the table
            const rows = document.querySelectorAll('#added-items-table tbody tr');
            if (rows.length === 0) {
                document.getElementById('validationModal').classList.remove('hidden');
                return;
            }

            const items = [];
            rows.forEach(row => {
                const isNewItem = row.getAttribute('data-is-new-item') === 'true';
                const item = {
                    name: row.getAttribute('data-name'),
                    quantity: row.getAttribute('data-quantity'),
                    is_new_item: isNewItem
                };

                if (isNewItem) {
                    item.brand_id = row.getAttribute('data-brand-id');
                    item.unit_id = row.getAttribute('data-unit-id');
                    item.supplier_id = row.getAttribute('data-supplier-id');
                    item.unit_price = row.getAttribute('data-unit-price');
                }

                items.push(item);
            });

            // Set the items data in the hidden input
            document.getElementById('selected_items').value = JSON.stringify({ items: items });
            
            // Submit the form
            supplyRequestForm.submit();
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
            const itemQuantity = parseInt(document.getElementById('new_item_quantity').value);

            if (!itemName || !itemQuantity || itemQuantity < 1) {
                showValidationModal();
                return;
            }

            // Check if we have selected item data
            if (!selectedItemData) {
                showItemNotFoundModal(itemName);
                return;
            }

            // Show warning if quantity exceeds available stock
            if (selectedItemData.quantity < itemQuantity) {
                showInsufficientStockModal(itemName, selectedItemData.quantity, itemQuantity, selectedItemData.unit);
            }

            const totalPrice = calculateTotalPrice(itemQuantity, selectedItemData.price);

            const newRow = document.createElement('tr');
            newRow.setAttribute('data-name', itemName);
            newRow.setAttribute('data-quantity', itemQuantity);
            newRow.setAttribute('data-unit', selectedItemData.unit);
            newRow.setAttribute('data-unit-price', selectedItemData.price);
            
            newRow.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${itemName}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${selectedItemData.unit}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${formatPrice(selectedItemData.price)}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${itemQuantity}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${formatPrice(totalPrice)}</td>
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

        const requestNewItemButton = document.getElementById('request-new-item-button');
        requestNewItemButton.addEventListener('click', function(e) {
            e.preventDefault();
            const itemName = document.getElementById('new_item_name').value.trim();
            const itemQuantity = document.getElementById('new_item_quantity').value;
        
            // Set default values if empty
            if (itemName) {
                document.getElementById('item_name_not_found').value = itemName;
            }
            if (itemQuantity) {
                document.getElementById('quantity_not_found').value = itemQuantity;
            }
        
            // Show the modal directly
            document.getElementById('itemNotFoundModal').classList.remove('hidden');
            document.getElementById('itemNotFoundMessage').textContent = 'Please provide the details for the new item you want to request.';
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
            searchItems(query);
        });

        // Close suggestions when clicking outside
        document.addEventListener('click', function(e) {
            if (!itemNameInput.contains(e.target) && !suggestionsContainer.contains(e.target)) {
                suggestionsContainer.classList.add('hidden');
            }
        });

        // Add event listeners for the new modal's close buttons
        document.getElementById('itemNotFoundModal').querySelectorAll('.item-not-found-close-button').forEach(button => {
            button.addEventListener('click', function() {
                document.getElementById('itemNotFoundModal').classList.add('hidden');
            });
        });

        // Add form submit handler
        const requestedItemForm = document.querySelector('#itemNotFoundModal form');
        requestedItemForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const brandSelect = document.getElementById('brand_id_not_found');
            const unitSelect = document.getElementById('unit_id_not_found');
            const brandText = brandSelect.options[brandSelect.selectedIndex].text;
            const itemSpecs = document.getElementById('items_specs_not_found').value;
            const unitText = unitSelect.options[unitSelect.selectedIndex].text;
            const quantity = document.getElementById('quantity_not_found').value;
            const unitPrice = document.getElementById('unit_price_not_found').value;
            const totalPrice = calculateTotalPrice(quantity, unitPrice);

            // Create new row
            const newRow = document.createElement('tr');
            const displayName = `${brandText} - ${itemSpecs}`;
            newRow.setAttribute('data-name', displayName);
            newRow.setAttribute('data-quantity', quantity);
            newRow.setAttribute('data-unit', unitText);
            newRow.setAttribute('data-unit-price', unitPrice);
            newRow.setAttribute('data-is-new-item', 'true');
            newRow.setAttribute('data-brand-id', brandSelect.value);
            newRow.setAttribute('data-unit-id', unitSelect.value);
            newRow.setAttribute('data-supplier-id', document.getElementById('supplier_id_not_found').value);
            
            newRow.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${displayName}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${unitText}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${formatPrice(unitPrice)}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${quantity}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${formatPrice(totalPrice)}</td>
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

            // Clear form and close modal
            requestedItemForm.reset();
            document.getElementById('itemNotFoundModal').classList.add('hidden');
        });
    });

    // Function to update select options
    function updateSelectOptions(selectId, items) {
        const select = document.getElementById(selectId);
        const currentValue = select.value;
        
        // Clear existing options
        select.innerHTML = '<option value="">Select an option</option>';
        
        // Add new options
        items.forEach(item => {
            const option = document.createElement('option');
            option.value = item.id;
            option.textContent = selectId.includes('brand') ? item.brand : item.unit;
            select.appendChild(option);
        });
        
        // Restore selected value if it still exists
        if (currentValue) {
            select.value = currentValue;
        }
    }
    
    // Event listeners for modal form submissions
    document.querySelectorAll('.modal form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const url = this.getAttribute('action');
            
            fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
            if (data.success) {
                // Update the corresponding select options
                if (url.includes('brand')) {
                    updateSelectOptions('brand_id_not_found', data.brands);
                } else if (url.includes('unit')) {
                    updateSelectOptions('unit_id_not_found', data.units);
                } else if (url.includes('supplier')) {  // Add this condition
                    updateSelectOptions('supplier_id_not_found', data.suppliers);
                }
                    
                    // Close the modal
                    const modal = this.closest('.modal');
                    if (modal) {
                        modal.classList.add('hidden');
                    }
                    
                    // Clear the form
                    this.reset();
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
</script>
@endsection
