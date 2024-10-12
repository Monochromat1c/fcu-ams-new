@extends('layouts.layout')
@section('content')
<link rel="stylesheet" href="{{ asset('css/stockin.css') }}">
<style>
    /* .modal-container{
        min-width: 100dvw;
        min-height: 100dvh;
    } */
</style>
<div class="grid grid-cols-6">
    @include('layouts.sidebar')
    <div class="content min-h-screen bg-slate-100 col-span-5">
        <nav class="m-3 mt-6">
            <h1 class="text-center text-4xl">Purchase Order</h1>
        </nav>
        <div class="stockin-form bg-slate-100 rounded-md p-5">
            <form method="POST" enctype="multipart/form-data"
                action="{{ route('purchase.order.store') }}">
                @csrf
                <div class="">
                    @if(session('success'))
                        <div
                            class="successMessage bg-green-600 border border-green-600 text-white px-4 py-3 rounded relative mt-2 mb-2">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if($errors->any())
                        <div
                            class="errorMessage bg-red-900 border border-red-900 text-white px-4 py-3 rounded relative mt-2 mb-2">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="bg-white rounded-md shadow-md p-5 mb-5">
                        <h3 class="text-lg font-semibold mb-3">Purchase Order Details</h3>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="mb-4">
                                <label for="po_date" class="block text-gray-700 font-bold mb-2">PO Date:</label>
                                <input type="date" id="po_date" name="po_date"
                                    class="w-full p-2 border rounded-md bg-gray-100" required>
                            </div>
                            <div class="mb-4">
                                <label for="po_number" class="block text-gray-700 font-bold mb-2">PO Number:</label>
                                <input type="number" id="po_number" name="po_number"
                                    class="w-full p-2 border rounded-md bg-gray-100" min="0" required>
                            </div>
                            <div class="mb-4">
                                <label for="mr_number" class="block text-gray-700 font-bold mb-2">MR Number:</label>
                                <input type="number" id="mr_number" name="mr_number"
                                    class="w-full p-2 border rounded-md bg-gray-100" min="0" required>
                            </div>
                            <div class="mb-4">
                                <label for="department_id" class="block text-gray-700 font-bold mb-2">Requesting
                                    Department:</label>
                                <select id="department_id" name="department_id"
                                    class="w-full p-2 border rounded-md bg-gray-100" required>
                                    <option value="">Select a department</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}"
                                            {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                            {{ $department->department }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="supplier_id" class="block text-gray-700 font-bold mb-2">Supplier:</label>
                                <select id="supplier_id" name="supplier_id"
                                    class="w-full p-2 border rounded-md bg-gray-100" required>
                                    <option value="">Select a supplier</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}"
                                            {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                            {{ $supplier->supplier }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="location_id" class="block text-gray-700 font-bold mb-2">Location:</label>
                                <select id="location_id" name="location_id"
                                    class="w-full p-2 border rounded-md bg-gray-100" required>
                                    <option value="">Select a location</option>
                                    @foreach($locations as $location)
                                        <option value="{{ $location->id }}"
                                            {{ old('location_id') == $location->id ? 'selected' : '' }}>
                                            {{ $location->location }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="approved_by" class="block text-gray-700 font-bold mb-2">Approved By:</label>
                                <input type="text" id="approved_by" name="approved_by"
                                            class="w-full p-2 border rounded-md bg-gray-100" required>
                            </div>
                            <div class="mb-4">
                                <label for="note" class="block text-gray-700 font-bold mb-2">Note:</label>
                                <textarea id="note" name="note"
                                    class="w-full p-2 border rounded-md bg-gray-100"></textarea>
                            </div>
                        </div>
                    </div>
                    <div
                        class="purchaseOrderItems outline-white o outline-8 bg-white rounded-md shadow-md p-5 mb-5 max-h-96 overflow-y-auto">
                        <table class="w-full table-auto" id="purchase-order-table">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 w-full flex">
                                        Items/Specs
                                    </th>
                                    <th class="px-4 py-2 w-auto whitespace-nowrap">Quantity</th>
                                    <th class="px-4 py-2 w-auto whitespace-nowrap">Unit</th>
                                    <th class="px-4 py-2 w-auto whitespace-nowrap">Unit Price</th>
                                    <th class="px-4 py-2 w-auto whitespace-nowrap">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="purchase-order-table-body">
                                <tr>
                                    <td class="px-4 py-2 lg:w-2/5">
                                        <input type="text" id="items_specs" name="items_specs[]"
                                            class="w-full p-2 border rounded-md bg-gray-100" required>
                                    </td>
                                    <td class="px-4 py-2 w-auto">
                                        <input type="number" id="quantity" name="quantity[]"
                                            class="w-full p-2 border rounded-md bg-gray-100" min="0" required>
                                    </td>
                                    <td class="px-4 py-2 w-auto">
                                        <select id="unit_id" name="unit_id[]"
                                            class="w-full whitespace-nowrap p-2 border rounded-md bg-gray-100" required>
                                            <option value="">Select a unit</option>
                                            @foreach($units as $unit)
                                                <option value="{{ $unit->id }}"
                                                    {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                                                    {{ $unit->unit }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="px-4 py-2 w-auto">
                                        <input type="number" id="unit_price" name="unit_price[]"
                                            class="w-full p-2 border rounded-md bg-gray-100" min="0" required>
                                    </td>
                                    <td class="px-4 py-2 w-auto flex gap-2">
                                        <button class="delete-row-buttonfd flex gap-2 mx-auto my-auto rounded-md shadow-md bg-red-600 hover:shadow-md hover:bg-red-500
                        transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white px-5 py-2"
                                            type="button">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    </td>

                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="font-bold">
                                    <td class="px-4 py-2 invisible" colspan="">Overall Price:</td>
                                    <td class="px-4 py-2 invisible" colspan="">Overall Price:</td>
                                    <td class="px-4 py-2 text-right">Overall Price:</td>
                                    <td class="px-4 py-2" id="overall-price">₱0.00</td>
                                </tr>
                            </tfoot>
                        </table>
                        <button class="add-row-button flex gap-2 ml-4 my-2 rounded-md shadow-md bg-green-600 hover:shadow-md hover:bg-green-500
                        transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white px-5 py-2"
                            type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Add New Row
                        </button>
                    </div>
                </div>
                <div class="space-x-2 flex">
                    <button type="submit"
                        class="ml-auto rounded-md shadow-md px-5 py-2 bg-green-600 hover:shadow-md hover:bg-green-500
                        transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white flex my-auto gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.5 3.75V16.5L12 14.25 7.5 16.5V3.75m9 0H18A2.25 2.25 0 0 1 20.25 6v12A2.25 2.25 0 0 1 18 20.25H6A2.25 2.25 0 0 1 3.75 18V6A2.25 2.25 0 0 1 6 3.75h1.5m9 0h-9" />
                        </svg>
                        Create Purchase Order
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

        addRowButton.addEventListener('click', function () {
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
            <td class="px-4 py-2 w w-2/4">
                <input type="text" name="items_specs[]" class="w-full p-2 border rounded-md bg-gray-100" required>
            </td>
            <td class="px-4 py-2 w-auto">
                <input type="number" name="quantity[]" class="w-full p-2 border rounded-md bg-gray-100" min="0" required>
            </td>
            <td class="px-4 py-2 w-auto">
                <select name="unit_id[]" class="w-full p-2 border rounded-md bg-gray-100" required>
                    <option value="">Select a unit</option>
@foreach($units as $unit)
                        <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                            {{ $unit->unit }}
                        </option>
@endforeach
                </select>
            </td>
            <td class="px-4 py-2 w-auto">
                <input type="number" name="unit_price[]" class="w-full p-2 border rounded-md bg-gray-100" min="0" required>
            </td>
            <td class="px-4 py-2 w-auto flex gap-2">
                <button class="delete-row-buttonfd flex gap-2 my-auto rounded-md shadow-md bg-red-600 hover:shadow-md hover:bg-red-500
                transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white px-5 py-2"
                    type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                    </svg>
                </button>
            </td>
        `;
            purchaseOrderTableBody.appendChild(newRow);

            const newDeleteRowButton = newRow.querySelector('.delete-row-buttonfd');
            newDeleteRowButton.addEventListener('click', function () {
                newRow.remove();
            });
        });

        deleteRowButtons.forEach(function (deleteRowButton) {
            deleteRowButton.addEventListener('click', function () {
                const row = deleteRowButton.parentNode.parentNode;
                row.remove();
            });
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var overallPriceCell = document.getElementById('overall-price');
        var purchaseOrderTableBody = document.getElementById('purchase-order-table-body');

        purchaseOrderTableBody.addEventListener('input', function (event) {
            if (event.target.type === 'number') {
                var rows = purchaseOrderTableBody.rows;
                var overallPrice = 0;
                for (var i = 0; i < rows.length; i++) {
                    var quantity = rows[i].cells[1].children[0].value;
                    var unitPrice = rows[i].cells[3].children[0].value;
                    overallPrice += parseFloat(quantity) * parseFloat(unitPrice);
                }
                overallPriceCell.textContent = '₱' + overallPrice.toFixed(2);
            }
        });
    });
</script>
@endsection
