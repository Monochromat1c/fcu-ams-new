@extends('layouts.layout')
@section('content')
<link rel="stylesheet" href="{{ asset('css/addAsset.css') }}">

<div class="grid grid-cols-6">
    @include('layouts.sidebar')
    <div class="content min-h-screen bg-slate-100 col-span-5">
        <nav class="m-3 mt-6">
            <h1 class="text-center text-4xl">Edit the Asset</h1>
        </nav>
        <div class="stockin-form bg-white m-3 shadow-md rounded-md p-5">
            <form method="POST" enctype="multipart/form-data"
                action="{{ route('asset.update', ['id' => $asset->id]) }}">
                @csrf
                <input type="hidden" name="id" value="{{ $asset->id }}">
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
                <h3 class="text-lg font-semibold mb-3">Asset Details</h3>
                <div class="grid grid-cols-2 gap-3">
                    <div class="mb-4 col-span-2">
                        <label for="asset_image" class="block text-gray-700 font-bold mb-2">Asset Image:</label>
                        <input type="file" id="asset_image" name="asset_image" class="w-full border rounded-md bg-gray-100">
                    </div>
                    <div class="mb-4">
                        <label for="asset_tag_id" class="block text-gray-700 font-bold mb-2">Asset Tag ID:</label>
                        <input type="text" id="asset_tag_id" name="asset_tag_id" class="w-full p-2 border rounded-md bg-gray-100"
                            value="{{ $asset->asset_tag_id }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="brand" class="block text-gray-700 font-bold mb-2">Brand:</label>
                        <input type="text" id="brand" name="brand" class="w-full p-2 border rounded-md bg-gray-100"
                            value="{{ $asset->brand }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="model" class="block text-gray-700 font-bold mb-2">Model:</label>
                        <input type="text" id="model" name="model" class="w-full p-2 border rounded-md bg-gray-100"
                            value="{{ $asset->model }}" required>
                    </div>
                    <div class="mb-2">
                        <label for="spec" class="block text-gray-700 font-bold mb-2">Specification:</label>
                        <input type="text" id="specs" name="specs" class="w-full p-2 border rounded-md bg-gray-100"
                            value="{{ $asset->specs }}">
                    </div>
                    <div class="mb-4">
                        <label for="serial_number" class="block text-gray-700 font-bold mb-2">Serial Number:</label>
                        <input type="text" id="serial_number" name="serial_number" class="w-full p-2 border rounded-md bg-gray-100"
                            value="{{ $asset->serial_number }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="cost" class="block text-gray-700 font-bold mb-2">Cost:</label>
                        <input type="number" id="cost" name="cost" class="w-full p-2 border rounded-md bg-gray-100"
                            value="{{ $asset->cost }}" min="0" required>
                    </div>
                    <div class="mb-4">
                        <label for="supplier_id" class="block text-gray-700 font-bold mb-2">Supplier:</label>
                        <select id="supplier_id" name="supplier_id" class="w-full p-2 border rounded-md bg-gray-100" required>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}"
                                    {{ $supplier->id == $asset->supplier_id ? 'selected' : '' }}>
                                    {{ $supplier->supplier }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="site_id" class="block text-gray-700 font-bold mb-2">Site:</label>
                        <select id="site_id" name="site_id" class="w-full p-2 border rounded-md bg-gray-100" required>
                            @foreach($sites as $site)
                                <option value="{{ $site->id }}"
                                    {{ $site->id == $asset->site_id ? 'selected' : '' }}>
                                    {{ $site->site }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="location_id" class="block text-gray-700 font-bold mb-2">Location:</label>
                        <select id="location_id" name="location_id" class="w-full p-2 border rounded-md bg-gray-100" required>
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}"
                                    {{ $location->id == $asset->location_id ? 'selected' : '' }}>
                                    {{ $location->location }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="category_id" class="block text-gray-700 font-bold mb-2">Category:</label>
                        <select id="category_id" name="category_id" class="w-full p-2 border rounded-md bg-gray-100" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $category->id == $asset->category_id ? 'selected' : '' }}>
                                    {{ $category->category }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="department_id" class="block text-gray-700 font-bold mb-2">Department:</label>
                        <select id="department_id" name="department_id" class="w-full p-2 border rounded-md bg-gray-100" required>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}"
                                    {{ $department->id == $asset->department_id ? 'selected' : '' }}>
                                    {{ $department->department }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="status_id" class="block text-gray-700 font-bold mb-2">Status:</label>
                        <select id="status_id" name="status_id" class="w-full p-2 border rounded-md bg-gray-100" required>
                            @foreach($statuses as $status)
                                <option value="{{ $status->id }}"
                                    {{ $status->id == $asset->status_id ? 'selected' : '' }}>
                                    {{ $status->status }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="condition_id" class="block text-gray-700 font-bold mb-2">Condition:</label>
                        <select id="condition_id" name="condition_id" class="w-full p-2 border rounded-md bg-gray-100" required>
                            @foreach($conditions as $condition)
                                <option value="{{ $condition->id }}"
                                    {{ $condition->id == $asset->condition_id ? 'selected' : '' }}>
                                    {{ $condition->condition }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="purchase_date" class="block text-gray-700 font-bold mb-2">Purchase Date:</label>
                        <input type="date" id="purchase_date" name="purchase_date"
                            class="w-full p-2 border rounded-md bg-gray-100" value="{{ $asset->purchase_date }}"
                            required>
                    </div>
                </div>
                <!-- Add this inside your edit asset form, after the condition field -->
                <div class="modal-container">
                    <div id="maintenance-modal" tabindex="-1" aria-hidden="true"
                        class="modalBg flex fixed top-0 left-0 right-0 z-50 p-4 w-full md:inset-0 h-modal md:h-full hidden">
                        <div class="relative mx-auto my-auto p-4 w-full max-w-2xl h-full md:h-auto">
                            <div class="relative bg-white rounded-lg shadow-lg dark:bg-white border border-slate-400">
                                <button type="button"
                                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                                    onclick="document.getElementById('maintenance-modal').classList.toggle('hidden')">
                                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                                <div class="p-6 text-center">
                                    <h2 class="mb-4 text-lg font-bold text-black">Maintenance Date</h2>
                                    <div class="mb-4">
                                        <label for="maintenance_start_date"
                                            class="block text-left text-gray-700 font-bold mb-2">Start Date:</label>
                                        <input type="date" id="maintenance_start_date" name="maintenance_start_date"
                                            class="w-full p-2 border rounded-md"
                                            value="{{ old('maintenance_start_date') ?? $asset->maintenance_start_date }}">
                                    </div>
                                    <div class="mb-4">
                                        <label for="maintenance_end_date" class="block text-left text-gray-700 font-bold mb-2">End
                                            Date:</label>
                                        <input type="date" id="maintenance_end_date" name="maintenance_end_date"
                                            class="w-full p-2 border rounded-md"
                                            value="{{ old('maintenance_end_date') ?? $asset->maintenance_end_date }}">
                                    </div>
                                    <div class="flex flex-end">
                                        <button type="button" id="save-maintenance-btn"
                                            class="ml-auto rounded-md shadow-md px-5 py-2 bg-green-600 hover:shadow-md hover:bg-green-500 transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" class="ml-auto rounded-md shadow-md px-5 py-2 bg-red-600 hover:shadow-md hover:bg-red-500
                        transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white flex my-auto gap-2"
                        onclick="history.back()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                        </svg>
                        Back
                    </button>
                    <button type="submit" class="rounded-md shadow-md px-5 py-2 bg-green-600 hover:shadow-md hover:bg-green-500
                        transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white flex my-auto gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.5 3.75V16.5L12 14.25 7.5 16.5V3.75m9 0H18A2.25 2.25 0 0 1 20.25 6v12A2.25 2.25 0 0 1 18 20.25H6A2.25 2.25 0 0 1 3.75 18V6A2.25 2.25 0 0 1 6 3.75h1.5m9 0h-9" />
                        </svg>
                        Update Asset
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('js/chart.js') }}"></script>
  
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const conditionSelect = document.getElementById('condition_id');
        const maintenanceModal = document.getElementById('maintenance-modal');
        const saveMaintenanceBtn = document.getElementById('save-maintenance-btn');

        conditionSelect.addEventListener('change', function () {
            const selectedCondition = conditionSelect.options[conditionSelect.selectedIndex].text;
            if (selectedCondition === 'Maintenance') {
                maintenanceModal.classList.remove('hidden');
            } else {
                maintenanceModal.classList.add('hidden');
                document.getElementById('maintenance_start_date').value = '';
                document.getElementById('maintenance_end_date').value = '';
            }
        });

        saveMaintenanceBtn.addEventListener('click', function () {
            maintenanceModal.classList.add('hidden');
        });
    });
</script>
@endsection
