@extends('layouts.layout')
@section('content')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

<div class="grid grid-cols-6">
    @include('layouts.sidebar')
    <div class="content min-h-screen bg-slate-200 col-span-5">
        <!-- Header -->
        <div class="bg-white m-3 shadow-md rounded-md 2xl:max-w-7xl 2xl:mx-auto">
            <div class="px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex justify-between">
                    <a href="{{ route('asset.list') }}"
                        class="mr-4 hover:bg-gray-100 my-auto p-2 rounded-full transition">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
                    <h1 class="text-2xl font-semibold text-gray-900">Update Asset</h1>
                    <a href="{{ route('asset.list') }}"
                        class="mr-4 invisible hover:bg-gray-100 my-auto p-2 rounded-full transition">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
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
                    action="{{ route('asset.update', ['id' => $asset->id]) }}"
                    class="space-y-6 p-6">
                    @csrf
                    <input type="hidden" name="id" value="{{ $asset->id }}">
                    <!-- Add hidden inputs for disposed amount and status -->
                    <input type="hidden" name="disposed_amount" id="hidden_disposed_amount" value="{{ $asset->disposed_amount }}">
                    <input type="hidden" name="disposed_status_id" id="hidden_disposed_status_id" value="{{ $asset->disposed_status_id }}">

                    <!-- Asset Image -->
                    <div class="space-y-1">
                        <label for="asset_image" class="block text-sm font-medium text-gray-700">Asset Image</label>
                        <div class="mt-1 flex items-center">
                            <div class="flex-shrink-0 h-32 w-32 border rounded-lg overflow-hidden bg-gray-100">
                                @if($asset->asset_image)
                                    <img src="{{ asset($asset->asset_image) }}" alt="Asset image"
                                        class="h-32 w-32 object-cover">
                                @else
                                    <div class="h-32 w-32 flex items-center justify-center text-gray-400">
                                        <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-2">
                                <div class="relative">
                                    <input type="file" id="asset_image" name="asset_image" class="hidden"
                                        accept="image/*">
                                    <label for="asset_image"
                                        class="cursor-pointer bg-white py-2 px-3 border border-2 bg-slate-50 border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Change Image
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
                                <input type="text" id="asset_tag_id" name="asset_tag_id"
                                    value="{{ $asset->asset_tag_id }}" required
                                    class="shadow-sm p-2 border  focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-2 bg-slate-50 border-gray-300 rounded-md">
                            </div>
                        </div>

                        <!-- Model -->
                        <div>
                            <label for="model" class="block text-sm font-medium text-gray-700">Model</label>
                            <div class="mt-1">
                                <input type="text" id="model" name="model" value="{{ $asset->model }}" required
                                    class="shadow-sm p-2 border  focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-2 bg-slate-50 border-gray-300 rounded-md">
                            </div>
                        </div>

                        <!-- Specification -->
                        <div>
                            <label for="specs" class="block text-sm font-medium text-gray-700">Specification</label>
                            <div class="mt-1">
                                <textarea id="specs" name="specs" rows="4"
                                    class="shadow-sm p-2 border focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-2 bg-slate-50 border-gray-300 rounded-md">{{ $asset->specs }}</textarea>
                            </div>
                        </div>

                        <!-- Serial Number -->
                        <div>
                            <label for="serial_number" class="block text-sm font-medium text-gray-700">Serial
                                Number</label>
                            <div class="mt-1">
                                <input type="text" id="serial_number" name="serial_number"
                                    value="{{ $asset->serial_number }}" required
                                    class="shadow-sm p-2 border  focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-2 bg-slate-50 border-gray-300 rounded-md">
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
                                    class="focus:ring-indigo-500 p-2 border  focus:border-indigo-500 block w-full pl-7 sm:text-sm border-2 bg-slate-50 border-gray-300 rounded-md">
                            </div>
                        </div>

                        <!-- Purchase Date -->
                        <div>
                            <label for="purchase_date" class="block text-sm font-medium text-gray-700">Purchase
                                Date</label>
                            <div class="mt-1">
                                <input type="date" id="purchase_date" name="purchase_date"
                                    value="{{ $asset->purchase_date }}" required
                                    class="shadow-sm  p-2 border  focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-2 bg-slate-50 border-gray-300 rounded-md">
                            </div>
                        </div>

                        <!-- Assigned To -->
                        <div>
                            <label for="assigned_to" class="block text-sm font-medium text-gray-700">Assigned To</label>
                            <div class="mt-1">
                                <button type="button" id="show-assignment-modal"
                                    class="w-full text-left p-2 border border-2 bg-slate-50 border-gray-300 rounded-md shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500 
                                           {{ $asset->assigned_to ? 'bg-gray-100 cursor-not-allowed text-gray-500' : 'hover:bg-gray-50' }}"
                                    {{ $asset->assigned_to ? 'disabled' : '' }}> 
                                    {{ $asset->assigned_to ? $asset->assigned_to : 'Click to assign' }}
                                </button>
                                <input type="hidden" name="assigned_to" id="assigned_to"
                                    value="{{ old('assigned_to', $asset->assigned_to) }}">
                                <input type="hidden" name="issued_date" id="issued_date"
                                    value="{{ old('issued_date', $asset->issued_date) }}">
                                <input type="hidden" name="notes" id="notes"
                                    value="{{ old('notes', $asset->notes) }}">
                            </div>
                            @if($asset->assigned_to)
                                <p class="mt-1 text-xs text-gray-500">Asset is currently assigned. Please return it first to reassign.</p>
                            @endif
                        </div>

                        <!-- Supplier -->
                        <div>
                            <label for="supplier_id" class="block text-sm font-medium text-gray-700">Supplier</label>
                            <div class="mt-1 flex space-x-2">
                                <select id="supplier_id" name="supplier_id" required
                                    class="block w-full pl-3 pr-10 py-2 text-base border-2 bg-slate-50 border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}"
                                            {{ $supplier->id == $asset->supplier_id ? 'selected' : '' }}>
                                            {{ $supplier->supplier }}
                                        </option>
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

                        <!-- Site -->
                        <div>
                            <label for="site_id" class="block text-sm font-medium text-gray-700">Site</label>
                            <div class="mt-1 flex space-x-2">
                                <select id="site_id" name="site_id" required
                                    class="block w-full pl-3 pr-10 py-2 text-base border-2 bg-slate-50 border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    @foreach($sites as $site)
                                        <option value="{{ $site->id }}"
                                            {{ $site->id == $asset->site_id ? 'selected' : '' }}>
                                            {{ $site->site }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="button"
                                    onclick="document.getElementById('add-site-modal').classList.remove('hidden')"
                                    class="inline-flex items-center p-2 border border-transparent rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Location -->
                        <div>
                            <label for="location_id" class="block text-sm font-medium text-gray-700">Location</label>
                            <div class="mt-1 flex space-x-2">
                                <select id="location_id" name="location_id" required
                                    class="block w-full pl-3 pr-10 py-2 text-base border-2 bg-slate-50 border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    @foreach($locations as $location)
                                        <option value="{{ $location->id }}"
                                            {{ $location->id == $asset->location_id ? 'selected' : '' }}>
                                            {{ $location->location }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="button"
                                    onclick="document.getElementById('add-location-modal').classList.remove('hidden')"
                                    class="inline-flex items-center p-2 border border-transparent rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                            <div class="mt-1 flex space-x-2">
                                <select id="category_id" name="category_id" required
                                    class="block w-full pl-3 pr-10 py-2 text-base border-2 bg-slate-50 border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $category->id == $asset->category_id ? 'selected' : '' }}>
                                            {{ $category->category }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="button"
                                    onclick="document.getElementById('add-category-modal').classList.remove('hidden')"
                                    class="inline-flex items-center p-2 border border-transparent rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Department -->
                        <div>
                            <label for="department_id" class="block text-sm font-medium text-gray-700">Department</label>
                            <div class="mt-1 flex space-x-2">
                                <select id="department_id" name="department_id" required
                                    class="block w-full pl-3 pr-10 py-2 text-base border-2 bg-slate-50 border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}"
                                            {{ $department->id == $asset->department_id ? 'selected' : '' }}>
                                            {{ $department->department }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="button"
                                    onclick="document.getElementById('add-department-modal').classList.remove('hidden')"
                                    class="inline-flex items-center p-2 border border-transparent rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Brand -->
                        <div>
                            <label for="brand_id" class="block text-sm font-medium text-gray-700">Brand</label>
                            <div class="mt-1 flex space-x-2">
                                <select id="brand_id" name="brand_id" required
                                    class="block w-full pl-3 pr-10 py-2 text-base border-2 bg-slate-50 border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}"
                                            {{ $brand->id == $asset->brand_id ? 'selected' : '' }}>
                                            {{ $brand->brand }}
                                        </option>
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

                        <!-- Status -->
                        <div>
                            <label for="status_id" class="block text-sm font-medium text-gray-700">Status</label>
                            <div class="mt-1 flex space-x-2">
                                <select id="status_id" name="status_id" required
                                    class="block w-full pl-3 pr-10 py-2 text-base border-2 bg-slate-50 border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    @foreach($statuses as $status)
                                        <option value="{{ $status->id }}"
                                            {{ $status->id == $asset->status_id ? 'selected' : '' }}>
                                            {{ $status->status }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="button"
                                    onclick="document.getElementById('add-status-modal').classList.remove('hidden')"
                                    class="inline-flex items-center p-2 border border-transparent rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Condition -->
                        <div>
                            <label for="condition_id" class="block text-sm font-medium text-gray-700">Condition</label>
                            <div class="mt-1 flex space-x-2">
                                <select id="condition_id" name="condition_id" required
                                    class="block w-full pl-3 pr-10 py-2 text-base border-2 bg-slate-50 border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    @foreach($conditions as $condition)
                                        <option value="{{ $condition->id }}"
                                            {{ $condition->id == $asset->condition_id ? 'selected' : '' }}>
                                            {{ $condition->condition }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @if($asset->disposed_amount)
                                <div class="mt-2">
                                    <span class="text-sm text-gray-500">Disposed Amount: ₱{{ number_format($asset->disposed_amount, 2) }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Maintenance Modal -->
                        <div class="modal-container">
                            <div id="maintenance-modal" tabindex="-1" aria-hidden="true"
                                class="modalBg fixed inset-0 z-50 overflow-y-auto bg-gray-900 bg-opacity-50 backdrop-blur-sm hidden">
                                <div class="flex min-h-screen items-center justify-center p-4">
                                    <div class="relative w-full max-w-xl transform overflow-hidden rounded-2xl bg-white shadow-2xl transition-all">
                                        <!-- Header -->
                                        <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                                            <div class="flex items-center justify-between">
                                                <h3 class="text-lg font-medium text-gray-900">Set Maintenance Period</h3>
                                                <button type="button" class="text-gray-400 hover:text-gray-500" onclick="document.getElementById('maintenance-modal').classList.toggle('hidden')">
                                                    <span class="sr-only">Close</span>
                                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Modal Body -->
                                        <div class="px-6 py-4">
                                            <div class="space-y-4">
                                                <!-- Start Date -->
                                                <div>
                                                    <label for="maintenance_start_date" class="block text-sm font-medium text-gray-700">
                                                        Maintenance Start Date
                                                    </label>
                                                    <div class="mt-1">
                                                        <input type="date" id="maintenance_start_date" name="maintenance_start_date"
                                                            value="{{ $asset->maintenance_start_date }}"
                                                            class="block w-full rounded-md border-2 px-5 py-2 bg-slate-50 border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                                    </div>
                                                </div>

                                                <!-- End Date -->
                                                <div>
                                                    <label for="maintenance_end_date" class="block text-sm font-medium text-gray-700">
                                                        Maintenance End Date
                                                    </label>
                                                    <div class="mt-1">
                                                        <input type="date" id="maintenance_end_date" name="maintenance_end_date"
                                                            value="{{ $asset->maintenance_end_date }}"
                                                            class="block w-full rounded-md border-2 px-5 py-2 bg-slate-50 border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Footer -->
                                        <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3">
                                            <button type="button"
                                                class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                                onclick="document.getElementById('maintenance-modal').classList.toggle('hidden')">
                                                Cancel
                                            </button>
                                            <button type="button"
                                                class="inline-flex items-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                                onclick="document.getElementById('maintenance-modal').classList.toggle('hidden')">
                                                Set Maintenance Period
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Disposed Amount Modal -->
                        <div class="modal-container">
                            <div id="disposed-modal" tabindex="-1" aria-hidden="true"
                                class="modalBg fixed inset-0 z-50 overflow-y-auto bg-gray-900 bg-opacity-50 backdrop-blur-sm hidden">
                                <div class="flex min-h-screen items-center justify-center p-4">
                                    <div class="relative w-full max-w-xl transform overflow-hidden rounded-2xl bg-white shadow-2xl transition-all">
                                        <!-- Header -->
                                        <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                                            <div class="flex items-center justify-between">
                                                <h3 class="text-lg font-medium text-gray-900">Enter Disposed Amount</h3>
                                                <button type="button" class="text-gray-400 hover:text-gray-500" onclick="document.getElementById('disposed-modal').classList.toggle('hidden')">
                                                    <span class="sr-only">Close</span>
                                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Content -->
                                        <div class="px-6 py-4">
                                            <div class="space-y-4">
                                                <div>
                                                    <label for="disposed_amount" class="block text-sm font-medium text-gray-700">Disposed Amount (₱)</label>
                                                    <div class="mt-1">
                                                        <input type="number" id="disposed_amount" name="disposed_amount" step="0.01" min="0" 
                                                            value="{{ $asset->disposed_amount }}" {{ $asset->disposed_amount ? 'disabled' : '' }}
                                                            class="shadow-sm p-2 border focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-2 bg-slate-50 border-gray-300 rounded-md {{ $asset->disposed_amount ? 'bg-gray-100' : '' }}">
                                                    </div>
                                                </div>
                                                <div>
                                                    <label for="disposed_status_id" class="block text-sm font-medium text-gray-700">Disposal Status</label>
                                                    <div class="mt-1">
                                                        <select id="disposed_status_id" name="disposed_status_id" 
                                                            class="shadow-sm p-2 border focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-2 bg-slate-50 border-gray-300 rounded-md">
                                                            @foreach($disposedStatuses as $disposedStatus)
                                                                <option value="{{ $disposedStatus->id }}" 
                                                                    {{ $asset->disposed_status_id == $disposedStatus->id ? 'selected' : '' }}>
                                                                    {{ $disposedStatus->status }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Footer -->
                                        <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3">
                                            <button type="button"
                                                class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                                onclick="document.getElementById('disposed-modal').classList.toggle('hidden')">
                                                Cancel
                                            </button>
                                            <button type="button"
                                                class="inline-flex items-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                                onclick="saveDisposedAmount()">
                                                Save
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

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
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12" />
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
                                                        class="block text-sm font-medium text-gray-700">Assigned
                                                        To</label>
                                                    <div class="mt-1">
                                                        <input type="text" id="modal_assigned_to"
                                                            class="block w-full px-4 py-2 border-2 border-gray-200 hover:shadow-inner rounded-md border-2 bg-slate-50 border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                                            value="{{ old('assigned_to') ?? $asset->assigned_to }}"
                                                            placeholder="Enter assignee name">
                                                    </div>
                                                </div>

                                                <!-- Date Issued Field -->
                                                <div>
                                                    <label for="modal_issued_date"
                                                        class="block text-sm font-medium text-gray-700">Date
                                                        Issued</label>
                                                    <div class="mt-1">
                                                        <input type="date" id="modal_issued_date"
                                                            class="block w-full px-4 py-2 border-2 border-gray-200 hover:shadow-inner rounded-md border-2 bg-slate-50 border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                                            value="{{ old('issued_date') ?? $asset->issued_date ?? date('Y-m-d') }}">
                                                    </div>
                                                </div>

                                                <!-- Notes Field -->
                                                <div>
                                                    <label for="modal_notes"
                                                        class="block text-sm font-medium text-gray-700">Notes</label>
                                                    <div class="mt-1">
                                                        <textarea id="modal_notes"
                                                            class="block w-full px-4 py-2 border-2 border-gray-200 hover:shadow-inner rounded-md border-2 bg-slate-50 border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                                            rows="3"
                                                            placeholder="Add any additional notes here">{{ old('notes') ?? $asset->notes }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Footer -->
                                        <div class="bg-gray-50 px-6 py-4">
                                            <div class="flex items-center justify-end space-x-3">
                                                <button type="button"
                                                    class="rounded-md border border-2 bg-slate-50 border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
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

                    <!-- Form Actions -->
                    <div class="flex justify-end space-x-3 pt-6 border-t">
                        <a href="{{ route('asset.list') }}"
                            class="inline-flex justify-center py-2 px-4 border border-2 bg-slate-50 border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Cancel
                        </a>
                        <button type="submit"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Update Asset
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modals -->
<x-add-item-modal 
    title="Add New Supplier"
    id="add-supplier-modal"
    route="{{ route('supplier.add') }}"
    field="supplier"
/>

<x-add-item-modal 
    title="Add New Site"
    id="add-site-modal"
    route="{{ route('site.add') }}"
    field="site"
/>

<x-add-item-modal 
    title="Add New Location"
    id="add-location-modal"
    route="{{ route('location.add') }}"
    field="location"
/>

<x-add-item-modal 
    title="Add New Category"
    id="add-category-modal"
    route="{{ route('category.add') }}"
    field="category"
/>

<x-add-item-modal 
    title="Add New Department"
    id="add-department-modal"
    route="{{ route('department.add') }}"
    field="department"
/>

<x-add-item-modal 
    title="Add New Brand"
    id="add-brand-modal"
    route="{{ route('brand.add') }}"
    field="brand"
/>

<x-add-item-modal 
    title="Add New Status"
    id="add-status-modal"
    route="{{ route('status.add') }}"
    field="status"
/>

<x-add-item-modal 
    title="Add New Condition"
    id="add-condition-modal"
    route="{{ route('condition.add') }}"
    field="condition"
/>



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

    // Show maintenance modal when maintenance condition is selected
    document.getElementById('condition_id').addEventListener('change', function (e) {
        const selectedOption = e.target.options[e.target.selectedIndex];
        const conditionText = selectedOption.textContent.trim();
        if (conditionText === 'Maintenance') {
            document.getElementById('maintenance-modal').classList.remove('hidden');
        }
    });

    // Show assignment modal when button is clicked
    document.addEventListener('DOMContentLoaded', function() {
        const showAssignmentButton = document.getElementById('show-assignment-modal');
        const assignmentModal = document.getElementById('assignment-modal');
        const saveAssignmentButton = document.getElementById('save-assignment-btn');
        const modalAssignedTo = document.getElementById('modal_assigned_to');
        const modalIssuedDate = document.getElementById('modal_issued_date');
        const modalNotes = document.getElementById('modal_notes');

        if (showAssignmentButton && assignmentModal) {
            showAssignmentButton.addEventListener('click', function(e) {
                e.preventDefault();
                if (!this.disabled) {
                    assignmentModal.classList.remove('hidden');
                }
            });
        }

        if (saveAssignmentButton) {
            saveAssignmentButton.addEventListener('click', function() {
                const assignedTo = modalAssignedTo.value;
                const issuedDate = modalIssuedDate.value;
                const notes = modalNotes.value;

                // Update hidden inputs
                document.getElementById('assigned_to').value = assignedTo;
                document.getElementById('issued_date').value = issuedDate;
                document.getElementById('notes').value = notes;

                // Update button text
                document.getElementById('show-assignment-modal').textContent = assignedTo || 'Click to assign';

                // Hide modal
                assignmentModal.classList.add('hidden');
            });
        }

        // ENTER KEY HANDLER FOR ASSIGNMENT MODAL
        [modalAssignedTo, modalIssuedDate, modalNotes].forEach(function(input) {
            if (input) {
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        // Only trigger if modal is visible
                        if (!assignmentModal.classList.contains('hidden')) {
                            e.preventDefault();
                            saveAssignmentButton.click();
                        }
                    }
                });
            }
        });
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
                console.error('Error:', error);
            });
    }

    // Add event listeners for form submissions
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (this.getAttribute('action').includes('add') && this.closest('[id]')?.id.includes('modal')) {
                e.preventDefault();
                const formData = new FormData(this);
                
                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Refresh the corresponding select options
                        const modalId = this.closest('[id]').id;
                        const selectId = modalId.replace('add-', '').replace('-modal', '_id');
                        refreshSelectOptions(selectId, `/${selectId.replace('_id', '')}/list`);
                        
                        // Clear the form
                        this.reset();
                        
                        // Hide the modal
                        document.getElementById(modalId).classList.add('hidden');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const conditionSelect = document.getElementById('condition_id');
        const disposedModal = document.getElementById('disposed-modal');
    
        conditionSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.textContent.trim() === 'Disposed') {
                disposedModal.classList.remove('hidden');
            }
        });
    });
    
    function saveDisposedAmount() {
        const disposedAmount = document.getElementById('disposed_amount').value;
        const disposedStatusId = document.getElementById('disposed_status_id').value;
        const conditionDiv = document.getElementById('condition_id').closest('div').parentElement;
        
        // Remove existing disposed amount display if any
        const existingDisplay = conditionDiv.querySelector('.mt-2');
        if (existingDisplay) {
            existingDisplay.remove();
        }

        // Update hidden inputs with the new values
        document.getElementById('hidden_disposed_amount').value = disposedAmount;
        document.getElementById('hidden_disposed_status_id').value = disposedStatusId;

        // Add new disposed amount display if amount exists
        if (disposedAmount) {
            const displayDiv = document.createElement('div');
            displayDiv.className = 'mt-2';
            displayDiv.innerHTML = `<span class="text-sm text-gray-500">Disposed Amount: ₱${parseFloat(disposedAmount).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</span>`;
            conditionDiv.appendChild(displayDiv);
            
            // Disable the input
            document.getElementById('disposed_amount').disabled = true;
            document.getElementById('disposed_amount').classList.add('bg-gray-100');
        }

        // Close the modal
        document.getElementById('disposed-modal').classList.add('hidden');
    }

    // Add event listener for condition change
    document.addEventListener('DOMContentLoaded', function() {
        const conditionSelect = document.getElementById('condition_id');
        const disposedModal = document.getElementById('disposed-modal');
    
        conditionSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.textContent.trim() === 'Disposed') {
                // Reset the disposed amount input when showing the modal
                document.getElementById('disposed_amount').disabled = false;
                document.getElementById('disposed_amount').classList.remove('bg-gray-100');
                document.getElementById('disposed_amount').value = '';
                // Show the modal
                disposedModal.classList.remove('hidden');
            } else {
                // Clear disposed values when condition is not disposed
                document.getElementById('hidden_disposed_amount').value = '';
                document.getElementById('hidden_disposed_status_id').value = '';
                // Remove the display if it exists
                const existingDisplay = conditionSelect.closest('div').parentElement.querySelector('.mt-2');
                if (existingDisplay) {
                    existingDisplay.remove();
                }
            }
        });
    });
</script>

@endsection
