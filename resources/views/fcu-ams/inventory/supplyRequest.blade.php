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
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Available Stock</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200" id="selected-items">
                                    </tbody>
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
                                                class="pl-10 pr-4 py-2 rounded-lg border-2 border-slate-300 focus:border-blue-500 focus:ring-blue-500">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </div>
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
                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Available Stock</th>
                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Unit</th>
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
                                                                <div class="flex items-center gap-3 justify-center">
                                                                    <input type="checkbox"
                                                                        id="item_id_{{ $inventory->id }}" 
                                                                        name="item_id[]"
                                                                        value="{{ $inventory->id }}"
                                                                        class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500"
                                                                        onchange="handleItemSelection(this)">
                                                                    <input type="number"
                                                                        id="quantity_{{ $inventory->id }}"
                                                                        name="quantity[]"
                                                                        class="w-24 p-2 border-2 border-slate-300 rounded-md focus:ring-blue-500 focus:border-blue-500 disabled:bg-slate-50 disabled:text-gray-500"
                                                                        placeholder="Qty"
                                                                        min="1"
                                                                        max="{{ $inventory->quantity }}"
                                                                        value="1"
                                                                        disabled>
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
                                        onclick="document.getElementById('defaultModal').classList.toggle('hidden'); document.getElementById('selected-items-container').classList.remove('hidden');">
                                        Select Items
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
    document.addEventListener('DOMContentLoaded', function () {
        var selectedItemsTable = document.getElementById('selected-items');
        var modal = document.getElementById('defaultModal');

        window.handleItemSelection = function(checkbox) {
            var quantityInput = checkbox.nextElementSibling;
            var row = checkbox.closest('tr');
            var label = row.cells[0].textContent.trim();
            var availableStock = row.cells[1].textContent.trim();

            quantityInput.disabled = !checkbox.checked;
            
            if (checkbox.checked) {
                // Add row to display table
                var newRow = document.createElement('tr');
                newRow.id = 'selected_' + checkbox.value;
                
                var itemCell = document.createElement('td');
                var quantityCell = document.createElement('td');
                var stockCell = document.createElement('td');

                itemCell.textContent = label;
                itemCell.className = 'px-6 py-4';

                quantityCell.textContent = quantityInput.value;
                quantityCell.className = 'px-6 py-4';
                quantityCell.id = 'qty_' + checkbox.value;

                stockCell.textContent = availableStock;
                stockCell.className = 'px-6 py-4';

                newRow.appendChild(itemCell);
                newRow.appendChild(quantityCell);
                newRow.appendChild(stockCell);

                selectedItemsTable.appendChild(newRow);
                document.getElementById('selected-items-container').classList.remove('hidden');
            } else {
                var selectedRow = document.getElementById('selected_' + checkbox.value);
                if (selectedRow) {
                    selectedRow.remove();
                }
                
                if (selectedItemsTable.rows.length === 0) {
                    document.getElementById('selected-items-container').classList.add('hidden');
                }
            }
        };

        // Add event listeners for quantity changes
        modal.addEventListener('input', function(e) {
            if (e.target.type === 'number') {
                var row = e.target.closest('tr');
                var checkbox = row.querySelector('input[type="checkbox"]');
                if (checkbox && checkbox.checked) {
                    var qtyDisplay = document.getElementById('qty_' + checkbox.value);
                    if (qtyDisplay) {
                        qtyDisplay.textContent = e.target.value;
                    }
                }
            }
        });

        // Set default request date to today
        document.getElementById('request_date').valueAsDate = new Date();
    });
</script>
@endsection
