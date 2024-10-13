@extends('layouts.layout')
@section('content')
<link rel="stylesheet" href="{{ asset('css/addAsset.css') }}">

<div class="grid grid-cols-6">
    @include('layouts.sidebar')
    <div class="content min-h-screen bg-slate-100 col-span-5">
        <nav class="m-3 mt-6">
            <h1 class="text-center text-4xl">Add New Asset</h1>
        </nav>
        <div class="stockin-form bg-white m-3 shadow-md rounded-md p-5">
            <form method="POST" enctype="multipart/form-data" action="{{ route('asset.add.store') }}">
                @csrf
                <div class="">
                    @if(session('success'))
                        <div class="successMessage bg-green-600 border border-green-600 text-white px-4 py-3 rounded relative mt-2 mb-2">
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
                        <div class="mb-2 col-span-2">
                            <label for="asset_image" class="block text-gray-700 font-bold mb-2">Asset Image:</label>
                            <input type="file" id="asset_image" name="asset_image" class="w-full border rounded-md bg-gray-100">
                        </div>
                        <div class="mb-2">
                            <label for="asset_tag_id" class="block text-gray-700 font-bold mb-2">Asset Tag ID:</label>
                            <input type="text" id="asset_tag_id" name="asset_tag_id" class="w-full p-2 border rounded-md bg-gray-100"
                            >
                        </div>
                        <div class="mb-2">
                            <label for="brand" class="block text-gray-700 font-bold mb-2">Brand:</label>
                            <input type="text" id="brand" name="brand" class="w-full p-2 border rounded-md bg-gray-100">
                        </div>
                        <div class="mb-2">
                            <label for="model" class="block text-gray-700 font-bold mb-2">Model:</label>
                            <input type="text" id="model" name="model" class="w-full p-2 border rounded-md bg-gray-100">
                        </div>
                        <div class="mb-2">
                            <label for="spec" class="block text-gray-700 font-bold mb-2">Specification:</label>
                            <input type="text" id="specs" name="specs" class="w-full p-2 border rounded-md bg-gray-100">
                        </div>
                        <div class="mb-2">
                            <label for="serial_number" class="block text-gray-700 font-bold mb-2">Serial Number:</label>
                            <input type="text" id="serial_number" name="serial_number"
                                class="w-full p-2 border rounded-md bg-gray-100">
                        </div>
                        <div class="mb-2">
                            <label for="cost" class="block text-gray-700 font-bold mb-2">Cost:</label>
                            <input type="number" id="cost" name="cost" class="w-full p-2 border rounded-md bg-gray-100" min="0">
                        </div>
                        <div class="mb-2">
                            <label for="supplier_id" class="block text-gray-700 font-bold mb-2">Supplier:</label>
                            <div class="flex">
                                <select id="supplier_id" name="supplier_id"
                                    class="w-full p-2 border rounded-md bg-gray-100">
                                    <option value="">Select a supplier</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}"
                                            {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                            {{ $supplier->supplier }}</option>
                                    @endforeach
                                </select>
                                <div
                                    class="ml-2 rounded-md shadow-md px-2 py-1 flex align-items-center bg-green-600 hover:shadow-md hover:bg-green-500 transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white">
                                    <button type="button"
                                        onclick="document.getElementById('add-supplier-modal').classList.toggle('hidden')"
                                        class="flex my-auto">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 4.5v15m7.5-7.5h-15" />
                                        </svg>
                                    </button>
                                </div>
                                <div
                                    class="ml-2 rounded-md shadow-md px-2 py-1 flex align-items-center bg-red-600 hover:shadow-md hover:bg-red-500 transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white">
                                    <button type="button"
                                        onclick="document.getElementById('delete-supplier-modal{{ $supplier->id }}').classList.toggle('hidden')"
                                        class="flex my-auto">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6 ">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label for="site_id" class="block text-gray-700 font-bold mb-2">Site:</label>
                            <div class="flex">
                                <select id="site_id" name="site_id" class="w-full p-2 border rounded-md  bg-gray-100">
                                    <option value="">Select a site</option>
                                    @foreach($sites as $site)
                                        <option value="{{ $site->id }}">{{ $site->site }}</option>
                                    @endforeach
                                </select>
                                <div
                                    class="ml-2 rounded-md shadow-md px-2 py-1 flex align-items-center bg-green-600 hover:shadow-md hover:bg-green-500 transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white">
                                    <button type="button"
                                        onclick="document.getElementById('add-site-modal').classList.toggle('hidden')"
                                        class="flex my-auto">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 4.5v15m7.5-7.5h-15" />
                                        </svg>
                                    </button>
                                </div>
                                <div
                                    class="ml-2 rounded-md shadow-md px-2 py-1 flex align-items-center bg-red-600 hover:shadow-md hover:bg-red-500 transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white">
                                    <button type="button"
                                        onclick="document.getElementById('delete-site-modal{{ $site->id }}').classList.toggle('hidden')"
                                        class="flex my-auto">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6 ">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label for="location_id" class="block text-gray-700 font-bold mb-2">Location:</label>
                            <div class="flex">
                                <select id="location_id" name="location_id"
                                    class="w-full p-2 border rounded-md bg-gray-100">
                                    <option value="">Select a location</option>
                                    @foreach($locations as $location)
                                        <option value="{{ $location->id }}">{{ $location->location }}</option>
                                    @endforeach
                                </select>
                                <div
                                    class="ml-2 rounded-md shadow-md px-2 py-1 flex align-items-center bg-green-600 hover:shadow-md hover:bg-green-500 transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white">
                                    <button type="button"
                                        onclick="document.getElementById('add-location-modal').classList.toggle('hidden')"
                                        class="flex my-auto">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 4.5v15m7.5-7.5h-15" />
                                        </svg>
                                    </button>
                                </div>
                                <div
                                    class="ml-2 rounded-md shadow-md px-2 py-1 flex align-items-center bg-red-600 hover:shadow-md hover:bg-red-500 transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white">
                                    <button type="button"
                                        onclick="document.getElementById('delete-location-modal{{ $location->id }}').classList.toggle('hidden')"
                                        class="flex my-auto">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6 ">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label for="category_id" class="block text-gray-700 font-bold mb-2">Category:</label>
                            <div class="flex">
                                <select id="category_id" name="category_id"
                                    class="w-full p-2 border rounded-md bg-gray-100">
                                    <option value="">Select a category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->category }}</option>
                                    @endforeach
                                </select>
                                <div
                                    class="ml-2 rounded-md shadow-md px-2 py-1 flex align-items-center bg-green-600 hover:shadow-md hover:bg-green-500 transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white">
                                    <button type="button"
                                        onclick="document.getElementById('add-category-modal').classList.toggle('hidden')"
                                        class="flex my-auto">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 4.5v15m7.5-7.5h-15" />
                                        </svg>
                                    </button>
                                </div>
                                <div
                                    class="ml-2 rounded-md shadow-md px-2 py-1 flex align-items-center bg-red-600 hover:shadow-md hover:bg-red-500 transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white">
                                    <button type="button"
                                        onclick="document.getElementById('delete-category-modal{{ $category->id }}').classList.toggle('hidden')"
                                        class="flex my-auto">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6 ">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label for="department_id" class="block text-gray-700 font-bold mb-2">Department:</label>
                            <div class="flex">
                                <select id="department_id" name="department_id"
                                    class="w-full p-2 border rounded-md bg-gray-100">
                                    <option value="">Select a department</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->department }}</option>
                                    @endforeach
                                </select>
                                <div
                                    class="ml-2 rounded-md shadow-md px-2 py-1 flex align-items-center bg-green-600 hover:shadow-md hover:bg-green-500 transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white">
                                    <button type="button"
                                        onclick="document.getElementById('add-department-modal').classList.toggle('hidden')"
                                        class="flex my-auto">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 4.5v15m7.5-7.5h-15" />
                                        </svg>
                                    </button>
                                </div>
                                <div
                                    class="ml-2 rounded-md shadow-md px-2 py-1 flex align-items-center bg-red-600 hover:shadow-md hover:bg-red-500 transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white">
                                    <button type="button"
                                        onclick="document.getElementById('delete-department-modal{{ $department->id }}').classList.toggle('hidden')"
                                        class="flex my-auto">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6 ">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="mb-2">
                            <label for="condition_id" class="block text-gray-700 font-bold mb-2">Condition:</label>
                            <select id="condition_id" name="condition_id" class="w-full p-2 border rounded-md">
                            <option value="">Select a condition</option>
                                @foreach($conditions as $condition)
                                    <option value="{{ $condition->id }}">{{ $condition->condition }}</option>
                                @endforeach
                            </select>
                        </div> -->
                        <div class="mb-2">
                            <label for="purchase_date" class="block text-gray-700 font-bold mb-2">Purchase Date:</label>
                            <input type="date" id="purchase_date" name="purchase_date"
                                class="w-full p-2 border rounded-md bg-gray-100">
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
                                d="M16.5 3.75V16.5L12 14.25 7.5 16.5V3.75m9 0H18A2.25 2.25 0 0 1 20.25 6v12A2.25 2.25 0 0 1 18 20.25H6A2.25 2.25 0 0 1 3.75 18V6A2.25 2.25 0 0 1 6 3.75h1.5m9 0h-9" />
                        </svg>
                        Add Item
                    </button>
                    </div>
            </form>
        </div>
    </div>
</div>
@include('layouts.modals.supplier.addNewSupplier')
@include('layouts.modals.supplier.deleteSupplier')
@include('layouts.modals.site.addNewSite')
@include('layouts.modals.site.deleteSite')
@include('layouts.modals.location.addNewLocation')
@include('layouts.modals.location.deleteLocation')
@include('layouts.modals.category.addNewCategory')
@include('layouts.modals.category.deleteCategory')
@include('layouts.modals.department.addNewDepartment')
@include('layouts.modals.department.deleteDepartment')
<script src="{{ asset('js/chart.js') }}"></script>

@endsection
