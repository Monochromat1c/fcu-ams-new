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
                            Add Items to Request
                        </button>
                        <div class="overflow-y-auto max-h-64 hidden mt-3" id="selected-items-container">
                            <div class="max-w-4xl mx-auto overflow-x-auto overflow-y-auto rounded-lg border-2 border-slate-300">
                                <table class="min-w-full divide-y divide-gray-200 border">
                                    <thead>
                                        <tr class="bg-gradient-to-r from-blue-400 to-blue-500 text-white">
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Item</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Quantity</th>
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
                                        Add Items to Request
                                    </h3>
                                    <button type="button"
                                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 flex items-center justify-center"
                                        onclick="document.getElementById('defaultModal').classList.toggle('hidden')">
                                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                </div>
                                <!-- Modal body -->
                                <div class="p-6">
                                    <div class="sm:flex sm:items-center sm:justify-between mb-6">
                                        <h3 class="text-lg font-medium text-gray-900">Request Items</h3>
                                        <button type="button" class="add-row-button mt-3 sm:mt-0 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            </svg>
                                            Add Item
                                        </button>
                                    </div>
                                    <div class="max-w-5xl mx-auto overflow-x-auto overflow-y-auto rounded-lg border-2 border-slate-300">
                                        <div class="max-h-[60vh] overflow-y-auto">
                                            <table class="min-w-full divide-y divide-gray-200" id="request-items-table">
                                                <thead>
                                                    <tr class="bg-gradient-to-r from-blue-400 to-blue-500 text-white">
                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Item Name</th>
                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Quantity</th>
                                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="request-items-table-body" class="bg-white divide-y divide-gray-200">
                                                    <tr>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <input type="text" name="items[0][name]" class="block w-full px-4 py-2 border-2 border-slate-300 rounded-md shadow-sm focus:border-blue-500 bg-slate-50 focus:ring-1 focus:ring-blue-500 sm:text-sm transition duration-150 ease-in-out" placeholder="Item Name" required>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <input type="number" name="items[0][quantity]" class="block w-full px-4 py-2 border-2 border-slate-300 rounded-md shadow-sm focus:border-blue-500 bg-slate-50 focus:ring-1 focus:ring-blue-500 sm:text-sm transition duration-150 ease-in-out" min="1" placeholder="Quantity" required>
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
                                <!-- Modal footer -->
                                <div class="flex items-center justify-end p-4 border-t border-gray-200">
                                    <button type="button"
                                        class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 mr-2"
                                        onclick="document.getElementById('defaultModal').classList.toggle('hidden')">
                                        Cancel
                                    </button>
                                    <button type="button"
                                        class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5"
                                        onclick="updateSelectedItems()">
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
    function updateSelectedItems() {
        const selectedItemsContainer = document.getElementById('selected-items');
        const rows = document.querySelectorAll('#request-items-table-body tr');
        selectedItemsContainer.innerHTML = '';

        rows.forEach((row, index) => {
            const name = row.querySelector(`input[name="items[${index}][name]"]`).value;
            const quantity = row.querySelector(`input[name="items[${index}][quantity]"]`).value;

            const selectedRow = document.createElement('tr');
            selectedRow.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    ${name}
                    <input type="hidden" name="items[${index}][name]" value="${name}">
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    ${quantity}
                    <input type="hidden" name="items[${index}][quantity]" value="${quantity}">
                </td>
            `;
            selectedItemsContainer.appendChild(selectedRow);
        });

        document.getElementById('selected-items-container').classList.remove('hidden');
        document.getElementById('defaultModal').classList.add('hidden');
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Set default request date to today
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();
        today = yyyy + '-' + mm + '-' + dd;
        document.getElementById('request_date').value = today;

        const addRowButton = document.querySelector('.add-row-button');
        const deleteRowButtons = document.querySelectorAll('.delete-row-button');
        const requestItemsTableBody = document.querySelector('#request-items-table-body');
        let rowCounter = 1;

        function createNewRow() {
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap">
                    <input type="text" name="items[${rowCounter}][name]" class="block w-full px-4 py-2 border-2 border-slate-300 rounded-md shadow-sm focus:border-blue-500 bg-slate-50 focus:ring-1 focus:ring-blue-500 sm:text-sm transition duration-150 ease-in-out" placeholder="Item Name" required>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <input type="number" name="items[${rowCounter}][quantity]" class="block w-full px-4 py-2 border-2 border-slate-300 rounded-md shadow-sm focus:border-blue-500 bg-slate-50 focus:ring-1 focus:ring-blue-500 sm:text-sm transition duration-150 ease-in-out" min="1" placeholder="Quantity" required>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                    <button type="button" class="delete-row-button inline-flex items-center p-2 border border-transparent rounded-full text-red-600 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150 ease-in-out">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </td>
            `;
            requestItemsTableBody.appendChild(newRow);

            const newDeleteRowButton = newRow.querySelector('.delete-row-button');
            newDeleteRowButton.addEventListener('click', function() {
                newRow.remove();
            });

            rowCounter++;
        }

        addRowButton.addEventListener('click', createNewRow);

        deleteRowButtons.forEach(function(deleteRowButton) {
            deleteRowButton.addEventListener('click', function() {
                const row = deleteRowButton.closest('tr');
                row.remove();
            });
        });
    });
</script>
@endsection
