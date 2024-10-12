@extends('layouts.layout')
@section('content')
<link rel="stylesheet" href="{{ asset('css/stockin.css') }}">


<div class="grid grid-cols-6">
    @include('layouts.sidebar')
    <div class="content min-h-screen bg-slate-100 col-span-5">
        <nav class="m-3 mt-6">
            <h1 class="text-center text-4xl">Stock Out</h1>
        </nav>
        <div class="stockout-form bg-white m-3 shadow-md rounded-md p-5">
            <form method="POST" action="{{ route('inventory.stock.out.store') }}">
                @csrf
                <div class="">
                    @if(session('success'))
                        <div class="successMessage bg-lime-800 border border-lime-800 text-white px-4 py-3 rounded relative mt-2 mb-2">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="errorMessage bg-red-900 border border-red-900 text-white px-4 py-3 rounded relative mt-2 mb-2">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <h3 class="text-lg font-semibold mb-3">Item Details</h3>
                    <div class="mb-4">
                        <label for="item_id" class="block text-gray-700 font-bold mb-2">Item:</label>
                        <button type="button" class="ml-auto rounded-md border text-left px-3 py-2 bg-gray-100 text-black w-full"
                            onclick="document.getElementById('defaultModal').classList.toggle('hidden')">
                            Select Items
                        </button>
                        <div class="overflow-y-auto max-h-64 hidden mt-3" id="selected-items-container">
                            <table class="table-auto w-full">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Item</th>
                                        <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Quantity
                                        </th>
                                        <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Price</th>
                                        <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Total</th>
                                    </tr>
                                </thead>
                                <tbody id="selected-items">
                                </tbody>
                                <tfoot>
                                    <tr class="font-bold">
                                        <td class="px-4 py-2 invisible" colspan="">Overall Price:</td>
                                        <td class="px-4 py-2 invisible" colspan="">Overall Price:</td>
                                        <td class="px-4 py-2 text-right" colspan="">Overall Price:</td>
                                        <td class="px-4 py-2" id="overall-price">₱0.00</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                        <!-- <div id="defaultModal" tabindex="-1" aria-hidden="true"
                            class="fixed top-0 left-0 right-0 z-50 p-4 w-full md:inset-0 h-modal md:h-full hidden"> -->
                        <div id="defaultModal" style="min-height:100vh;" tabindex="-1" aria-hidden="true"
                            class="modalBg flex fixed top-0 left-0 right-0 bottom-0 z-50 p-4 w-full md:inset-0 hidden">
                            <div class="relative my-auto mx-auto p-4 w-full max-w-2xl h-full md:h-auto">
                                <!-- Modal content -->
                                <div
                                    class="relative bg-white rounded-lg shadow-lg dark:bg-white border border-slate-400">
                                    <button type="button"
                                        class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                                        onclick="document.getElementById('defaultModal').classList.toggle('hidden')">
                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                    <div class="p-6 text-center">
                                        <h2 class="mb-4 text-lg font-bold text-black">Select Items to Stock Out</h2>
                                        <div class="overflow-y-auto h-96 mb-3">
                                            <table class="table-auto w-full">
                                                <thead>
                                                    <tr>
                                                        <th
                                                            class="px-4 py-2 text-left bg-slate-100 border border-slate-400">
                                                            Item</th>
                                                        <th
                                                            class="px-4 py-2 text-left bg-slate-100 border border-slate-400">
                                                            Quantity</th>
                                                        <th
                                                            class="px-4 py-2 text-center bg-slate-100 border border-slate-400">
                                                            Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($inventories as $inventory)
                                                        <tr>
                                                            <td class="border text-left border-slate-300 px-4 py-2">
                                                                {{ $inventory->brand }}
                                                                {{ $inventory->items_specs }}</td>
                                                            <td class="border border-slate-300 px-4 py-2">
                                                                {{ $inventory->quantity }}</td>
                                                            <td class="border border-slate-300 text-center px-4 py-2">
                                                                <div class="flex my-auto gap-2">
                                                                    <input type="checkbox"
                                                                        id="item_id_{{ $inventory->id }}" name="item_id[]"
                                                                        value="{{ $inventory->id }}"
                                                                        onchange="document.getElementById('quantity_{{ $inventory->id }}').disabled = !this.checked">
                                                                    <input type="number"
                                                                        id="quantity_{{ $inventory->id }}"
                                                                        name="quantity[]"
                                                                    class="w-full p-2 border rounded-md"
                                                                    placeholder="Quantity" min="0" disabled>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <button type="button" class="ml-auto rounded-md shadow-md px-5 py-2 bg-green-600 hover:shadow-md hover:bg-green-500
                                            transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white flex my-auto gap-1"
                                            onclick="document.getElementById('defaultModal').classList.toggle('hidden')">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m4.5 12.75 6 6 9-13.5" />
                                            </svg>
                                            Done
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
            var label = checkbox.closest('tr').cells[0].textContent;
            var id = checkbox.value;
            var price = checkbox.closest('tr').cells[1].textContent;
            var quantity = quantityInput.value;

            if (checkbox.checked) {
                var row = document.createElement('tr');
                var itemCell = document.createElement('td');
                var quantityCell = document.createElement('td');
                var priceCell = document.createElement('td');
                var totalPriceCell = document.createElement('td');

                itemCell.textContent = label;
                itemCell.className = 'border border-slate-300 px-4 py-2';

                quantityCell.textContent = quantity;
                quantityCell.className = 'border border-slate-300 px-4 py-2';

                priceCell.textContent = price;
                priceCell.className = 'border border-slate-300 px-4 py-2';

                totalPriceCell.textContent = parseFloat(price) * parseInt(quantity);
                totalPriceCell.className = 'border border-slate-300 px-4 py-2';

                row.appendChild(itemCell);
                row.appendChild(quantityCell);
                row.appendChild(priceCell);
                row.appendChild(totalPriceCell);

                selectedItemsTable.appendChild(row);
                document.getElementById('selected-items-container').classList.remove('hidden');

                updateOverallPrice();
            } else {
                var rows = selectedItemsTable.rows;
                for (var i = 0; i < rows.length; i++) {
                    if (rows[i].cells[0].textContent == label) {
                        rows[i].remove();
                        break;
                    }
                }
                if (selectedItemsTable.rows.length == 0) {
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
            var label = checkbox.closest('tr').cells[0].textContent;
            var price = checkbox.closest('tr').cells[1].textContent;
            var quantity = quantityInput.value;

            var rows = selectedItemsTable.rows;
            for (var i = 0; i < rows.length; i++) {
                if (rows[i].cells[0].textContent == label) {
                    rows[i].cells[1].textContent = quantity;
                    rows[i].cells[3].textContent = parseFloat(price) * parseInt(quantity);
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
            overallPrice += parseFloat(rows[i].cells[3].textContent);
        }
        overallPriceCell.textContent = '₱' + overallPrice.toFixed(2);
    }
});
</script>
@endsection
