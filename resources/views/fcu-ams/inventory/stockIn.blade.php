@extends('layouts.layout')
@section('content')
<link rel="stylesheet" href="{{ asset('css/stockin.css') }}">
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

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
            <h1 class="my-auto text-3xl">Stock In</h1>
            <div class="w-10"></div>
        </nav>

        <!-- Main content -->
        <div class="m-3 2xl:max-w-7xl 2xl:mx-auto mb-6">
            <div class="mb-3">
                @include('layouts.messageWithoutTimerForError')
            </div>

            <!-- Form -->
            <div class="bg-white shadow rounded-lg">
                <form method="POST" enctype="multipart/form-data" action="{{ route('inventory.stock.in.store') }}" class="space-y-6 p-6">
                    @csrf

                    <!-- Item Image -->
                    <div class="space-y-1">
                        <label for="stock_image" class="block text-sm font-medium text-gray-700">Item Image</label>
                        <div class="mt-1 flex items-center">
                            <div class="flex-shrink-0 h-32 w-32 border rounded-lg overflow-hidden bg-gray-100">
                                <img id="image_preview" class="h-full w-full object-cover hidden">
                                <div id="image_placeholder" class="h-32 w-32 flex items-center justify-center text-gray-400">
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
                            <div class="mt-1 flex space-x-2">
                                <select id="brand_id" name="brand_id" required
                                    class="block w-full pl-3 pr-10 py-2 text-base border-2 border-slate-300 bg-slate-50 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    <option value="">Select a brand</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->brand }}</option>
                                    @endforeach
                                </select>
                                <button type="button"
                                    onclick="document.getElementById('add-brand-modal').classList.remove('hidden')"
                                    class="inline-flex items-center p-2 border border-transparent rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Item/Specs -->
                        <div>
                            <label for="items_specs" class="block text-sm font-medium text-gray-700">Item/Specs</label>
                            <div class="mt-1">
                                <input type="text" id="items_specs" name="items_specs" required
                                    class="shadow-sm border-2 border-slate-300 p-2 bg-slate-50 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md"
                                    value="{{ old('items_specs') ?? '' }}">
                            </div>
                        </div>

                        <!-- Unit -->
                        <div>
                            <label for="unit_id" class="block text-sm font-medium text-gray-700">Unit</label>
                            <div class="mt-1 flex space-x-2">
                                <select id="unit_id" name="unit_id" required
                                    class="block w-full pl-3 pr-10 py-2 text-base border-2 border-slate-300 bg-slate-50 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    <option value="">Select a unit</option>
                                    @foreach($units as $unit)
                                        <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                                            {{ $unit->unit }}</option>
                                    @endforeach
                                </select>
                                <button type="button"
                                    onclick="document.getElementById('add-unit-modal').classList.remove('hidden')"
                                    class="inline-flex items-center p-2 border border-transparent rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Quantity -->
                        <div>
                            <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                            <div class="mt-1">
                                <input type="number" id="quantity" name="quantity" required min="0"
                                    class="shadow-sm border-2 border-slate-300 p-2 bg-slate-50 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md"
                                    value="{{ old('quantity') ?? '' }}">
                            </div>
                        </div>

                        <!-- Unit Price -->
                        <div>
                            <label for="unit_price" class="block text-sm font-medium text-gray-700">Unit Price</label>
                            <div class="mt-1">
                                <input type="number" id="unit_price" name="unit_price" required min="0"
                                    class="shadow-sm border-2 border-slate-300 p-2 bg-slate-50 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md"
                                    value="{{ old('unit_price') ?? '' }}">
                            </div>
                        </div>

                        <!-- Supplier -->
                        <div>
                            <label for="supplier_id" class="block text-sm font-medium text-gray-700">Supplier</label>
                            <div class="mt-1 flex space-x-2">
                                <select id="supplier_id" name="supplier_id" required
                                    class="block w-full pl-3 pr-10 py-2 text-base border-2 border-slate-300 bg-slate-50 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    <option value="">Select a supplier</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                            {{ $supplier->supplier }}</option>
                                    @endforeach
                                </select>
                                <button type="button"
                                    onclick="document.getElementById('add-supplier-modal').classList.remove('hidden')"
                                    class="inline-flex items-center p-2 border border-transparent rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end space-x-3 pt-6 border-t">
                        <button type="submit"
                            class="inline-flex justify-center items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Add Item
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modals -->
<div class="modal" id="brand-modal-wrapper">
    <x-add-item-modal 
        title="Add New Brand"
        id="add-brand-modal"
        route="{{ route('brand.add') }}"
        field="brand"
    />
</div>

<div class="modal" id="unit-modal-wrapper">
    <x-add-item-modal 
        title="Add New Unit"
        id="add-unit-modal"
        route="{{ route('unit.add') }}"
        field="unit"
    />
</div>

<div class="modal" id="supplier-modal-wrapper">
    <x-add-item-modal 
        title="Add New Supplier"
        id="add-supplier-modal"
        route="{{ route('supplier.add') }}"
        field="supplier"
    />
</div>

@push('scripts')
<script>
    // Add CSRF token to the page
    document.head.innerHTML += `<meta name="csrf-token" content="{{ csrf_token() }}">`;
    
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

    // Function to refresh select options after adding new item
    function refreshSelectOptions(selectId, route) {
        fetch(route)
            .then(response => response.json())
            .then(data => {
                const select = document.getElementById(selectId);
                const currentValue = select.value;
                select.innerHTML = '<option value="">Select an option</option>';
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.id;
                    option.textContent = item[selectId.replace('_id', '')];
                    if (item.id == currentValue) {
                        option.selected = true;
                    }
                    select.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error refreshing options:', error);
            });
    }

    // Add event listeners for modal forms
    document.addEventListener('DOMContentLoaded', function() {
        // Get all forms inside modals
        const forms = document.querySelectorAll('.modal form');
        console.log('Found forms:', forms.length);

        forms.forEach(form => {
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                console.log('Form submitted');

                const formData = new FormData(this);
                const modalId = this.closest('.modal').querySelector('[id]').id;
                const selectId = modalId.replace('add-', '').replace('-modal', '_id');
                
                console.log('Modal ID:', modalId);
                console.log('Select ID:', selectId);

                try {
                    const response = await fetch(this.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: formData
                    });

                    const data = await response.json();
                    console.log('Response:', data);

                    if (data.success) {
                        // Refresh the corresponding select options
                        await refreshSelectOptions(selectId, `/${selectId.replace('_id', '')}/list`);
                        
                        // Clear the form and hide the modal
                        this.reset();
                        document.getElementById(modalId).classList.add('hidden');
                    }
                } catch (error) {
                    console.error('Error submitting form:', error);
                }
            });
        });
    });
</script>
@endpush

@endsection