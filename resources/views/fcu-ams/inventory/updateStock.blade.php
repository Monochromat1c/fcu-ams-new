@extends('layouts.layout')
@section('content')
<link rel="stylesheet" href="{{ asset('css/stockin.css') }}">

<div class="grid grid-cols-6">
    @include('layouts.sidebar')
    <div class="content min-h-screen bg-slate-100 col-span-5">
        <nav class="m-3 mt-6">
            <h1 class="text-center text-4xl">Edit the Item</h1>
        </nav>
        <div class="stockin-form bg-white m-3 shadow-md rounded-md p-5">
            <form method="POST" enctype="multipart/form-data"
                action="{{ route('inventory.stock.in.update', ['id' => $inventory->id]) }}">
                @csrf
                <input type="hidden" name="id" value="{{ $inventory->id }}">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-black px-4 py-3 rounded relative mt-2 mb-2">
                        {{ session('success') }}
                    </div>
                @endif
                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-black px-4 py-3 rounded relative mt-2 mb-2">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <h3 class="text-lg font-semibold mb-3">Item Details</h3>
                <div class="mb-4">
                    <label for="stock_image" class="block text-gray-700 font-bold mb-2">Item Image:</label>
                    <input type="file" id="stock_image" name="stock_image" class="w-full border rounded-md">
                </div>
                <div class="mb-4">
                    <label for="items_specs" class="block text-gray-700 font-bold mb-2">Item/Specs:</label>
                    <input type="text" id="items_specs" name="items_specs" class="w-full p-2 border rounded-md"
                        value="{{ $inventory->items_specs }}" required>
                </div>
                <div class="mb-4">
                    <label for="unit" class="block text-gray-700 font-bold mb-2">Unit:</label>
                    <input type="text" id="unit" name="unit" class="w-full p-2 border rounded-md"
                        value="{{ $inventory->unit }}" required>
                </div>
                <div class="mb-4">
                    <label for="stocks" class="block text-gray-700 font-bold mb-2">Stocks:</label>
                    <input type="number" id="stocks" name="stocks" class="w-full p-2 border rounded-md"
                        value="{{ $inventory->stocks }}" required>
                </div>
                <div class="mb-4">
                    <label for="unit_price" class="block text-gray-700 font-bold mb-2">Unit Price:</label>
                    <input type="number" id="unit_price" name="unit_price" class="w-full p-2 border rounded-md"
                        value="{{ $inventory->unit_price }}" required>
                </div>
                <div class="mb-2">
                    <label for="supplier_id" class="block text-gray-700 font-bold mb-2">Supplier:</label>
                    <select id="supplier_id" name="supplier_id" class="w-full p-2 border rounded-md" required>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}"
                                {{ $supplier->id == $inventory->supplier_id ? 'selected' : '' }}>
                                {{ $supplier->supplier }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" class="ml-auto rounded-md shadow-md px-5 py-2 bg-red-600 hover:shadow-md hover:bg-red-500
                        transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white"
                        onclick="history.back()">Back</button>
                    <button type="submit" class="rounded-md shadow-md px-5 py-2 bg-green-600 hover:shadow-md hover:bg-green-500
                        transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white">Update
                        Item
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('js/chart.js') }}"></script>
<script>
    function confirmLogout() {
        if (confirm('Are you sure you want to logout?')) {
            document.getElementById('logout-form').submit();
        }
    }

</script>
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
