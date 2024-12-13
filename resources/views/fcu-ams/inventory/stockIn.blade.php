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
                    <h1 class="text-2xl font-semibold text-gray-900 mx-auto">Stock In</h1>
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
                                    <option value="add_new_unit">ADD NEW UNIT</option>
                                </select>
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
                                    <option value="add_new">ADD NEW SUPPLIER</option>
                                </select>
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

<!-- Add Unit Modal -->
<div id="add-unit-modal" tabindex="-1" aria-hidden="true" 
    class="modalBg fixed inset-0 z-50 overflow-y-auto bg-gray-900 bg-opacity-50 backdrop-blur-sm hidden">
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="relative w-full max-w-xl transform overflow-hidden rounded-2xl bg-white shadow-2xl transition-all">
            <!-- Header -->
            <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900">Add New Unit</h3>
                    <button type="button" class="text-gray-400 hover:text-gray-500"
                        onclick="document.getElementById('add-unit-modal').classList.toggle('hidden')">
                        <span class="sr-only">Close</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            <!-- Content -->
            <div class="p-6">
                <input type="text" id="new_unit" name="new_unit"
                    class="shadow-sm border-2 border-slate-300 p-2 bg-slate-50 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md">
            </div>
            <!-- Footer -->
            <div class="bg-gray-50 px-6 py-4">
                <div class="flex items-center justify-end space-x-3">
                    <button type="button" id="add-unit-btn"
                        class="inline-flex justify-center rounded-md border border-transparent bg-green-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                        Add Unit
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Supplier Modal -->
<div id="add-supplier-modal" tabindex="-1" aria-hidden="true"
    class="modalBg fixed inset-0 z-50 overflow-y-auto bg-gray-900 bg-opacity-50 backdrop-blur-sm hidden">
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="relative w-full max-w-xl transform overflow-hidden rounded-2xl bg-white shadow-2xl transition-all">
            <!-- Header -->
            <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900">Add New Supplier</h3>
                    <button type="button" class="text-gray-400 hover:text-gray-500"
                        onclick="document.getElementById('add-supplier-modal').classList.toggle('hidden')">
                        <span class="sr-only">Close</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            <!-- Content -->
            <div class="p-6">
                <input type="text" id="new_supplier" name="new_supplier"
                    class="shadow-sm border-2 border-slate-300 p-2 bg-slate-50 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md">
            </div>
            <!-- Footer -->
            <div class="bg-gray-50 px-6 py-4">
                <div class="flex items-center justify-end space-x-3">
                    <button type="button" id="add-supplier-btn"
                        class="inline-flex justify-center rounded-md border border-transparent bg-green-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                        Add Supplier
                    </button>
                </div>
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
        const supplierSelect = document.getElementById('supplier_id');
        const addSupplierModal = document.getElementById('add-supplier-modal');
        const addSupplierBtn = document.getElementById('add-supplier-btn');

        supplierSelect.addEventListener('change', function () {
            if (supplierSelect.value === 'add_new') {
                addSupplierModal.classList.remove('hidden');
            }
        });

        addSupplierBtn.addEventListener('click', function () {
            const newSupplier = document.getElementById('new_supplier').value;
            if (newSupplier.trim() !== '') {
                const formData = new FormData();
                formData.append('supplier', newSupplier);
                fetch('{{ route('supplier.add') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.reload) {
                        window.location.reload();
                    }
                })
                .catch(error => console.error(error));
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const unitSelect = document.getElementById('unit_id');
        const addUnitModal = document.getElementById('add-unit-modal');
        const addUnitBtn = document.getElementById('add-unit-btn');

        unitSelect.addEventListener('change', function () {
            if (unitSelect.value === 'add_new_unit') {
                addUnitModal.classList.remove('hidden');
            }
        });

        addUnitBtn.addEventListener('click', function () {
            const newUnit = document.getElementById('new_unit').value;
            if (newUnit.trim() !== '') {
                const formData = new FormData();
                formData.append('unit', newUnit);
                fetch('{{ route('unit.add') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.reload) {
                        window.location.reload();
                    }
                })
                .catch(error => console.error(error));
            }
        });
    });
</script>

@endsection