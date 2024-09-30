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
            <h1 class="text-center text-4xl">Add New Item in the Inventory</h1>
        </nav>
        <div class="stockin-form bg-white m-3 shadow-md rounded-md p-5">
            <form method="POST" enctype="multipart/form-data"
                action="{{ route('inventory.stock.in.store') }}">
                @csrf
                <div class="">
                    @if(session('success'))
                        <div
                            class="bg-green-100 border border-green-400 text-black px-4 py-3 rounded relative mt-2 mb-2">
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
                        <label for="brand" class="block text-gray-700 font-bold mb-2">Brand:</label>
                        <input type="text" id="brand" name="brand" class="w-full p-2 border rounded-md"
                            value="{{ old('brand') ?? '' }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="items_specs" class="block text-gray-700 font-bold mb-2">Item/Specs:</label>
                        <input type="text" id="items_specs" name="items_specs" class="w-full p-2 border rounded-md"
                            value="{{ old('items_specs') ?? '' }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="unit_id" class="block text-gray-700 font-bold mb-2">Unit:</label>
                        <select id="unit_id" name="unit_id" class="w-full p-2 border rounded-md" required>
                            <option value="">Select a unit</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit->id }}"
                                    {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                                    {{ $unit->unit }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="quantity" class="block text-gray-700 font-bold mb-2">Quantity:</label>
                        <input type="number" id="quantity" name="quantity" class="w-full p-2 border rounded-md"
                            value="{{ old('quantity') ?? '' }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="unit_price" class="block text-gray-700 font-bold mb-2">Unit Price:</label>
                        <input type="number" id="unit_price" name="unit_price" class="w-full p-2 border rounded-md"
                            value="{{ old('unit_price') ?? '' }}" required>
                    </div>
                    <div class="mb-2">
                        <label for="supplier_id" class="block text-gray-700 font-bold mb-2">Supplier:</label>
                        <select id="supplier_id" name="supplier_id" class="w-full p-2 border rounded-md" required>
                            <option value="">Select a supplier</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}"
                                    {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->supplier }}</option>
                            @endforeach
                            <option value="add_new">
                                Add new supplier
                            </option>
                        </select>
                    </div>
                    <div class="modal-container ">
                        <!-- Modal for adding new supplier -->
                        <!-- <div id="defaultModal" tabindex="-1" aria-hidden="true"
                            class="fixed top-0 left-0 right-0 z-50 p-4 w-full md:inset-0 h-modal md:h-full hidden"> -->
                        <div id="add-supplier-modal" tabindex="-1" aria-hidden="true"
                            class="flex fixed top-0 left-0 right-0 z-50 p-4 w-full md:inset-0 h-modal
                            md:h-full hidden">
                            <div class="relative mx-auto my-auto p-4 w-full max-w-2xl h-full md:h-auto">
                                <!-- Modal content -->
                                <div
                                    class="relative bg-white rounded-lg shadow-lg dark:bg-white border border-slate-400">
                                    <button type="button"
                                        class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                                        onclick="document.getElementById('add-supplier-modal').classList.toggle('hidden')">
                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                    <div class="p-6 text-center">
                                        <h2 class="mb-4 text-lg font-bold text-black">Add New Supplier</h2>
                                        <input type="text" id="new_supplier" name="new_supplier"
                                            class="w-full p-2 border rounded-md mb-2">
                                        <div class="flex flex-end">
                                            <button type="button" id="add-supplier-btn"
                                                class="ml-auto rounded-md shadow-md px-5 py-2 bg-green-600 hover:shadow-md hover:bg-green-500 transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white">Add
                                                Supplier</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hidden" id="add-supplier-form">
                        <label for="new_supplier" class="block text-gray-700 font-bold mb-2">New Supplier:</label>
                        <input type="text" id="new_supplier" name="new_supplier" class="w-full p-2 border rounded-md mb-2">
                        <button type="button" id="add-supplier-btn"
                            class="ml-auto rounded-md shadow-md px-5 py-2 bg-green-600 hover:shadow-md hover:bg-green-500 transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white">Add
                            Supplier</button>
                    </div>
                </div>
                <div class="space-x-2 flex">
                    <button type="button"
                        class="ml-auto rounded-md shadow-md px-5 py-2 bg-red-600 hover:shadow-md hover:bg-red-500
                        transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white"
                        onclick="history.back()">Back</button>
                    <button type="submit"
                        class="ml-auto rounded-md shadow-md px-5 py-2 bg-green-600 hover:shadow-md hover:bg-green-500
                        transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white">Add
                        Item
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const supplierSelect = document.getElementById('supplier_id');
        const addSupplierModal = document.getElementById('add-supplier-modal');
        const addSupplierBtn = document.getElementById('add-supplier-btn');

        supplierSelect.addEventListener('change', function () {
            if (supplierSelect.value === 'add_new') {
                addSupplierModal.classList.remove('hidden');
            } else {
                addSupplierModal.classList.add('hidden');
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
</script>
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
