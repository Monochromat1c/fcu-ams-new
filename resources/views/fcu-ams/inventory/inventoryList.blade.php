@extends('layouts.layout')
@section('content')
<link rel="stylesheet" href="{{ asset('css/inventory.css') }}">

<div class="grid grid-cols-6">
    @include('layouts.sidebar')
    <div class="content min-h-screen bg-slate-100 col-span-5">
        <nav class="bg-white flex justify-between py-3 px-4 m-3 shadow-md rounded-md">
            <div></div>
            <h1 class="my-auto text-3xl">Inventory</h1>
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
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex align-items-center mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 my-auto" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6 6.878V6a2.25 2.25 0 0 1 2.25-2.25h7.5A2.25 2.25 0 0 1 18 6v.878m-12 0c.235-.083.487-.128.75-.128h10.5c.263 0 .515.045.75.128m-12 0A2.25 2.25 0 0 0 4.5 9v.878m13.5-3A2.25 2.25 0 0 1 19.5 9v.878m0 0a2.246 2.246 0 0 0-.75-.128H5.25c-.263 0-.515.045-.75.128m15 0A2.25 2.25 0 0 1 21 12v6a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18v-6c0-.98.626-1.813 1.5-2.122" />
                    </svg>
                    <h3 class="text-lg font-semibold my-auto">Total Items</h3>
                </div>
                <p class="text-3xl font-bold">{{ $totalItems }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex align-items-center mb-2">
                    <svg class="h-10 w-10 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <h3 class="text-lg font-semibold my-auto">Total Value</h3>
                </div>
                <p class="text-3xl font-bold">₱{{ number_format($totalValue, 2) }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex align-items-center mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="h-10 w-10 mr-2" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 17.25 12 21m0 0-3.75-3.75M12 21V3" />
                    </svg>
                    <h3 class="text-lg font-semibold my-auto">Low Stocks</h3>
                </div>
                <p class="text-3xl mb-2 font-bold">{{ $lowStock }}</p>
                <a href="{{ route('inventory.low.stock') }}"
                    class="whitespace-nowrap text-orange-600 hover:text-orange-900 flex gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    View 
                </a>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex align-items-center mb-2">
                    <svg class="h-10 w-10 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" />
                    </svg>

                    <h3 class="text-lg font-semibold my-auto">Out of Stocks</h3>
                </div>
                <p class="mb-2 text-3xl font-bold">{{ $outOfStock }}</p>
                <a href="{{ route('inventory.out.of.stock') }}"
                    class="text-red-600 hover:text-red-900 flex gap-1 whitespace-nowrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    View 
                </a>
            </div>
        </div>
        <div class="mb-1 flex justify-between m-3 rounded-md">
            <div class="gap-2 flex">
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
                <div class="export-list my-auto">
                    <button type="button" onclick="window.location.href='{{ route('inventories.export') }}'"
                        class="flex gap-2 items-center bg-indigo-600 text-white hover:scale-105 transition-all duration-200 ease-in rounded-md px-4 p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 my-auto" viewBox="0 0 384 512">
                            <path fill="#FFFFFF" d="M48 448L48 64c0-8.8 7.2-16 16-16l160 0 0 80c0 17.7 14.3 32 32 32l80 0 0 288c0 8.8-7.2
                                16-16 16L64 464c-8.8 0-16-7.2-16-16zM64 0C28.7 0 0 28.7 0 64L0 448c0 35.3 28.7 64 64
                                64l256 0c35.3 0 64-28.7 64-64l0-293.5c0-17-6.7-33.3-18.7-45.3L274.7 18.7C262.7 6.7 246.5
                                0 229.5 0L64 0zm90.9 233.3c-8.1-10.5-23.2-12.3-33.7-4.2s-12.3 23.2-4.2 33.7L161.6
                                320l-44.5 57.3c-8.1 10.5-6.3 25.5 4.2 33.7s25.5 6.3 33.7-4.2L192 359.1l37.1 47.6c8.1
                                10.5 23.2 12.3 33.7 4.2s12.3-23.2 4.2-33.7L222.4 320l44.5-57.3c8.1-10.5
                                6.3-25.5-4.2-33.7s-25.5-6.3-33.7 4.2L192 280.9l-37.1-47.6z" />
                        </svg>
                        Export to Excel
                    </button>
                </div>
            </div>
            <div class="pagination-here flex justify-between align-items-center">
                <div class="flex align-items-center">
                    <ul class="pagination my-auto flex">
                        <li class="page-item p-1 my-auto">
                            <a class="page-link my-auto" href="{{ $inventories->url(1) }}">
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
                            <a class="page-link my-auto" href="{{ $inventories->previousPageUrl() }}">
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
                    Showing {{ $inventories->firstItem() }} to {{ $inventories->lastItem() }} of
                    {{ $inventories->total() }} items
                </div>
                <div class="flex align-items-center">
                    <ul class="pagination my-auto flex">
                        <li class="page-item p-1">
                            <a class="page-link" href="{{ $inventories->nextPageUrl() }}">
                                <svg fill="#000000" class="w-5 h-5 my-auto" viewBox="0 0 24 24" id="next"
                                    data-name="Line Color" xmlns="http://www.w3.org/2000/svg" class="icon line-color">
                                    <path id="primary" d="M17,12,5,21V3Z"
                                        style="fill: none; stroke: rgb(0, 0, 0); stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;">
                                    </path>
                                </svg>
                            </a>
                        </li>
                        <li class="page-item p-1 my-auto">
                            <a class="page-link" href="{{ $inventories->url($inventories->lastPage()) }}">
                                <svg class="w-5 h-5 my-auto" viewBox="0 0 48 48" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g id="next">
                                        <g id="next_2">
                                            <path id="Combined Shape" fill-rule="evenodd" clip-rule="evenodd"
                                                d="M18.9792 32.3759L8.69035 39.3951C6.69889 40.7537 3.99878 39.3269 3.99878 36.917V11.005C3.99878 8.59361 6.69843 7.166 8.69028 8.52489L27.6843 21.4809C29.4304 22.672 29.4304 25.249 27.6843 26.4371L20.9792 31.0114V36.9144C20.9792 37.7185 21.8791 38.1937 22.5432 37.7406L41.5107 24.787C42.0938 24.3882 42.0938 23.5316 41.5112 23.1342L22.5436 10.1805C21.8791 9.72714 20.9792 10.2023 20.9792 11.0064V11.9464C20.9792 12.4987 20.5315 12.9464 19.9792 12.9464C19.4269 12.9464 18.9792 12.4987 18.9792 11.9464V11.0064C18.9792 8.59492 21.6789 7.16945 23.6711 8.52861L42.6387 21.4823C44.3845 22.6732 44.3845 25.2446 42.6391 26.4382L23.6707 39.3925C21.6789 40.7514 18.9792 39.3259 18.9792 36.9144V32.3759ZM18.9792 29.9548L7.56322 37.7429C6.89939 38.1958 5.99878 37.7199 5.99878 36.917V11.005C5.99878 10.2003 6.89924 9.72409 7.56321 10.1771L26.5573 23.1331C27.1391 23.53 27.1391 24.389 26.5582 24.7842L20.9792 28.5904V24.9184C20.9792 24.3661 20.5315 23.9184 19.9792 23.9184C19.4269 23.9184 18.9792 24.3661 18.9792 24.9184V29.9548Z"
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
            @if(session('success'))
                <div
                    class="successMessage bg-green-600 border border-green-600 text-white px-4 py-3 rounded relative mt-2 mb-2">
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div
                    class="errorMessage bg-red-600 border border-red-600 text-white px-4 py-3 rounded relative mt-2 mb-2">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <div class="bg-white p-5 shadow-md m-3 rounded-md">
            <div class="flex justify-between mb-3">
                <h2 class="text-2xl font-bold my-auto">Inventory List</h2>
                <div class="searchBox">
                    <form id="searchboxForm" action="{{ route('inventory.list') }}" method="GET" class=" flex gap-1">
                        <div class="flex align-items-center gap-1">
                            <select name="brand"
                                class="py-3 px-3 border rounded-md border-blue-500 w-96 max-w-40 text-sm bg-white text-blue-500 my-auto">
                                <option value="">All Brands</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}"
                                        {{ $brand->id == $brand_id?'selected' : '' }}>
                                        {{ $brand->brand }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <input type="text" name="search" placeholder="Search for items..."
                            style="padding-top:.69rem;padding-bottom:.69rem;"
                            class="px-3 border rounded-md border-red-950 w-96 text-sm text-gray-700 my-auto">
                        <div class="flex align-items-center gap-1">
                            <button type="submit" style="padding: 0.35rem 0.75rem;"
                                class=" border border-green-600 text-green-600 hover:bg-green-600 hover:text-white transition-all duration-200 ease-in rounded-md">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                </svg>
                            </button>
                            <button type="submit" style="padding: 0.35rem 0.75rem;" name="clear" value="true"
                                class="border border-amber-600 hover:text-white text-amber-600 hover:bg-amber-600 transition-all duration-200 ease-in rounded-md">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="overflow-x-auto overflow-y-auto">
                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <!-- <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400 text-center">Item
                                Profile</th> -->
                            <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400">
                                <div class="flex">
                                    <span class="mx-2 whitespace-nowrap">Unique Tag</span>
                                    <a class="invisible my-auto"
                                        href="{{ route('inventory.list', ['sort' => 'unique_tag', 'direction' => ($direction == 'asc' && $sort == 'unique_tag') ? 'desc' : 'asc']) }}">
                                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 7.5 7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5" />
                                        </svg>
                                    </a>
                                </div>
                            </th>
                            <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400">
                                <div class="flex">
                                    <span class="mx-2 whitespace-nowrap">Items & Specs</span>
                                    <a class="invisible my-auto"
                                        href="{{ route('inventory.list', ['sort' => 'items_specs', 'direction' => ($direction == 'asc' && $sort == 'items_specs') ? 'desc' : 'asc']) }}">
                                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 7.5 7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5" />
                                        </svg>
                                    </a>
                                </div>
                            </th>
                            <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400">
                                <div class="flex">
                                    <span class="mx-2 whitespace-nowrap">Brand</span>
                                    <a class="invisible my-auto"
                                        href="{{ route('inventory.list', ['sort' => 'brand_name', 'direction' => ($direction == 'asc' && $sort == 'brand_name') ? 'desc' : 'asc']) }}">
                                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 7.5 7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5" />
                                        </svg>
                                    </a>
                                </div>
                            </th>
                            <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400">
                                <div class="flex">
                                    <span class="mx-2 whitespace-nowrap">Quantity</span>
                                    <a class="invisible my-auto"
                                        href="{{ route('inventory.list', ['sort' => 'quantity', 'direction' => ($direction == 'asc' && $sort == 'quantity') ? 'desc' : 'asc']) }}">
                                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 7.5 7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5" />
                                        </svg>
                                    </a>
                                </div>
                            </th>
                            <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400">
                                <div class="flex">
                                    <span class="mx-2 whitespace-nowrap">Unit</span>
                                    <a class="invisible my-auto"
                                        href="{{ route('inventory.list', ['sort' => 'unit', 'direction' => ($direction == 'asc' && $sort == 'unit') ? 'desc' : 'asc']) }}">
                                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 7.5 7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5" />
                                        </svg>
                                    </a>
                                </div>
                            </th>
                            <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400">
                                <div class="flex">
                                    <span class="mx-2 whitespace-nowrap">Unit Price</span>
                                    <a class="invisible my-auto"
                                        href="{{ route('inventory.list', ['sort' => 'unit_price', 'direction' => ($direction == 'asc' && $sort == 'unit_price') ? 'desc' : 'asc']) }}">
                                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 7.5 7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5" />
                                        </svg>
                                    </a>
                                </div>
                            </th>
                            <!-- <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400">
                                <div class="flex">
                                    <span class="mx-2 whitespace-nowrap">Supplier</span>
                                    <a class="invisible my-auto"
                                        href="{{ route('inventory.list', ['sort' => 'supplier_name', 'direction' => ($direction == 'asc' && $sort == 'supplier_name') ? 'desc' : 'asc']) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 7.5 7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5" />
                                        </svg>
                                    </a>
                                </div>
                            </th> -->
                            <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400">
                                <div class="flex">
                                    <span class="mx-2 whitespace-nowrap">Total Item Price</span>
                                    <a class="invisible my-auto"
                                        href="{{ route('inventory.list', ['sort' => 'total_item_price', 'direction' => ($direction == 'asc' && $sort == 'total_item_price') ? 'desc' : 'asc']) }}">
                                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 7.5 7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5" />
                                        </svg>
                                    </a>
                                </div>
                            </th>
                            <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400 text-center">
                                Action
                            </th>
                        </tr>
                    <tbody>
                        @foreach($inventories as $inventory)
                            <tr class="hover:bg-slate-100">
                                <td class="border border-slate-300 px-4 py-2">{{ $inventory->unique_tag }}</td>
                                <td class="border border-slate-300 px-4 py-2">{{ $inventory->items_specs }}</td>
                                <td class="border border-slate-300 px-4 py-2">{{ $inventory->brand->brand }}</td>
                                <td class="border border-slate-300 px-4 py-2">{{ $inventory->quantity }}</td>
                                <td class="border border-slate-300 px-4 py-2">{{ $inventory->unit->unit }}</td>
                                <td class="border border-slate-300 px-4 py-2">{{ $inventory->unit_price }}</td>
                                <!-- <td class="border border-slate-300 px-4 py-2">{{ $inventory->supplier_name }}</td> -->
                                <td class="border border-slate-300 px-4 py-2">
                                    {{ number_format($inventory->quantity * $inventory->unit_price, 2) }}
                                </td>
                                <td class="border border-slate-300 px-4 py-2">
                                    <div class="mx-auto flex justify-center space-x-2">
                                        <a href="{{ route('inventory.view', ['id' => $inventory->id]) }}"
                                            class="text-green-600 hover:text-green-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('inventory.stock.in.edit', ['id' => $inventory->id]) }}"
                                            class="text-blue-600 hover:text-blue-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>

                                        </a>
                                        <button type="button" class="text-red-600 hover:text-red-900"
                                            onclick="document.getElementById('delete-inventory-modal{{ $inventory->id }}').classList.toggle('hidden')">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
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

@include('layouts.modals.inventory.deleteInventory')
<script src="{{ asset('js/chart.js') }}"></script>
<script>
    function clearSearch() {
        document.querySelector('input[name="search"]').value = '';
        document.querySelector('form').submit();
    }

</script>
<script>
    function clearSearch() {
        document.querySelector('input[name="search"]').value = '';
        document.querySelector('form').submit();
    }
</script>
<script>
    window.onload = function () {
        const urlParams = new URLSearchParams(window.location.search);
        if (window.performance.navigation.type === 1 && urlParams.has('search')) {
            window.location.href = "{{ route('inventory.list') }}";
        }
    };
</script>
<script>
    document.querySelector('select[name="brand"]').addEventListener('change', function () {
    document.getElementById('searchboxForm').submit();
});

</script>
@endsection
