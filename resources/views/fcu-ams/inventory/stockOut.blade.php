@extends('layouts.layout')
@section('content')
<link rel="stylesheet" href="{{ asset('css/stockin.css') }}">


<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

<div class="grid grid-cols-6">
    @include('layouts.sidebar')
    <div class="content min-h-screen bg-slate-200 col-span-5">
        <nav class="m-3 mt-6">
            <h1 class="text-center text-4xl">Stock Out</h1>
        </nav>
        <div class="stockout-form bg-white m-3 shadow-md rounded-md p-5">
            <form method="POST" action="{{ route('inventory.stock.out.store') }}">
                @csrf
                <div class="">
                    <div class="mb-3">
                        @include('layouts.messageWithoutTimerForError')
                    </div>
                    <h3 class="text-lg font-semibold mb-3">Item Details</h3>
                    <div class="mb-4">
                        <label for="item_id" class="block text-gray-700 font-bold mb-2">Item:</label>
                        <button type="button" class="ml-auto rounded-md border text-left px-3 py-2 bg-gray-100 text-black w-full"
                            onclick="document.getElementById('defaultModal').classList.toggle('hidden')">
                            Select Items
                        </button>
                        <div class="overflow-y-auto max-h-64 hidden mt-3" id="selected-items-container">
                            <div class="max-w-4xl mx-auto overflow-x-auto overflow-y-auto rounded-lg">
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
                        <div id="defaultModal" style="min-height:100vh; background-color: rgba(0, 0, 0, 0.5);" tabindex="-1" aria-hidden="true"
                            class="modalBg flex fixed top-0 left-0 right-0 bottom-0 z-50 p-4 w-full md:inset-0 hidden">
                            <div class="relative my-auto mx-auto p-4 w-full max-w-4xl h-full md:h-auto">
                                <!-- Modal content -->
                                <div class="relative bg-white rounded-lg shadow-xl dark:bg-white border-0">
                                    <!-- Modal header -->
                                    <div class="flex items-center justify-between p-4 border-b rounded-t">
                                        <h3 class="text-xl font-semibold text-gray-900">
                                            Select Items to Stock Out
                                        </h3>
                                        <div class="flex items-center space-x-4">
                                            <div class="relative">
                                                <input type="text" id="modal-search" placeholder="Search items..." 
                                                    class="pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 w-64">
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
                                        <div class="max-w-5xl mx-auto overflow-x-auto overflow-y-auto rounded-lg shadow">
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
                                                                    <div class="flex items-center gap-3 justify-center">
                                                                        <input type="checkbox"
                                                                            id="item_id_{{ $inventory->id }}" 
                                                                            name="item_id[]"
                                                                            value="{{ $inventory->id }}"
                                                                            class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500"
                                                                            onchange="document.getElementById('quantity_{{ $inventory->id }}').disabled = !this.checked">
                                                                        <input type="number"
                                                                            id="quantity_{{ $inventory->id }}"
                                                                            name="quantity[]"
                                                                            class="w-24 p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 disabled:bg-gray-100 disabled:text-gray-500"
                                                                            placeholder="Qty"
                                                                            min="1"
                                                                            max="{{ $inventory->quantity }}"
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
                    <div class="mb-4">
                        <label for="department_id" class="block text-gray-700 font-bold mb-2">Department:</label>
                        <select id="department_id" name="department_id" class="w-full p-2 border rounded-md bg-gray-100" required>
                            <option value="">Select a department</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->department }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="stock_out_date" class="block text-gray-700 font-bold mb-2">Stock Out Date:</label>
                        <input type="date" id="stock_out_date" name="stock_out_date"
                            class="w-full p-2 border rounded-md bg-gray-100" required>
                    </div>
                    <div class="mb-4">
                        <label for="receiver" class="block text-gray-700 font-bold mb-2">Received by:</label>
                        <input type="input" id="receiver" name="receiver" class="w-full p-2 border rounded-md bg-gray-100"
                            required>
                    </div>
                </div>
                <div class="space-x-2 flex">
                    <!-- <button type="button" class="ml-auto rounded-md shadow-md px-5 py-2 bg-red-600 hover:shadow-md hover:bg-red-500
                        transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white"
                        onclick="history.back()">Back</button> -->
                    <button type="submit" class="ml-auto rounded-md shadow-md px-5 py-2 bg-green-600 hover:shadow-md hover:bg-green-500
                        transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white flex my-auto gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                        </svg>
                        Stock Out
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var successMessage = document.querySelector('.successMessage');

        if (successMessage) {
            setTimeout(function () {
                successMessage.style.display = 'none';
            }, 2000);
        }
    });
