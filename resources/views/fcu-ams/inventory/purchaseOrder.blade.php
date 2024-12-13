@extends('layouts.layout')
@section('content')
<link rel="stylesheet" href="{{ asset('css/stockin.css') }}">

<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

<div class="grid grid-cols-6">
    @include('layouts.sidebar')
    <div class="content min-h-screen bg-slate-200 col-span-5">
    <div class="bg-white m-3 shadow-md rounded-md 2xl:max-w-7xl 2xl:mx-auto">
            <div class="px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex justify-between">
                    <h1 class="text-2xl font-semibold text-gray-900 mx-auto">Purchase Order</h1>
                </div>
            </div>
        </div>
        <div class="m-3 2xl:max-w-7xl 2xl:mx-auto">
            <form method="POST" enctype="multipart/form-data" action="{{ route('purchase.order.store') }}" class="space-y-6">
                @csrf
                <div class="space-y-6">
                    @if(session('success'))
                        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-md transition-all duration-500 ease-in-out">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-md">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <ul class="list-disc list-inside text-sm text-red-700">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-6">Purchase Order Details</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="po_date" class="block text-sm font-medium text-gray-700">PO Date</label>
                                    <input type="date" id="po_date" name="po_date" 
                                        class="mt-1 block w-full px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 sm:text-sm transition duration-150 ease-in-out" required>
                                </div>
                                <div>
                                    <label for="po_number" class="block text-sm font-medium text-gray-700">PO Number</label>
                                    <input type="number" id="po_number" name="po_number" 
                                        class="mt-1 block w-full px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 sm:text-sm transition duration-150 ease-in-out" min="0" required>
                                </div>
                                <div>
                                    <label for="mr_number" class="block text-sm font-medium text-gray-700">MR Number</label>
                                    <input type="number" id="mr_number" name="mr_number" 
                                        class="mt-1 block w-full px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 sm:text-sm transition duration-150 ease-in-out" min="0" required>
                                </div>
                                <div>
                                    <label for="department_id" class="block text-sm font-medium text-gray-700">Requesting Department</label>
                                    <select id="department_id" name="department_id" 
                                        class="mt-1 block w-full px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 sm:text-sm transition duration-150 ease-in-out" required>
                                        <option value="">Select a department</option>
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                                {{ $department->department }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="supplier_id" class="block text-sm font-medium text-gray-700">Supplier</label>
                                    <select id="supplier_id" name="supplier_id" 
                                        class="mt-1 block w-full px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 sm:text-sm transition duration-150 ease-in-out" required>
                                        <option value="">Select a supplier</option>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                                {{ $supplier->supplier }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="location_id" class="block text-sm font-medium text-gray-700">Location</label>
                                    <select id="location_id" name="location_id" 
                                        class="mt-1 block w-full px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 sm:text-sm transition duration-150 ease-in-out" required>
                                        <option value="">Select a location</option>
                                        @foreach($locations as $location)
                                            <option value="{{ $location->id }}" {{ old('location_id') == $location->id ? 'selected' : '' }}>
                                                {{ $location->location }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="approved_by" class="block text-sm font-medium text-gray-700">Approved By</label>
                                    <input type="text" id="approved_by" name="approved_by" 
                                        class="mt-1 block w-full px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 sm:text-sm transition duration-150 ease-in-out" required>
                                </div>
                                <div class="md:col-span-2">
                                    <label for="note" class="block text-sm font-medium text-gray-700">Note</label>
                                    <textarea id="note" name="note" rows="3" 
                                        class="mt-1 block w-full px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 sm:text-sm transition duration-150 ease-in-out"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="p-6">
                            <div class="sm:flex sm:items-center sm:justify-between mb-6">
                                <h3 class="text-lg font-medium text-gray-900">Purchase Order Items</h3>
                                <button type="button" class="add-row-button mt-3 sm:mt-0 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Add Item
                                </button>
                            </div>
                            <div class="overflow-x-auto rounded-lg">
                                <table class="min-w-full border divide-y divide-gray-200" id="purchase-order-table">
                                    <thead class="bg-gray-50">
                                        <tr class="bg-gradient-to-r from-blue-400 to-blue-500 text-white">
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium  uppercase tracking-wider">Items/Specs</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium  uppercase tracking-wider">Quantity</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium  uppercase tracking-wider">Unit</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium  uppercase tracking-wider">Unit Price</th>
                                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium  uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="purchase-order-table-body" class="bg-white divide-y divide-gray-200">
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <input type="text" name="items_specs[]" class="block w-full px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 sm:text-sm transition duration-150 ease-in-out" required>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <input type="number" name="quantity[]" class="block w-full px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 sm:text-sm transition duration-150 ease-in-out" min="0" required>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <select name="unit_id[]" class="block w-full px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 sm:text-sm transition duration-150 ease-in-out" required>
                                                    <option value="">Select a unit</option>
                                                    @foreach($units as $unit)
                                                        <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                                                            {{ $unit->unit }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <input type="number" name="unit_price[]" class="block w-full px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 sm:text-sm transition duration-150 ease-in-out" min="0" required>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                                <button type="button" class="delete-row-button inline-flex items-center p-2 border border-transparent rounded-full text-red-600 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150 ease-in-out">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="submit" class="inline-flex items-center  mb-5 px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out">
                        <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        Save Purchase Order
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const addRowButton = document.querySelector('.add-row-button');
        const deleteRowButtons = document.querySelectorAll('.delete-row-button');
        const purchaseOrderTableBody = document.querySelector('#purchase-order-table-body');

        function createNewRow() {
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap">
                    <input type="text" name="items_specs[]" class="block w-full px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 sm:text-sm transition duration-150 ease-in-out" required>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <input type="number" name="quantity[]" class="block w-full px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 sm:text-sm transition duration-150 ease-in-out" min="0" required>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <select name="unit_id[]" class="block w-full px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 sm:text-sm transition duration-150 ease-in-out" required>
                        <option value="">Select a unit</option>
                        @foreach($units as $unit)
                            <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                                {{ $unit->unit }}
                            </option>
                        @endforeach
                    </select>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <input type="number" name="unit_price[]" class="block w-full px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 sm:text-sm transition duration-150 ease-in-out" min="0" required>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                    <button type="button" class="delete-row-button inline-flex items-center p-2 border border-transparent rounded-full text-red-600 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150 ease-in-out">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </td>
            `;
            purchaseOrderTableBody.appendChild(newRow);

            const newDeleteRowButton = newRow.querySelector('.delete-row-button');
            newDeleteRowButton.addEventListener('click', function() {
                newRow.remove();
                calculateTotal();
            });

            // Add input event listeners to new row
            const quantityInput = newRow.querySelector('input[name="quantity[]"]');
            const unitPriceInput = newRow.querySelector('input[name="unit_price[]"]');
            quantityInput.addEventListener('input', calculateTotal);
            unitPriceInput.addEventListener('input', calculateTotal);
        }

        function calculateTotal() {
            const rows = purchaseOrderTableBody.querySelectorAll('tr');
            let total = 0;

            rows.forEach(row => {
                const quantity = parseFloat(row.querySelector('input[name="quantity[]"]').value) || 0;
                const unitPrice = parseFloat(row.querySelector('input[name="unit_price[]"]').value) || 0;
                total += quantity * unitPrice;
            });

            const totalElement = document.getElementById('total-amount');
            if (totalElement) {
                totalElement.textContent = new Intl.NumberFormat('en-PH', {
                    style: 'currency',
                    currency: 'PHP'
                }).format(total);
            }
        }

        addRowButton.addEventListener('click', createNewRow);

        deleteRowButtons.forEach(function(deleteRowButton) {
            deleteRowButton.addEventListener('click', function() {
                const row = deleteRowButton.closest('tr');
                row.remove();
                calculateTotal();
            });
        });

        // Add input event listeners to initial row
        const initialQuantityInputs = document.querySelectorAll('input[name="quantity[]"]');
        const initialUnitPriceInputs = document.querySelectorAll('input[name="unit_price[]"]');
        initialQuantityInputs.forEach(input => input.addEventListener('input', calculateTotal));
        initialUnitPriceInputs.forEach(input => input.addEventListener('input', calculateTotal));
    });
</script>
@endsection
