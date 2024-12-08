@extends('layouts.layout')
@section('content')
<div class="grid grid-cols-6">
    @include('layouts.sidebar')
    <div class="content min-h-screen bg-gray-100 col-span-5">
        <!-- Header -->
        <div class="bg-white m-3 shadow-md rounded-md 2xl:max-w-7xl 2xl:mx-auto">
            <div class="px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex justify-between">
                    <h1 class="text-2xl font-semibold text-gray-900">Update Asset</h1>
                    <a href="{{ route('asset.list') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Back to List
                    </a>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="m-3 2xl:max-w-7xl 2xl:mx-auto mb-6">
            <!-- Alert messages -->
            @if(session('success'))
                <div class="mb-4 rounded-md bg-green-50 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 rounded-md bg-red-50 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">There were errors with your submission</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Form -->
            <div class="bg-white shadow rounded-lg">
                <form method="POST" enctype="multipart/form-data" action="{{ route('asset.update', ['id' => $asset->id]) }}" class="space-y-6 p-6">
                    @csrf
                    <input type="hidden" name="id" value="{{ $asset->id }}">

                    <!-- Asset Image -->
                    <div class="space-y-1">
                        <label for="asset_image" class="block text-sm font-medium text-gray-700">Asset Image</label>
                        <div class="mt-1 flex items-center">
                            <div class="flex-shrink-0 h-32 w-32 border rounded-lg overflow-hidden bg-gray-100">
                                @if($asset->asset_image)
                                    <img src="{{ asset($asset->asset_image) }}" alt="Asset image" class="h-32 w-32 object-cover">
                                @else
                                    <div class="h-32 w-32 flex items-center justify-center text-gray-400">
                                        <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-2">
                                <div class="relative">
                                    <input type="file" id="asset_image" name="asset_image" class="hidden" accept="image/*">
                                    <label for="asset_image" class="cursor-pointer bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Change Image
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                        <!-- Asset Tag ID -->
                        <div>
                            <label for="asset_tag_id" class="block text-sm font-medium text-gray-700">Asset Tag ID</label>
                            <div class="mt-1">
                                <input type="text" id="asset_tag_id" name="asset_tag_id" value="{{ $asset->asset_tag_id }}" required
                                    class="shadow-sm p-2 border  focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>

                        <!-- Model -->
                        <div>
                            <label for="model" class="block text-sm font-medium text-gray-700">Model</label>
                            <div class="mt-1">
                                <input type="text" id="model" name="model" value="{{ $asset->model }}" required
                                    class="shadow-sm p-2 border  focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>

                        <!-- Specification -->
                        <div>
                            <label for="specs" class="block text-sm font-medium text-gray-700">Specification</label>
                            <div class="mt-1">
                                <input type="text" id="specs" name="specs" value="{{ $asset->specs }}"
                                    class="shadow-sm p-2 border  focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>

                        <!-- Serial Number -->
                        <div>
                            <label for="serial_number" class="block text-sm font-medium text-gray-700">Serial Number</label>
                            <div class="mt-1">
                                <input type="text" id="serial_number" name="serial_number" value="{{ $asset->serial_number }}" required
                                    class="shadow-sm p-2 border  focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>

                        <!-- Cost -->
                        <div>
                            <label for="cost" class="block text-sm font-medium text-gray-700">Cost</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">₱</span>
                                </div>
                                <input type="number" id="cost" name="cost" value="{{ $asset->cost }}" min="0" required
                                    class="focus:ring-indigo-500 p-2 border  focus:border-indigo-500 block w-full pl-7 sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>

                        <!-- Purchase Date -->
                        <div>
                            <label for="purchase_date" class="block text-sm font-medium text-gray-700">Purchase Date</label>
                            <div class="mt-1">
                                <input type="date" id="purchase_date" name="purchase_date" value="{{ $asset->purchase_date }}" required
                                    class="shadow-sm  p-2 border  focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>
                        
                        <!-- Supplier -->
                        <div>
                            <label for="supplier_id" class="block text-sm font-medium text-gray-700">Supplier</label>
                            <select id="supplier_id" name="supplier_id" required
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" {{ $supplier->id == $asset->supplier_id ? 'selected' : '' }}>
                                        {{ $supplier->supplier }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Site -->
                        <div>
                            <label for="site_id" class="block text-sm font-medium text-gray-700">Site</label>
                            <select id="site_id" name="site_id" required
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                @foreach($sites as $site)
                                    <option value="{{ $site->id }}" {{ $site->id == $asset->site_id ? 'selected' : '' }}>
                                        {{ $site->site }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Location -->
                        <div>
                            <label for="location_id" class="block text-sm font-medium text-gray-700">Location</label>
                            <select id="location_id" name="location_id" required
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                @foreach($locations as $location)
                                    <option value="{{ $location->id }}" {{ $location->id == $asset->location_id ? 'selected' : '' }}>
                                        {{ $location->location }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                            <select id="category_id" name="category_id" required
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $category->id == $asset->category_id ? 'selected' : '' }}>
                                        {{ $category->category }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Department -->
                        <div>
                            <label for="department_id" class="block text-sm font-medium text-gray-700">Department</label>
                            <select id="department_id" name="department_id" required
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ $department->id == $asset->department_id ? 'selected' : '' }}>
                                        {{ $department->department }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Brand -->
                        <div>
                            <label for="brand_id" class="block text-sm font-medium text-gray-700">Brand</label>
                            <select id="brand_id" name="brand_id" required
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ $brand->id == $asset->brand_id ? 'selected' : '' }}>
                                        {{ $brand->brand }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status_id" class="block text-sm font-medium text-gray-700">Status</label>
                            <select id="status_id" name="status_id" required
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                @foreach($statuses as $status)
                                    <option value="{{ $status->id }}" {{ $status->id == $asset->status_id ? 'selected' : '' }}>
                                        {{ $status->status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Condition -->
                        <div>
                            <label for="condition_id" class="block text-sm font-medium text-gray-700">Condition</label>
                            <select id="condition_id" name="condition_id" required
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                @foreach($conditions as $condition)
                                    <option value="{{ $condition->id }}" {{ $condition->id == $asset->condition_id ? 'selected' : '' }}>
                                        {{ $condition->condition }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Maintenance Modal -->
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

                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end space-x-3 pt-6 border-t">
                        <a href="{{ route('asset.list') }}" 
                           class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Cancel
                        </a>
                        <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Update Asset
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Preview image before upload
    document.getElementById('asset_image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.querySelector('.h-32.w-32 img, .h-32.w-32 div');
                if (preview.tagName === 'IMG') {
                    preview.src = e.target.result;
                } else {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'h-32 w-32 object-cover';
                    preview.parentNode.replaceChild(img, preview);
                }
            }
            reader.readAsDataURL(file);
        }
    });

    // Show maintenance modal when maintenance condition is selected
    document.getElementById('condition_id').addEventListener('change', function(e) {
        const selectedOption = e.target.options[e.target.selectedIndex];
        const conditionText = selectedOption.textContent.trim();
        if (conditionText === 'Maintenance') {
            document.getElementById('maintenance-modal').classList.remove('hidden');
        }
    });

    // Handle save maintenance button click
    document.getElementById('save-maintenance-btn').addEventListener('click', function() {
        document.getElementById('maintenance-modal').classList.add('hidden');
    });
</script>

@endsection
