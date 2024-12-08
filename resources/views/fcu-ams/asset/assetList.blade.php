@extends('layouts.layout')
@section('content')
<link rel="stylesheet" href="{{ asset('css/asset.css') }}">

<div class="grid grid-cols-6">
    @include('layouts.sidebar')
    <div class="content min-h-screen bg-slate-100 col-span-5">
        <nav class="bg-white flex justify-between py-3 px-4 m-3 shadow-md rounded-md">
            <div></div>
            <h1 class="my-auto text-3xl">Asset</h1>
            <a href="{{ route('profile.index') }}" class="flex gap-3" style="min-width:100px;">
                <!-- <img src="{{ asset('profile/profile.png') }}" class="w-10 h-10 rounded-full" alt="" srcset=""> -->
                <div>
                     @if(auth()->user()->profile_picture)
                        <img src="{{ asset(auth()->user()->profile_picture) }}" alt="User Profile"
                            class="w-14 h-14  object-cover bg-no-repeat rounded-full mx-auto">
                    @else
                        <img src="{{ asset('profile/defaultProfile.png') }}" alt="Default Image"
                            class="w-14 h-14  object-cover bg-no-repeat rounded-full mx-auto">
                    @endif
                </div>
                <p class="my-auto">
                    {{ (auth()->user() ? auth()->user()->first_name . ' ' . auth()->user()->last_name : 'N/A') }}
                </p>
            </a>
        </nav>
        <div class="m-3 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-lg shadow-md p-6 col-span-2">
                <div class="flex align-items-center mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mr-2" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                            clip-rule="evenodd" />
                    </svg>
                    <h3 class="text-lg font-semibold my-auto">Total Asset</h3>
                </div>
                <p class="text-3xl font-bold">{{ $totalAssets }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6 col-span-2">
                <div class="flex align-items-center mb-2">
                    <svg class="h-10 w-10 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <h3 class="text-lg font-semibold my-auto">Total Cost</h3>
                </div>
                <p class="text-3xl font-bold">₱{{ number_format($totalCost, 2) }}</p>
            </div>
            <!-- <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex align-items-center mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="h-10 w-10 mr-2" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 17.25 12 21m0 0-3.75-3.75M12 21V3" />
                    </svg>
                    <h3 class="text-lg font-semibold my-auto">Low Asset Value</h3>
                </div>
                <p class="text-3xl font-bold">{{ $lowValueAssets }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex align-items-center mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.25 6.75 12 3m0 0 3.75 3.75M12 3v18" />
                    </svg>
                    <h3 class="text-lg font-semibold my-auto">High Asset Value</h3>
                </div>
                <p class="text-3xl font-bold">{{ $highValueAssets }}</p>
            </div> -->
        </div>
        <div class="mb-1 flex justify-between m-3 rounded-md">
            <div class="space-x-2 flex">
                <!-- <div class="import-list my-auto">
                    <form action="{{ route('asset.import') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="file" class="border rounded-md" name="file" accept=".xlsx, .xls, .csv" required>
                        <button type="submit"
                            class="border border-amber-600 text-amber-600 hover:bg-amber-600 hover:text-white transition-all duration-200 ease-in rounded-md p-2">
                            Import from Excel
                        </button>
                    </form>
                </div> -->
                @if(Auth::user()->role->role != 'Viewer')
                <div class="export-list my-auto">
                    <button type="button" onclick="window.location.href='{{ route('asset.export') }}'"
                        class="flex gap-2 items-center bg-indigo-600 text-white hover:scale-105 transition-all duration-200 ease-in rounded-md px-4 p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 my-auto" viewBox="0 0 384 512">
                            <path fill="#FFFFFF" d="M48 448L48 64c0-8.8 7.2-16 16-16l160 0 0 80c0 17.7 14.3 32 32 32l80 0 0 288c0 8.8-7.2 16-16 16L64 464c-8.8 0-16-7.2-16-16zM64 0C28.7 0 0 28.7 0 64L0 448c0 35.3 28.7 64 64
                                64l256 0c35.3 0 64-28.7 64-64l0-293.5c0-17-6.7-33.3-18.7-45.3L274.7 18.7C262.7 6.7 246.5
                                0 229.5 0L64 0zm90.9 233.3c-8.1-10.5-23.2-12.3-33.7-4.2s-12.3 23.2-4.2 33.7L161.6
                                320l-44.5 57.3c-8.1 10.5-6.3 25.5 4.2 33.7s25.5 6.3 33.7-4.2L192 359.1l37.1 47.6c8.1
                                10.5 23.2 12.3 33.7 4.2s12.3-23.2 4.2-33.7L222.4 320l44.5-57.3c8.1-10.5
                                6.3-25.5-4.2-33.7s-25.5-6.3-33.7 4.2L192 280.9l-37.1-47.6z"/>
                        </svg>
                        Export to Excel
                    </button>
                </div>
                @endif
            </div>
            <div class="pagination-here flex justify-between align-items-center">
                <div class="flex align-items-center">
                    <ul class="pagination my-auto flex">
                        <li class="page-item p-1 my-auto">
                            <a class="page-link my-auto" href="{{ $assets->url(1) }}">
                                <svg class="w-5 h-5 my-auto" viewBox="0 0 48 48" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g id="previous">
                                        <g id="previous_2">
                                            <path id="Combined Shape" fill-rule="evenodd" clip-rule="evenodd"
                                                d="M28.9682 15.5438L39.257 8.52571C41.2485 7.16707 43.9486 8.59383 43.9486 11.0038V36.9158C43.9486 39.3272 41.249 40.7548 39.257 39.3958L20.2635 26.4382C18.5169 25.2492 18.5171 22.6726 20.2631 21.4817L26.9682 16.908V11.0064C26.9682 10.2023 26.0683 9.7271 25.4042 10.1802L6.43638 23.134C5.85532 23.5311 5.85532 24.3887 6.43618 24.7866L25.4038 37.7403C26.0683 38.1936 26.9682 37.7185 26.9682 36.9144V35.9744C26.9682 35.4221 27.4159 34.9744 27.9682 34.9744C28.5205 34.9744 28.9682 35.4221 28.9682 35.9744V36.9144C28.9682 39.3259 26.2685 40.7513 24.2762 39.3922L5.30706 26.4374C3.56509 25.2441 3.56509 22.6737 5.30824 21.4826L24.2766 8.52831C26.2685 7.16942 28.9682 8.59489 28.9682 11.0064V15.5438ZM26.9682 19.329V23.0024C26.9682 23.5547 27.4159 24.0024 27.9682 24.0024C28.5205 24.0024 28.9682 23.5547 28.9682 23.0024V17.9648L40.3841 10.1779C41.048 9.72496 41.9486 10.2009 41.9486 11.0038V36.9158C41.9486 37.7205 41.0482 38.1967 40.3842 37.7437L21.3892 24.785C20.8083 24.3898 20.8083 23.5308 21.3901 23.1339L26.9682 19.329Z"
                                                fill="#000000" />
                                        </g>
                                    </g>
                                </svg>
                            </a>
                        </li>
                        <li class="page-item p-1 my-auto">
                            <a class="page-link my-auto" href="{{ $assets->previousPageUrl() }}">
                                <svg fill="#000000" class="w-5 h-5 my-auto" viewBox="0 0 24 24" id="previous"
                                    data-name="Line Color" xmlns="http://www.w3.org/2000/svg" class="icon line-color">
                                    <path id="primary" d="M17,3V21L5,12Z"
                                        style="fill: none; stroke: rgb(0, 0, 0); stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;">
                                    </path>
                                </svg>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="text-center my-auto pr-4 pl-4 font_bold">
                    Showing {{ $assets->firstItem() }} to {{ $assets->lastItem() }} of
                    {{ $assets->total() }} items
                </div>
                <div class="flex align-items-center">
                    <ul class="pagination my-auto flex">
                        <li class="page-item p-1">
                            <a class="page-link" href="{{ $assets->nextPageUrl() }}">
                                <svg fill="#000000" class="w-5 h-5 my-auto" viewBox="0 0 24 24" id="next"
                                    data-name="Line Color" xmlns="http://www.w3.org/2000/svg" class="icon line-color">
                                    <path id="primary" d="M17,12,5,21V3Z"
                                        style="fill: none; stroke: rgb(0, 0, 0); stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;">
                                    </path>
                                </svg>
                            </a>
                        </li>
                        <li class="page-item p-1 my-auto">
                            <a class="page-link" href="{{ $assets->url($assets->lastPage()) }}">
                                <svg class="w-5 h-5 my-auto" viewBox="0 0 48 48" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g id="next">
                                        <g id="next_2">
                                            <path id="Combined Shape" fill-rule="evenodd" clip-rule="evenodd"
                                                d="M18.9792 32.3759L8.69035 39.3951C6.69889 40.7537 3.99878 39.3269 3.99878 36.917V11.005C3.99878 8.59361 6.69843 7.166 8.69028 8.52489L27.6843 21.4809C29.4304 22.672 29.4304 25.249 27.6843 26.4371L20.9792 31.0114V36.9144C20.9792 37.7185 21.8791 38.1937 22.5432 37.7406L41.5107 24.787C42.0938 24.3882 42.0938 23.5316 41.5112 23.1342L22.5436 10.1805C21.8791 9.72714 20.9792 10.2023 20.9792 11.0064V11.9464C20.9792 12.4987 20.5315 12.9464 19.9792 12.9464C19.4269 12.9464 18.9792 12.4987 18.9792 11.9464V11.0064C18.9792 8.59492 21.6789 7.16945 23.6711 8.52861L42.6387 21.4823C44.3845 22.6732 44.3845 25.2446 42.6391 26.4382L23.6707 39.3925C21.6789 40.7514 18.9792 39.3259 18.9792 36.9144V32.3759ZM18.9792 29.9548L7.56322 37.7429C6.89939 38.1958 5.99878 37.7199 5.99878 36.917V11.005C5.99878 10.2003 6.89924 9.72409 7.56321 10.1771L26.5573 23.1331C27.1391 23.53 27.1391  24.389 26.5573 24.785L18.9792 29.9548Z"
                                                fill="#000000" />
                                        </g>
                                    </g>
                                </svg>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="m-3">
            @include('layouts.messageWithoutTimerForError')
        </div>
        <div class="bg-white p-5 shadow-md m-3 rounded-md">
            <div class="flex justify-between mb-6">
                <h2 class="text-2xl font-bold my-auto">Asset List</h2>
                <div class="searchBox flex gap-2">
                    <button type="button" onclick="document.getElementById('filterModal').classList.remove('hidden')"
                        class="flex gap-1 items-center bg-blue-600 text-white hover:scale-105 transition-all duration-200 ease-in rounded-md px-4 p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
                        </svg>
                        Filter
                    </button>
                    
                    <!-- Filter Modal -->
                    <div id="filterModal" class="fixed inset-0 flex items-center justify-center z-50 hidden bg-black bg-opacity-50">
                        <div class="bg-white rounded-lg shadow-lg p-6 w-11/12 md:w-1/2 max-h-[80vh] overflow-y-auto">
                            <h2 class="text-2xl font-bold mb-4">Filter Assets</h2>
                            <form id="filterForm" action="{{ route('asset.list') }}" method="GET" class="space-y-4">
                                <!-- Categories Filter -->
                                <div class="border-b border-gray-300 pb-4 mb-4">
                                    <h3 class="segoe font-semibold mb-2">Categories</h3>
                                    <div class="grid grid-cols-3 gap-2">
                                        @foreach($allCategories as $cat)
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" name="categories[]" value="{{ $cat->id }}"
                                                    class="form-checkbox"
                                                    {{ in_array($cat->id, $selectedCategories) ? 'checked' : '' }}>
                                                <span class="ml-2">{{ $cat->category }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Departments Filter -->
                                <div class="border-b border-gray-300 pb-4 mb-4">
                                    <h3 class="segoe font-semibold mb-2">Departments</h3>
                                    <div class="grid grid-cols-3 gap-2">
                                        @foreach($allDepartments as $dept)
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" name="departments[]" value="{{ $dept->id }}"
                                                    class="form-checkbox"
                                                    {{ in_array($dept->id, $selectedDepartments) ? 'checked' : '' }}>
                                                <span class="ml-2">{{ $dept->department }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Locations Filter -->
                                <div class="border-b border-gray-300 pb-4 mb-4">
                                    <h3 class="segoe font-semibold mb-2">Locations</h3>
                                    <div class="grid grid-cols-3 gap-2">
                                        @foreach($allLocations as $loc)
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" name="locations[]" value="{{ $loc->id }}"
                                                    class="form-checkbox"
                                                    {{ in_array($loc->id, $selectedLocations) ? 'checked' : '' }}>
                                                <span class="ml-2">{{ $loc->location }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Sites Filter -->
                                <div class="border-b border-gray-300 pb-4 mb-4">
                                    <h3 class="segoe font-semibold mb-2">Sites</h3>
                                    <div class="grid grid-cols-3 gap-2">
                                        @foreach($allSites as $site_item)
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" name="sites[]" value="{{ $site_item->id }}"
                                                    class="form-checkbox"
                                                    {{ in_array($site_item->id, $selectedSites) ? 'checked' : '' }}>
                                                <span class="ml-2">{{ $site_item->site }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Suppliers Filter -->
                                <div class="border-b border-gray-300 pb-4 mb-4">
                                    <h3 class="segoe font-semibold mb-2">Suppliers</h3>
                                    <div class="grid grid-cols-3 gap-2">
                                        @foreach($allSuppliers as $sup)
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" name="suppliers[]" value="{{ $sup->id }}"
                                                    class="form-checkbox"
                                                    {{ in_array($sup->id, $selectedSuppliers) ? 'checked' : '' }}>
                                                <span class="ml-2">{{ $sup->supplier }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Brands Filter -->
                                <div class="border-b border-gray-300 pb-4 mb-4">
                                    <h3 class="segoe font-semibold mb-2">Brands</h3>
                                    <div class="grid grid-cols-3 gap-2">
                                        @foreach($allBrands as $brand_item)
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" name="brands[]" value="{{ $brand_item->id }}"
                                                    class="form-checkbox"
                                                    {{ in_array($brand_item->id, $selectedBrands) ? 'checked' : '' }}>
                                                <span class="ml-2">{{ $brand_item->brand }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex justify-end gap-2 mt-4">
                                    <button type="button"
                                        onclick="document.getElementById('filterModal').classList.add('hidden')"
                                        class="flex gap-1 items-center bg-gray-300 text-gray-700 hover:bg-gray-400 transition-all duration-200 ease-in rounded-md px-4 py-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                        </svg>
                                        Cancel
                                    </button>
                                    <button type="submit" 
                                        class="flex gap-1 items-center bg-blue-600 text-white hover:bg-blue-700 transition-all duration-200 ease-in rounded-md px-4 py-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
                                        </svg>
                                        Apply Filters
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <form action="{{ route('asset.list') }}" method="GET" class="flex gap-2">
                        <div class="flex gap-2">
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="rounded-md border-0 py-1.5 pl-2 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6"
                                placeholder="Search assets...">
                            <button type="submit"
                                class="flex gap-1 items-center bg-blue-600 text-white hover:scale-105 transition-all duration-200 ease-in rounded-md px-4 p-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                </svg>
                                Search
                            </button>
                            <button type="button" onclick="window.location.href='{{ route('asset.list') }}'"
                                class="flex gap-1 items-center bg-red-600 text-white hover:scale-105 transition-all duration-200 ease-in rounded-md px-4 p-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                </svg>
                                Clear
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="overflow-x-auto overflow-y-auto rounded-lg shadow">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <span>Asset Tag ID</span>
                                    <a class="ml-2" href="{{ route('asset.list', ['sort' => 'asset_tag_id', 'direction' => ($direction == 'asc' && $sort == 'asset_tag_id') ? 'desc' : 'asc']) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                        </svg>
                                    </a>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <span>Cost</span>
                                    <a class="ml-2" href="{{ route('asset.list', ['sort' => 'cost', 'direction' => ($direction == 'asc' && $sort == 'cost') ? 'desc' : 'asc']) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                        </svg>
                                    </a>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <span>Supplier</span>
                                    <a class="ml-2" href="{{ route('asset.list', ['sort' => 'supplier_name', 'direction' => ($direction == 'asc' && $sort == 'supplier_name') ? 'desc' : 'asc']) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                        </svg>
                                    </a>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <span>Category</span>
                                    <a class="ml-2" href="{{ route('asset.list', ['sort' => 'category_name', 'direction' => ($direction == 'asc' && $sort == 'category_name') ? 'desc' : 'asc']) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                        </svg>
                                    </a>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <span>Status</span>
                                    <a class="ml-2" href="{{ route('asset.list', ['sort' => 'status_name', 'direction' => ($direction == 'asc' && $sort == 'status_name') ? 'desc' : 'asc']) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                        </svg>
                                    </a>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <span>Condition</span>
                                    <a class="ml-2" href="{{ route('asset.list', ['sort' => 'condition_name', 'direction' => ($direction == 'asc' && $sort == 'condition_name') ? 'desc' : 'asc']) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                        </svg>
                                    </a>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($assets as $asset)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $asset->asset_tag_id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">₱{{ number_format($asset->cost, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $asset->supplier_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $asset->category_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-6 py-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($asset->status_name == 'Available') bg-green-100 text-green-800 
                                        @elseif($asset->status_name == 'In Use') bg-blue-100 text-blue-800
                                        @else bg-red-100 text-red-800 
                                        @endif">
                                        {{ $asset->status_name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                                        {{ $asset->condition_name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ route('asset.show', $asset->id) }}" 
                                           class="text-green-600 hover:text-blue-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        @if(Auth::user()->role->role != 'Viewer')
                                        <a href="{{ route('asset.edit', $asset->id) }}" 
                                           class="text-indigo-600 hover:text-indigo-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <button onclick="document.getElementById('deleteAssetModal').classList.remove('hidden'); document.getElementById('assetId').value = '{{ $asset->id }}'"
                                                class="text-red-600 hover:text-red-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('layouts.modals.asset.deleteAsset')
<script src="{{ asset('js/chart.js') }}"></script>
<script>
    document.querySelectorAll(
            'select[name="category"], select[name="department"], select[name="location"], select[name="site"], select[name="supplier"], select[name="brand"]'
        )
        .forEach(function (select) {
            var old_element = select;
            var new_element = old_element.cloneNode(true);
            old_element.parentNode.replaceChild(new_element, old_element);
        });

    window.onclick = function (event) {
        const modal = document.getElementById('filterModal');
        if (event.target == modal) {
            modal.classList.add('hidden');
        }
    }
</script>
<script>
    function clearSearch() {
        document.querySelector('input[name="search"]').value = '';
        document.querySelector('form').submit();
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check if the page was reloaded
        if (performance.navigation.type === performance.navigation.TYPE_RELOAD) {
            // Clear search input
            const searchInput = document.querySelector('input[name="search"]');
            if (searchInput) {
                searchInput.value = '';
            }
            
            // Clear all select filters
            const selectFilters = document.querySelectorAll('select[name="category"], select[name="department"], select[name="location"], select[name="site"], select[name="supplier"], select[name="brand"]');
            selectFilters.forEach(function(select) {
                if (select) {
                    select.selectedIndex = 0;
                }
            });

            // Optional: Remove query parameters from URL
            const cleanUrl = window.location.pathname;
            window.history.replaceState({}, document.title, cleanUrl);
        }
    });
</script>

@endsection
