@extends('layouts.layout')
@section('content')
<div class="grid grid-cols-6">
    @include('layouts.sidebar')
    <div class="content min-h-screen bg-slate-200 col-span-5">
        <!-- Header -->
        <div class="bg-white m-3 shadow-md rounded-md 2xl:max-w-7xl 2xl:mx-auto">
            <div class="px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex justify-between">
                    <h1 class="text-2xl font-semibold text-gray-900 mx-auto">Add New Asset</h1>
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
                <form method="POST" enctype="multipart/form-data"
                    action="{{ route('asset.add.store') }}" class="space-y-6 p-6">
                    @csrf

                    <!-- Asset Image -->
                    <div class="space-y-1">
                        <label for="asset_image" class="block text-sm font-medium text-gray-700">Asset Image</label>
                        <div class="mt-1 flex items-center">
                            <div class="flex-shrink-0 h-32 w-32 border rounded-lg overflow-hidden bg-gray-100">
                                <div class="h-32 w-32 flex items-center justify-center text-gray-400">
                                    <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-2">
                                <div class="relative">
                                    <input type="file" id="asset_image" name="asset_image" class="hidden"
                                        accept="image/*">
                                    <label for="asset_image"
                                        class="cursor-pointer bg-white py-2 px-3 border-2 border-slate-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Choose Image
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                        <!-- Asset Tag ID -->
                        <div>
                            <label for="asset_tag_id" class="block text-sm font-medium text-gray-700">Asset Tag
                                ID</label>
                            <div class="mt-1">
                                <input type="text" id="asset_tag_id" name="asset_tag_id" required
                                    class="shadow-sm border-2 border-slate-300 p-2 bg-slate-50 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-slate-300 rounded-md">
                            </div>
                        </div>

                        <!-- Model -->
                        <div>
                            <label for="model" class="block text-sm font-medium text-gray-700">Model</label>
                            <div class="mt-1">
                                <input type="text" id="model" name="model" required
                                    class="shadow-sm border-2 border-slate-300 p-2 bg-slate-50 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-slate-300 rounded-md">
                            </div>
                        </div>

                        <!-- Specification -->
                        <div>
                            <label for="specs" class="block text-sm font-medium text-gray-700">Specification</label>
                            <div class="mt-1">
                                <input type="text" id="specs" name="specs"
                                    class="shadow-sm border-2 border-slate-300 p-2 bg-slate-50 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-slate-300 rounded-md">
                            </div>
                        </div>

                        <!-- Serial Number -->
                        <div>
                            <label for="serial_number" class="block text-sm font-medium text-gray-700">Serial
                                Number</label>
                            <div class="mt-1">
                                <input type="text" id="serial_number" name="serial_number" required
                                    class="shadow-sm border-2 border-slate-300 p-2 bg-slate-50 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-slate-300 rounded-md">
                            </div>
                        </div>

                        <!-- Cost -->
                        <div>
                            <label for="cost" class="block text-sm font-medium text-gray-700">Cost</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">₱</span>
                                </div>
                                <input type="number" id="cost" name="cost" min="0" required
                                    class="focus:ring-indigo-500 border-2 border-slate-300 p-2 bg-slate-50 focus:border-indigo-500 block w-full pl-7 sm:text-sm border-slate-300 rounded-md">
                            </div>
                        </div>

                        <!-- Purchase Date -->
                        <div>
                            <label for="purchase_date" class="block text-sm font-medium text-gray-700">Purchase
                                Date</label>
                            <div class="mt-1">
                                <input type="date" id="purchase_date" name="purchase_date" required
                                    class="shadow-sm border-2 border-slate-300 p-2 bg-slate-50 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-slate-300 rounded-md">
                            </div>
                        </div>

                        <!-- Assigned To -->
                        <div>
                            <label for="assigned_to" class="block text-sm font-medium text-gray-700">Assigned To</label>
                            <div class="mt-1">
                                <button type="button" id="show-assignment-modal"
                                    class="w-full text-left border-2 border-slate-300 p-2 bg-slate-50 border-slate-300 rounded-md shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500 hover:bg-gray-50">
                                    Click to assign
                                </button>
                                <input type="hidden" name="assigned_to" id="assigned_to"
                                    value="{{ old('assigned_to') }}">
                                <input type="hidden" name="issued_date" id="issued_date"
                                    value="{{ old('issued_date') }}">
                                <input type="hidden" name="notes" id="notes"
                                    value="{{ old('notes') }}">
                            </div>
                            @error('assigned_to')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Supplier -->
                        <div>
                            <label for="supplier_id" class="block text-sm font-medium text-gray-700">Supplier</label>
                            <div class="mt-1 flex space-x-2">
                                <select id="supplier_id" name="supplier_id" required
                                    class="block w-full  pl-3 pr-10 py-2 text-base border-2 border-slate-300  bg-slate-50  focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    <option value="">Select a supplier</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}"
                                            {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                            {{ $supplier->supplier }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="button"
                                    onclick="document.getElementById('add-supplier-modal').classList.toggle('hidden')"
                                    class="inline-flex items-center border-2  p-2 border-transparent rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Site -->
                        <div>
                            <label for="site_id" class="block text-sm font-medium text-gray-700">Site</label>
                            <div class="mt-1 flex space-x-2">
                                <select id="site_id" name="site_id" required
                                    class="block w-full pl-3 pr-10 py-2 text-base border-2 border-slate-300  bg-slate-50  focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    <option value="">Select a site</option>
                                    @foreach($sites as $site)
                                        <option value="{{ $site->id }}">{{ $site->site }}</option>
                                    @endforeach
                                </select>
                                <button type="button"
                                    onclick="document.getElementById('add-site-modal').classList.toggle('hidden')"
                                    class="inline-flex items-center border-2  p-2 border-transparent rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Location -->
                        <div>
                            <label for="location_id" class="block text-sm font-medium text-gray-700">Location</label>
                            <div class="mt-1 flex space-x-2">
                                <select id="location_id" name="location_id" required
                                    class="block w-full pl-3 pr-10 py-2 text-base border-2 border-slate-300  bg-slate-50  focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    <option value="">Select a location</option>
                                    @foreach($locations as $location)
                                        <option value="{{ $location->id }}">{{ $location->location }}</option>
                                    @endforeach
                                </select>
                                <button type="button"
                                    onclick="document.getElementById('add-location-modal').classList.toggle('hidden')"
                                    class="inline-flex items-center border-2  p-2 border-transparent rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                            <div class="mt-1 flex space-x-2">
                                <select id="category_id" name="category_id" required
                                    class="block w-full pl-3 pr-10 py-2 text-base border-2 border-slate-300  bg-slate-50  focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    <option value="">Select a category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->category }}</option>
                                    @endforeach
                                </select>
                                <button type="button"
                                    onclick="document.getElementById('add-category-modal').classList.toggle('hidden')"
                                    class="inline-flex items-center border-2  p-2 border-transparent rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Department -->
                        <div>
                            <label for="department_id"
                                class="block text-sm font-medium text-gray-700">Department</label>
                            <div class="mt-1 flex space-x-2">
                                <select id="department_id" name="department_id" required
                                    class="block w-full pl-3 pr-10 py-2 text-base border-2 border-slate-300  bg-slate-50  focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    <option value="">Select a department</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->department }}</option>
                                    @endforeach
                                </select>
                                <button type="button"
                                    onclick="document.getElementById('add-department-modal').classList.toggle('hidden')"
                                    class="inline-flex items-center border-2  p-2 border-transparent rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                            @error('department_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Brand -->
                        <div>
                            <label for="brand_id" class="block text-sm font-medium text-gray-700">Brand</label>
                            <div class="mt-1 flex space-x-2">
                                <select id="brand_id" name="brand_id" required
                                    class="block w-full pl-3 pr-10 py-2 text-base border-2 border-slate-300  bg-slate-50  focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    <option value="">Select a brand</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->brand }}</option>
                                    @endforeach
                                </select>
                                <button type="button"
                                    onclick="document.getElementById('add-brand-modal').classList.toggle('hidden')"
                                    class="inline-flex items-center border-2  p-2 border-transparent rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end space-x-3 pt-6 border-t">
                        <button type="submit"
                            class="inline-flex justify-center py-2 px-5 text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Add Asset
                        </button>
                    </div>
                </form>
                <!-- Assignment Modal -->
                <div class="modal-container">
                    <div id="assignment-modal" tabindex="-1" aria-hidden="true"
                        class="modalBg fixed inset-0 z-50 overflow-y-auto bg-gray-900 bg-opacity-50 backdrop-blur-sm hidden">
                        <div class="flex min-h-screen items-center justify-center p-4">
                            <div
                                class="relative w-full max-w-xl transform overflow-hidden rounded-2xl bg-white shadow-2xl transition-all">
                                <!-- Header -->
                                <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                                    <div class="flex items-center justify-between">
                                        <h2 class="text-xl font-semibold text-gray-800">Asset Assignment</h2>
                                        <button type="button"
                                            class="rounded-md p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none"
                                            onclick="document.getElementById('assignment-modal').classList.toggle('hidden')">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <!-- Body -->
                                <div class="px-6 py-4">
                                    <div class="space-y-4">
                                        <!-- Assigned To Field -->
                                        <div>
                                            <label for="modal_assigned_to"
                                                class="block text-sm font-medium text-gray-700">Assigned To</label>
                                            <div class="mt-1">
                                                <input type="text" id="modal_assigned_to"
                                                    class="block w-full px-4 py-2 border-2 border-gray-200 hover:shadow-inner rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                                    value="{{ old('assigned_to') }}"
                                                    placeholder="Enter assignee name">
                                            </div>
                                        </div>

                                        <!-- Date Issued Field -->
                                        <div>
                                            <label for="modal_issued_date"
                                                class="block text-sm font-medium text-gray-700">Date Issued</label>
                                            <div class="mt-1">
                                                <input type="date" id="modal_issued_date"
                                                    class="block w-full px-4 py-2 border-2 border-gray-200 hover:shadow-inner rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                                    value="{{ old('issued_date') }}">
                                            </div>
                                        </div>

                                        <!-- Notes Field -->
                                        <div>
                                            <label for="modal_notes"
                                                class="block text-sm font-medium text-gray-700">Notes</label>
                                            <div class="mt-1">
                                                <textarea id="modal_notes"
                                                    class="block w-full px-4 py-2 border-2 border-gray-200 hover:shadow-inner rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                                    rows="3"
                                                    placeholder="Add any additional notes here">{{ old('notes') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Footer -->
                                <div class="bg-gray-50 px-6 py-4">
                                    <div class="flex items-center justify-end space-x-3">
                                        <button type="button"
                                            class="rounded-md border-2 border-slate-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                            onclick="document.getElementById('assignment-modal').classList.toggle('hidden')">
                                            Cancel
                                        </button>
                                        <button type="button" id="save-assignment-btn"
                                            class="rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                            Save Changes
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
@include('layouts.modals.department.addNewDepartment')
@include('layouts.modals.department.deleteDepartment')
@include('layouts.modals.brand.addNewBrand')
@include('layouts.modals.brand.deleteBrand')

<script>
    // Preview image before upload
    document.getElementById('asset_image').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
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

    // Show assignment modal when button is clicked
    document.getElementById('show-assignment-modal').addEventListener('click', function () {
        document.getElementById('assignment-modal').classList.remove('hidden');
    });

    // Handle save assignment button click
    document.getElementById('save-assignment-btn').addEventListener('click', function () {
        const assignedTo = document.getElementById('modal_assigned_to').value;
        const issuedDate = document.getElementById('modal_issued_date').value;
        const notes = document.getElementById('modal_notes').value;

        // Update hidden inputs
        document.getElementById('assigned_to').value = assignedTo;
        document.getElementById('issued_date').value = issuedDate;
        document.getElementById('notes').value = notes;

        // Update button text
        document.getElementById('show-assignment-modal').textContent = assignedTo || 'Click to assign';

        // Hide modal
        document.getElementById('assignment-modal').classList.add('hidden');
    });
</script>

@endsection
