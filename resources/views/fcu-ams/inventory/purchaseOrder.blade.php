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
        <div class="stockin-form bg-white m-3 shadow-md rounded-md p-5">
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
                    <h3 class="text-lg font-semibold mb-3">Purchase Order Details</h3>
                    <div class="mb-4">
                        <label for="department_id" class="block text-gray-700 font-bold mb-2">Department:</label>
                        <select id="department_id" name="department_id" class="w-full p-2 border rounded-md bg-gray-100"
                            required>
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
                        <select id="supplier_id" name="supplier_id" class="w-full p-2 border rounded-md bg-gray-100"
                            required>
                            <option value="">Select a supplier</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}"
                                    {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->supplier }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="unit_id" class="block text-gray-700 font-bold mb-2">Unit:</label>
                        <select id="unit_id" name="unit_id" class="w-full p-2 border rounded-md bg-gray-100" required>
                            <option value="">Select a unit</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit->id }}"
                                    {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                                    {{ $unit->unit }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="location_id" class="block text-gray-700 font-bold mb-2">Location:</label>
                        <select id="location_id" name="location_id" class="w-full p-2 border rounded-md bg-gray-100"
                            required>
                            <option value="">Select a location</option>
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}"
                                    {{ old('location_id') == $location->id ? 'selected' : '' }}>
                                    {{ $location->location }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="po_date" class="block text-gray-700 font-bold mb-2">PO Date:</label>
                        <input type="date" id="po_date" name="po_date" class="w-full p-2 border rounded-md bg-gray-100"
                            required>
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
                        <label for="quantity" class="block text-gray-700 font-bold mb-2">Quantity:</label>
                        <input type="number" id="quantity" name="quantity"
                            class="w-full p-2 border rounded-md bg-gray-100" min="0" required>
                    </div>
                    <div class="mb-4">
                        <label for="items_specs" class="block text-gray-700 font-bold mb-2">Items/Specs:</label>
                        <input type="text" id="items_specs" name="items_specs"
                            class="w-full p-2 border rounded-md bg-gray-100" required>
                    </div>
                    <div class="mb-4">
                        <label for="unit_price" class="block text-gray-700 font-bold mb-2">Unit Price:</label>
                        <input type="number" id="unit_price" name="unit_price"
                            class="w-full p-2 border rounded-md bg-gray-100" min="0" required>
                    </div>
                    <div class="mb-4">
                        <label for="note" class="block text-gray-700 font-bold mb-2">Note:</label>
                        <textarea id="note" name="note" class="w-full p-2 border rounded-md bg-gray-100"></textarea>
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
        // Get the current URL
        var currentUrl = window.location.href;

        // Get all dropdown buttons
        var dropdownButtons = document.querySelectorAll('.relative button');

        // Loop through each dropdown button
        dropdownButtons.forEach(function (button) {
            // Get the dropdown links
            var dropdownLinks = button.nextElementSibling.querySelectorAll('a');

            // Loop through each dropdown link
            dropdownLinks.forEach(function (link) {
                // Check if the current URL matches the link's href
                if (currentUrl === link.href) {
                    // Open the dropdown
                    button.click();
                }
            });
        });
    });
</script>
@endsection
