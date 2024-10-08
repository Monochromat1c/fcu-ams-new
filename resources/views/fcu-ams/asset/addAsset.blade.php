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
                                    <option value="add_new">
                                        ADD NEW SUPPLIER
                                    </option>
                                </select>
                                <div
                                    class="ml-2 rounded-md shadow-md px-2 py-1 flex align-items-center bg-red-600 hover:shadow-md hover:bg-red-500 transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white">
                                    <a href="#"
                                        onclick="document.getElementById('delete-supplier-modal').classList.toggle('hidden')"
                                        class="flex my-auto">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6 ">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            <div class="modal-container ">
                                <!-- Modal for adding new supplier -->
                                <!-- <div id="defaultModal" tabindex="-1" aria-hidden="true"
                            class="fixed top-0 left-0 right-0 z-50 p-4 w-full md:inset-0 h-modal md:h-full hidden"> -->
                                <div id="add-supplier-modal" tabindex="-1" aria-hidden="true" class="modalBg flex fixed top-0 left-0 right-0 z-50 p-4 w-full md:inset-0 h-modal
                            md:h-full hidden">
                                    <div class="relative mx-auto my-auto p-4 w-full max-w-2xl h-full md:h-auto">
                                        <!-- Modal content -->
                                        <div
                                            class="relative bg-white rounded-lg shadow-lg dark:bg-white border border-slate-400">
                                            <button type="button"
                                                class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                                                onclick="document.getElementById('add-supplier-modal').classList.toggle('hidden')">
                                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor"
                                                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                            <div class="p-6 text-center">
                                                <h2 class="mb-4 text-lg font-bold text-black">Add New Supplier</h2>
                                                <input type="text" id="new_supplier" name="new_supplier"
                                                    class="w-full p-2 border rounded-md mb-2 bg-gray-100">
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
                                <label for="new_supplier" class="block text-gray-700 font-bold mb-2">New
                                    Supplier:</label>
                                <input type="text" id="new_supplier" name="new_supplier"
                                    class="w-full p-2 border rounded-md mb-2">
                                <button type="button" id="add-supplier-btn"
                                    class="ml-auto rounded-md shadow-md px-5 py-2 bg-green-600 hover:shadow-md hover:bg-green-500 transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white">Add
                                    Supplier</button>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label for="site_id" class="block text-gray-700 font-bold mb-2">Site:</label>
                            <select id="site_id" name="site_id" class="w-full p-2 border rounded-md  bg-gray-100">
                                <option value="">Select a site</option>
                                @foreach($sites as $site)
                                    <option value="{{ $site->id }}">{{ $site->site }}</option>
                                @endforeach
                                <option value="add_new">ADD NEW SITE</option>
                            </select>
                            <div class="modal-container ">
                                <!-- Modal for adding new site -->
                                <div id="add-site-modal" tabindex="-1" aria-hidden="true"
                                    class="modalBg flex fixed top-0 left-0 right-0 z-50 p-4 w-full md:inset-0 h-modal md:h-full hidden">
                                    <div class="relative mx-auto my-auto p-4 w-full max-w-2xl h-full md:h-auto">
                                        <!-- Modal content -->
                                        <div
                                            class="relative bg-white rounded-lg shadow-lg dark:bg-white border border-slate-400">
                                            <button type="button"
                                                class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                                                onclick="document.getElementById('add-site-modal').classList.toggle('hidden')">
                                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor"
                                                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                            <div class="p-6 text-center">
                                                <h2 class="mb-4 text-lg font-bold text-black">Add New Site</h2>
                                                <input type="text" id="new_site" name="new_site"
                                                    class="w-full p-2 border rounded-md mb-2 bg-gray-100">
                                                <div class="flex flex-end">
                                                    <button type="button" id="add-site-btn"
                                                        class="ml-auto rounded-md shadow-md px-5 py-2 bg-green-600 hover:shadow-md hover:bg-green-500 transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white">Add
                                                        Site</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="hidden" id="add-site-form">
                                <label for="new_site" class="block text-gray-700 font-bold mb-2">New Site:</label>
                                <input type="text" id="new_site" name="new_site"
                                    class="w-full p-2 border rounded-md mb-2 bg-gray-100">
                                <button type="button" id="add-site-btn"
                                    class="ml-auto rounded-md shadow-md px-5 py-2 bg-green-600 hover:shadow-md hover:bg-green-500 transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white">Add
                                    Site</button>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label for="location_id" class="block text-gray-700 font-bold mb-2">Location:</label>
                            <select id="location_id" name="location_id"
                                class="w-full p-2 border rounded-md bg-gray-100">
                            <option value="">Select a location</option>
                                @foreach($locations as $location)
                                    <option value="{{ $location->id }}">{{ $location->location }}</option>
                                @endforeach
                            <option value="add_new">ADD NEW LOCATION</option>
                            </select>
                            <div class="modal-container ">
                                <!-- Modal for adding new location -->
                                <div id="add-location-modal" tabindex="-1" aria-hidden="true"
                                    class="modalBg flex fixed top-0 left-0 right-0 z-50 p-4 w-full md:inset-0 h-modal md:h-full hidden">
                                    <div class="relative mx-auto my-auto p-4 w-full max-w-2xl h-full md:h-auto">
                                        <!-- Modal content -->
                                        <div
                                            class="relative bg-white rounded-lg shadow-lg dark:bg-white border border-slate-400">
                                            <button type="button"
                                                class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                                                onclick="document.getElementById('add-location-modal').classList.toggle('hidden')">
                                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor"
                                                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                            <div class="p-6 text-center">
                                                <h2 class="mb-4 text-lg font-bold text-black">Add New Location</h2>
                                                <input type="text" id="new_location" name="new_location"
                                                    class="w-full p-2 border rounded-md mb-2 bg-gray-100">
                                                <div class="flex flex-end">
                                                    <button type="button" id="add-location-btn"
                                                        class="ml-auto rounded-md shadow-md px-5 py-2 bg-green-600 hover:shadow-md hover:bg-green-500 transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white">Add
                                                        Location</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="hidden" id="add-location-form">
                                <label for="new_location" class="block text-gray-700 font-bold mb-2">New Location:</label>
                                <input type="text" id="new_location" name="new_location"
                                    class="w-full p-2 border rounded-md mb-2 bg-gray-100">
                                <button type="button" id="add-location-btn"
                                    class="ml-auto rounded-md shadow-md px-5 py-2 bg-green-600 hover:shadow-md hover:bg-green-500 transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white">Add
                                    Location</button>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label for="category_id" class="block text-gray-700 font-bold mb-2">Category:</label>
                            <select id="category_id" name="category_id"
                                class="w-full p-2 border rounded-md bg-gray-100">
                            <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category }}</option>
                                @endforeach
                            <option value="add_new">ADD NEW CATEGORY</option>
                            </select>
                            <div class="modal-container ">
                                <!-- Modal for adding new category -->
                                <div id="add-category-modal" tabindex="-1" aria-hidden="true"
                                    class="modalBg flex fixed top-0 left-0 right-0 z-50 p-4 w-full md:inset-0 h-modal md:h-full hidden">
                                    <div class="relative mx-auto my-auto p-4 w-full max-w-2xl h-full md:h-auto">
                                        <!-- Modal content -->
                                        <div
                                            class="relative bg-white rounded-lg shadow-lg dark:bg-white border border-slate-400">
                                            <button type="button"
                                                class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                                                onclick="document.getElementById('add-category-modal').classList.toggle('hidden')">
                                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor"
                                                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                            <div class="p-6 text-center">
                                                <h2 class="mb-4 text-lg font-bold text-black">Add New Category</h2>
                                                <input type="text" id="new_category" name="new_category"
                                                    class="w-full p-2 border rounded-md mb-2 bg-gray-100">
                                                <div class="flex flex-end">
                                                    <button type="button" id="add-category-btn"
                                                        class="ml-auto rounded-md shadow-md px-5 py-2 bg-green-600 hover:shadow-md hover:bg-green-500 transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white">Add
                                                        Category</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="hidden" id="add-category-form">
                                <label for="new_category" class="block text-gray-700 font-bold mb-2">New
                                    Category:</label>
                                <input type="text" id="new_category" name="new_category"
                                    class="w-full p-2 border rounded-md mb-2 bg-gray-100">
                                <button type="button" id="add-category-btn"
                                    class="ml-auto rounded-md shadow-md px-5 py-2 bg-green-600 hover:shadow-md hover:bg-green-500 transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white">Add
                                    Category</button>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label for="department_id" class="block text-gray-700 font-bold mb-2">Department:</label>
                            <select id="department_id" name="department_id"
                                class="w-full p-2 border rounded-md bg-gray-100"
                            >
                            <option value="">Select a department</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->department }}</option>
                                @endforeach
                            <option value="add_new">ADD NEW DEPARTMENT</option>
                            </select>
                            <div class="modal-container ">
                                <!-- Modal for adding new department -->
                                <div id="add-department-modal" tabindex="-1" aria-hidden="true"
                                    class="modalBg flex fixed top-0 left-0 right-0 z-50 p-4 w-full md:inset-0 h-modal md:h-full hidden">
                                    <div class="relative mx-auto my-auto p-4 w-full max-w-2xl h-full md:h-auto">
                                        <!-- Modal content -->
                                        <div
                                            class="relative bg-white rounded-lg shadow-lg dark:bg-white border border-slate-400">
                                            <button type="button"
                                                class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                                                onclick="document.getElementById('add-department-modal').classList.toggle('hidden')">
                                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor"
                                                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                            <div class="p-6 text-center">
                                                <h2 class="mb-4 text-lg font-bold text-black">Add New Department</h2>
                                                <input type="text" id="new_department" name="new_department"
                                                    class="w-full p-2 border rounded-md mb-2 bg-gray-100">
                                                <div class="flex flex-end">
                                                    <button type="button" id="add-department-btn"
                                                        class="ml-auto rounded-md shadow-md px-5 py-2 bg-green-600 hover:shadow-md hover:bg-green-500 transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white">Add
                                                        Department</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="hidden" id="add-department-form">
                                <label for="new_department" class="block text-gray-700 font-bold mb-2">New
                                    Department:</label>
                                <input type="text" id="new_department" name="new_department"
                                    class="w-full p-2 border rounded-md mb-2 bg-gray-100">
                                <button type="button" id="add-department-btn"
                                    class="ml-auto rounded-md shadow-md px-5 py-2 bg-green-600 hover:shadow-md hover:bg-green-500 transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white">Add
                                    Department</button>
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
        <!-- DELETE CONFIRMATION MODAL -->
        <!-- Delete supplier modal -->
        <div id="delete-supplier-modal" tabindex="-1" aria-hidden="true"
            class="modalBg flex fixed top-0 left-0 right-0 z-50 p-4 w-full md:inset-0 h-modal md:h-full hidden">
            <div class="relative mx-auto my-auto p-4 w-full max-w-2xl h-full md:h-auto">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow-lg dark:bg-white border border-slate-400">
                    <!-- <button type="button"
                        class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                        onclick="document.getElementById('delete-supplier-modal').classList.toggle('hidden')">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button> -->
                    <div class="p-6 text-center">
                        <h2 class="mb-4 text-lg font-bold text-black">Delete Supplier</h2>
                        <p class="mb-4">Are you sure you want to delete this supplier?</p>
                        <div class="flex justify-between">
                            <button type="button"
                                onclick="document.getElementById('delete-supplier-modal').classList.toggle('hidden')"
                                id=""
                                class="rounded-md shadow-md px-5 py-2 bg-orange-600 hover:shadow-md hover:bg-orange-500 
                                transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white">
                                No
                            </button>
                            <button type="button" id="delete-supplier-btn"
                                class="rounded-md shadow-md px-5 py-2 bg-green-600 
                                hover:shadow-md hover:bg-green-500 transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white">
                                Yes
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const deleteSupplierBtn = document.getElementById('delete-supplier-btn');
    const supplierId = {{ $supplier->id }};

    deleteSupplierBtn.addEventListener('click', function () {
        var form = document.createElement('form');
        form.method = 'post';
        form.action = '{{ route('supplier.delete') }}';
        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'id';
        input.value = supplierId;
        form.appendChild(input);
        var csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        form.appendChild(csrfInput);
        document.body.appendChild(form);
        form.submit();
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
<!-- Supplier field -->
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
<!-- Site field -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const siteSelect = document.getElementById('site_id');
    const addSiteModal = document.getElementById('add-site-modal');
    const addSiteBtn = document.getElementById('add-site-btn');

    siteSelect.addEventListener('change', function () {
        if (siteSelect.value === 'add_new') {
            addSiteModal.classList.remove('hidden');
        } else {
            addSiteModal.classList.add('hidden');
        }
    });

    addSiteBtn.addEventListener('click', function () {
        const newSite = document.getElementById('new_site').value;
        if (newSite.trim() !== '') {
            const formData = new FormData();
            formData.append('site', newSite);
            fetch('{{ route('site.add') }}', {
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
<!-- Location field -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const locationSelect = document.getElementById('location_id');
    const addLocationModal = document.getElementById('add-location-modal');
    const addLocationBtn = document.getElementById('add-location-btn');

    locationSelect.addEventListener('change', function () {
        if (locationSelect.value === 'add_new') {
            addLocationModal.classList.remove('hidden');
        } else {
            addLocationModal.classList.add('hidden');
        }
    });

    addLocationBtn.addEventListener('click', function () {
        const newLocation = document.getElementById('new_location').value;
        if (newLocation.trim() !== '') {
            const formData = new FormData();
            formData.append('location', newLocation);
            fetch('{{ route('location.add') }}', {
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
<!-- Category field -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const categorySelect = document.getElementById('category_id');
    const addCategoryModal = document.getElementById('add-category-modal');
    const addCategoryBtn = document.getElementById('add-category-btn');

    categorySelect.addEventListener('change', function () {
        if (categorySelect.value === 'add_new') {
            addCategoryModal.classList.remove('hidden');
        } else {
            addCategoryModal.classList.add('hidden');
        }
    });

    addCategoryBtn.addEventListener('click', function () {
        const newCategory = document.getElementById('new_category').value;
        if (newCategory.trim() !== '') {
            const formData = new FormData();
            formData.append('category', newCategory);
            fetch('{{ route('category.add') }}', {
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
<!-- Department field -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const departmentSelect = document.getElementById('department_id');
    const addDepartmentModal = document.getElementById('add-department-modal');
    const addDepartmentBtn = document.getElementById('add-department-btn');

    departmentSelect.addEventListener('change', function () {
        if (departmentSelect.value === 'add_new') {
            addDepartmentModal.classList.remove('hidden');
        } else {
            addDepartmentModal.classList.add('hidden');
        }
    });

    addDepartmentBtn.addEventListener('click', function () {
        const newDepartment = document.getElementById('new_department').value;
        if (newDepartment.trim() !== '') {
            const formData = new FormData();
            formData.append('department', newDepartment);
            fetch('{{ route('department.add') }}', {
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