</script>
<script src="{{ asset('js/chart.js') }}"></script>
 
<script>
    document.addEventListener('DOMContentLoaded', function () {
    var selectedItemsTable = document.getElementById('selected-items');
    var modal = document.getElementById('defaultModal');
    var overallPriceCell = document.getElementById('overall-price');

    modal.addEventListener('change', function (event) {
        if (event.target.type === 'checkbox') {
            var checkbox = event.target;
            var quantityInput = checkbox.nextElementSibling;
            var row = checkbox.closest('tr');
            var label = row.cells[0].textContent.trim();
            var id = checkbox.value;
            var quantity = quantityInput.value || '1';
            var price = row.cells[3].textContent.trim().replace('₱', '').replace(',', '');

            if (checkbox.checked) {
                var newRow = document.createElement('tr');
                var itemCell = document.createElement('td');
                var quantityCell = document.createElement('td');
                var priceCell = document.createElement('td');
                var totalPriceCell = document.createElement('td');

                itemCell.textContent = label;
                itemCell.className = 'px-6 py-4';

                quantityCell.textContent = quantity;
                quantityCell.className = 'px-6 py-4';

                priceCell.textContent = '₱' + parseFloat(price).toFixed(2);
                priceCell.className = 'px-6 py-4';

                var total = parseFloat(price) * parseInt(quantity);
                totalPriceCell.textContent = '₱' + total.toFixed(2);
                totalPriceCell.className = 'px-6 py-4';

                newRow.appendChild(itemCell);
                newRow.appendChild(quantityCell);
                newRow.appendChild(priceCell);
                newRow.appendChild(totalPriceCell);

                selectedItemsTable.appendChild(newRow);
                document.getElementById('selected-items-container').classList.remove('hidden');

                updateOverallPrice();
            } else {
                var rows = selectedItemsTable.rows;
                for (var i = 0; i < rows.length; i++) {
                    if (rows[i].cells[0].textContent.trim() === label) {
                        rows[i].remove();
                        break;
                    }
                }
                if (selectedItemsTable.rows.length === 0) {
                    document.getElementById('selected-items-container').classList.add('hidden');
                }

                updateOverallPrice();
            }
        }
    });

    modal.addEventListener('input', function (event) {
        if (event.target.type === 'number') {
            var quantityInput = event.target;
            var checkbox = quantityInput.previousElementSibling;
            var row = checkbox.closest('tr');
            var label = row.cells[0].textContent.trim();
            var price = row.cells[3].textContent.trim().replace('₱', '').replace(',', '');
            var quantity = quantityInput.value || '0';

            var rows = selectedItemsTable.rows;
            for (var i = 0; i < rows.length; i++) {
                if (rows[i].cells[0].textContent.trim() === label) {
                    rows[i].cells[1].textContent = quantity;
                    var total = parseFloat(price) * parseInt(quantity);
                    rows[i].cells[3].textContent = '₱' + total.toFixed(2);
                    break;
                }
            }

            updateOverallPrice();
        }
    });

    function updateOverallPrice() {
        var rows = selectedItemsTable.rows;
        var overallPrice = 0;
        for (var i = 0; i < rows.length; i++) {
            var totalPrice = rows[i].cells[3].textContent.trim().replace('₱', '').replace(',', '');
            overallPrice += parseFloat(totalPrice);
        }
        overallPriceCell.textContent = '₱' + overallPrice.toFixed(2);
    }
});

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
</script>
@endsection
