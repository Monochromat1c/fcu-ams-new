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
                <h3 class="text-lg font-semibold mb-3">Asset Details</h3>
                <div class="grid grid-cols-2 gap-3">
                    <div class="mb-4 col-span-2">
                        <label for="asset_image" class="block text-gray-700 font-bold mb-2">Asset Image:</label>
                        <input type="file" id="asset_image" name="asset_image" class="w-full border rounded-md">
                    </div>
                    <div class="mb-4">
                        <label for="asset_name" class="block text-gray-700 font-bold mb-2">Asset Name:</label>
                        <input type="text" id="asset_name" name="asset_name" class="w-full p-2 border rounded-md"
                            value="{{ $asset->asset_name }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="brand" class="block text-gray-700 font-bold mb-2">Brand:</label>
                        <input type="text" id="brand" name="brand" class="w-full p-2 border rounded-md"
                            value="{{ $asset->brand }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="model" class="block text-gray-700 font-bold mb-2">Model:</label>
                        <input type="text" id="model" name="model" class="w-full p-2 border rounded-md"
                            value="{{ $asset->model }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="serial_number" class="block text-gray-700 font-bold mb-2">Serial Number:</label>
                        <input type="text" id="serial_number" name="serial_number" class="w-full p-2 border rounded-md"
                            value="{{ $asset->serial_number }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="cost" class="block text-gray-700 font-bold mb-2">Cost:</label>
                        <input type="number" id="cost" name="cost" class="w-full p-2 border rounded-md"
                            value="{{ $asset->cost }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="supplier_id" class="block text-gray-700 font-bold mb-2">Supplier:</label>
                        <select id="supplier_id" name="supplier_id" class="w-full p-2 border rounded-md" required>
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
                        <select id="site_id" name="site_id" class="w-full p-2 border rounded-md" required>
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
                        <select id="location_id" name="location_id" class="w-full p-2 border rounded-md" required>
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
                        <select id="category_id" name="category_id" class="w-full p-2 border rounded-md" required>
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
                        <select id="department_id" name="department_id" class="w-full p-2 border rounded-md" required>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}"
                                    {{ $department->id == $asset->department_id ? 'selected' : '' }}>
                                    {{ $department->department }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="purchase_date" class="block text-gray-700 font-bold mb-2">Purchase Date:</label>
                        <input type="date" id="purchase_date" name="purchase_date" class="w-full p-2 border rounded-md"
                            value="{{ $asset->purchase_date }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="condition_id" class="block text-gray-700 font-bold mb-2">Condition:</label>
                        <select id="condition_id" name="condition_id" class="w-full p-2 border rounded-md" required>
                            @foreach($conditions as $condition)
                                <option value="{{ $condition->id }}"
                                    {{ $condition->id == $asset->condition_id ? 'selected' : '' }}>
                                    {{ $condition->condition }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" class="ml-auto rounded-md shadow-md px-5 py-2 bg-red-600 hover:shadow-md hover:bg-red-500
                        transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white"
                        onclick="history.back()">Back</button>
                    <button type="submit" class="rounded-md shadow-md px-5 py-2 bg-green-600 hover:shadow-md hover:bg-green-500
                        transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white">Update
                        Asset
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
