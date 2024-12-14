@extends('layouts.layout')
@section('content')
<link rel="stylesheet" href="{{ asset('css/stockin.css') }}">
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

<div class="grid grid-cols-6">
    @include('layouts.sidebar')
    <div class="content min-h-screen bg-slate-200 col-span-5">
        <!-- Header -->
        <div class="bg-white m-3 shadow-md rounded-md 2xl:max-w-7xl 2xl:mx-auto">
            <div class="px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex items-center justify-between">
                    <a href="{{ route('inventory.list') }}" class="flex items-center text-gray-700 hover:text-gray-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <h1 class="text-2xl font-semibold text-gray-900 mx-auto">Edit Item</h1>
                    <div class="w-6 h-6"></div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="m-3 2xl:max-w-7xl 2xl:mx-auto mb-6">
            <div class="mb-3">
                @include('layouts.messageWithoutTimerForError')
            </div>

            <!-- Form -->
            <div class="bg-white shadow rounded-lg">
                <form method="POST" enctype="multipart/form-data" action="{{ route('inventory.stock.in.update', ['id' => $inventory->id]) }}" class="space-y-6 p-6">
                    @csrf
                    <input type="hidden" name="id" value="{{ $inventory->id }}">

                    <!-- Item Image -->
                    <div class="space-y-1">
                        <label for="stock_image" class="block text-sm font-medium text-gray-700">Item Image</label>
                        <div class="mt-1 flex items-center">
                            <div class="flex-shrink-0 h-32 w-32 border rounded-lg overflow-hidden bg-gray-100">
                                <img id="image_preview" src="{{ asset($inventory->stock_image) }}" class="h-full w-full object-cover {{ $inventory->stock_image ? '' : 'hidden' }}">
                                <div id="image_placeholder" class="h-32 w-32 flex items-center justify-center text-gray-400 {{ $inventory->stock_image ? 'hidden' : '' }}">
                                    <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-2">
                                <div class="relative">
                                    <input type="file" id="stock_image" name="stock_image" class="hidden" accept="image/*">
                                    <label for="stock_image"
                                        class="cursor-pointer bg-white py-2 px-3 border-2 border-slate-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Choose Image
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                        <!-- Brand -->
                        <div>
                            <label for="brand_id" class="block text-sm font-medium text-gray-700">Brand</label>
                            <div class="mt-1">
                                <select id="brand_id" name="brand_id" required
                                    class="block w-full pl-3 pr-10 py-2 text-base border-2 border-slate-300 bg-slate-50 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ $brand->id == $inventory->brand_id ? 'selected' : '' }}>
                                            {{ $brand->brand }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Item/Specs -->
                        <div>
                            <label for="items_specs" class="block text-sm font-medium text-gray-700">Item/Specs</label>
                            <div class="mt-1">
                                <input type="text" id="items_specs" name="items_specs" required
                                    class="shadow-sm border-2 border-slate-300 p-2 bg-slate-50 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md"
                                    value="{{ $inventory->items_specs }}">
                            </div>
                        </div>

                        <!-- Unit -->
                        <div>
                            <label for="unit_id" class="block text-sm font-medium text-gray-700">Unit</label>
                            <div class="mt-1">
                                <select id="unit_id" name="unit_id" required
                                    class="block w-full pl-3 pr-10 py-2 text-base border-2 border-slate-300 bg-slate-50 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    @foreach($units as $unit)
                                        <option value="{{ $unit->id }}" {{ $unit->id == $inventory->unit_id ? 'selected' : '' }}>
                                            {{ $unit->unit }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Quantity -->
                        <div>
                            <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                            <div class="mt-1">
                                <input type="number" id="quantity" name="quantity" required min="0"
                                    class="shadow-sm border-2 border-slate-300 p-2 bg-slate-50 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md"
                                    value="{{ $inventory->quantity }}">
                            </div>
                        </div>

                        <!-- Unit Price -->
                        <div>
                            <label for="unit_price" class="block text-sm font-medium text-gray-700">Unit Price</label>
                            <div class="mt-1">
                                <input type="number" id="unit_price" name="unit_price" required min="0"
                                    class="shadow-sm border-2 border-slate-300 p-2 bg-slate-50 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md"
                                    value="{{ $inventory->unit_price }}">
                            </div>
                        </div>

                        <!-- Supplier -->
                        <div>
                            <label for="supplier_id" class="block text-sm font-medium text-gray-700">Supplier</label>
                            <div class="mt-1">
                                <select id="supplier_id" name="supplier_id" required
                                    class="block w-full pl-3 pr-10 py-2 text-base border-2 border-slate-300 bg-slate-50 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" {{ $supplier->id == $inventory->supplier_id ? 'selected' : '' }}>
                                            {{ $supplier->supplier }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end space-x-3 pt-6 border-t">
                        <a href="{{ route('inventory.list') }}"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Cancel
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Update Item
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Image preview functionality
    document.getElementById('stock_image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            const preview = document.getElementById('image_preview');
            const placeholder = document.getElementById('image_placeholder');
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            };
            
            reader.readAsDataURL(file);
        }
    });

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