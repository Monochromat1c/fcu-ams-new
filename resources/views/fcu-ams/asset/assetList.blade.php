@extends('layouts.layout')
@section('content')
<link rel="stylesheet" href="{{ asset('css/asset.css') }}">

<div x-data="{ sidebarOpen: true }" class="grid grid-cols-6">
    <div x-show="sidebarOpen" class="col-span-1">
        @include('layouts.sidebar')
    </div>
    <div :class="{ 'col-span-5': sidebarOpen, 'col-span-6': !sidebarOpen }" class="bg-slate-200 content min-h-screen">
    <nav class="bg-white flex justify-between py-3 px-4 m-3 shadow-md rounded-md">
    <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>
            <h1 class="my-auto text-3xl">Asset</h1>
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex gap-3 focus:outline-none" style="min-width:100px;">
                    <div>
                         @if(auth()->user()->profile_picture)
                            <img src="{{ asset(auth()->user()->profile_picture) }}" alt="User Profile"
                                class="w-14 h-14 object-cover bg-no-repeat rounded-full mx-auto">
                        @else
                            <img src="{{ asset('profile/defaultProfile.png') }}" alt="Default Image"
                                class="w-14 h-14 object-cover bg-no-repeat rounded-full mx-auto">
                        @endif
                    </div>
                     
                </button>
                <div x-show="open" 
                    @click.away="open = false"
                    class="absolute right-0 mt-4 w-72 bg-white rounded-lg shadow-xl border border-gray-200 z-50">
                    <div class="p-4 border-b border-gray-100 rounded-t-lg bg-gradient-to-r from-gray-100 to-gray-200">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                @if(auth()->user()->profile_picture)
                                    <img src="{{ asset(auth()->user()->profile_picture) }}" alt="User Profile"
                                        class="w-12 h-12 rounded-full object-cover ring-2 ring-blue-500">
                                @else
                                    <img src="{{ asset('profile/defaultProfile.png') }}" alt="Default Profile"
                                        class="w-12 h-12 rounded-full object-cover ring-2 ring-blue-500">
                                @endif
                            </div>
                            <div class="ml-3 flex-grow">
                                <div class="font-semibold text-base text-gray-800">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</div>
                                <div class="text-sm text-gray-600">{{ auth()->user()->email }}</div>
                            </div>
                            <a href="{{ route('profile.index') }}" class="ml-2 p-1 hover:bg-gray-100 rounded-full transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 hover:text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                    <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="divide-y divide-gray-200">
                        <div class="flex items-center px-4 py-3.5 text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
                            </svg>
                            <p class="font-medium">Role</p>
                            <p class="ml-auto text-gray-600">{{ auth()->user()->role->role }}</p>
                        </div>
                        <div class="flex items-center px-4 py-3.5 text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                            <span class="font-medium">Username</span>
                            <span class="ml-auto text-gray-600">{{ auth()->user()->username }}</span>
                        </div>
                        <button onclick="document.getElementById('logout-modal').classList.toggle('hidden')"
                            class="flex items-center px-4 py-3.5 text-red-600 hover:bg-red-50 w-full text-left transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" />
                            </svg>
                            <span class="font-medium">Logout</span>
                        </button>
                    </div>
                </div>
            </div>
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
                @if(Auth::user()->role->role != 'Department')
                <div class="import-list my-auto">
                    <button type="button" onclick="document.getElementById('importModal').classList.remove('hidden')"
                        class="flex gap-2 items-center bg-green-600 text-white hover:scale-105 transition-all duration-200 ease-in rounded-md px-4 p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                        </svg>
                        Import Excel
                    </button>
                </div>

                <!-- Import Modal -->
                <div id="importModal"
                    class="fixed inset-0 flex items-center justify-center z-50 hidden backdrop-blur-sm">
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-50 transition-opacity duration-300"></div>
                    <div
                        class="bg-white rounded-xl shadow-2xl p-8 w-11/12 md:w-2/3 lg:w-1/2 max-h-[85vh] overflow-y-auto relative z-50 transform transition-all duration-300">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-2xl font-bold text-gray-800">Import Asset Data</h2>
                            <button type="button"
                                onclick="document.getElementById('importModal').classList.add('hidden')"
                                class="text-gray-400 hover:text-gray-500 transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <form action="{{ route('inventory.asset.import') }}" method="POST"
                            enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            <div class="space-y-4">
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                    <h3 class="text-lg font-semibold text-blue-800 mb-2">Import Instructions</h3>
                                    <ul class="list-disc list-inside space-y-2 text-blue-700">
                                        <li>File must be in Excel format (CSV, XLSX, XLS)</li>
                                        <li>Maximum file size is 2MB</li>
                                        <li>
                                            Required columns: `asset_tag_id`, `model`, `serial_number`, `cost`, `supplier`, `brand`, `site`, `location`, `category`, `department`, `purchase_date`
                                        </li>
                                        <li>
                                            Optional columns: `specs`, `assigned_to`, `issued_date`, `notes`, `condition`, `status`
                                        </li>
                                        <li>Ensure column headers in your file match these names exactly.</li>
                                        <li>Date format: YYYY-MM-DD or MM/DD/YYYY.</li>
                                    </ul>
                                </div>

                                <div class="relative border-2 border-gray-300 border-dashed rounded-lg p-6 text-center">
                                    <input type="file" name="file" id="file" accept=".csv,.xlsx,.xls"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                    <div class="space-y-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                        <div class="text-sm text-gray-600">
                                            <label for="file"
                                                class="relative cursor-pointer rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                <span>Upload a file</span>
                                            </label>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">CSV, XLSX, XLS up to 2MB</p>
                                    </div>
                                    <div id="file-name" class="mt-2 text-sm text-gray-600"></div>
                                </div>
                            </div>

                            <div class="flex justify-end gap-4 pt-6 border-t border-gray-200">
                                <button type="button"
                                    onclick="document.getElementById('importModal').classList.add('hidden')"
                                    class="px-6 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 transition-all duration-200">
                                    Cancel
                                </button>
                                <button type="submit"
                                    class="px-6 py-2.5 bg-blue-600 text-white rounded-lg shadow-sm hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                                    Import Data
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
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
                    <div id="filterModal" class="fixed inset-0 flex items-center justify-center z-50 hidden backdrop-blur-sm">
                        <div class="fixed inset-0 bg-gray-500 bg-opacity-50 transition-opacity duration-300"></div>
                        <div class="bg-white rounded-xl shadow-2xl p-8 w-11/12 md:w-2/3 lg:w-1/2 max-h-[85vh] overflow-y-auto relative z-50 transform transition-all duration-300">
                            <div class="flex justify-between items-center mb-6">
                                <h2 class="text-2xl font-bold text-gray-800">Filter Assets</h2>
                                <button type="button" onclick="document.getElementById('filterModal').classList.add('hidden')" 
                                    class="text-gray-400 hover:text-gray-500 transition-colors duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            <form id="filterForm" action="{{ route('asset.list') }}" method="GET" class="space-y-6">
                                <!-- Condition Filter -->
                                <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Conditions</h3>
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                        @foreach($allConditions as $condition)
                                            <label
                                                class="inline-flex items-center hover:bg-gray-100 p-2 rounded-lg transition-colors duration-200">
                                                <input type="checkbox" name="conditions[]"
                                                    value="{{ $condition->id }}"
                                                    class="form-checkbox h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500"
                                                    {{ in_array($condition->id, $selectedConditions) ? 'checked' : '' }}>
                                                <span class="ml-3 text-gray-700">{{ $condition->condition }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Status Filter -->
                                <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Statuses</h3>
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                        @foreach($allStatuses as $status)
                                            <label
                                                class="inline-flex items-center hover:bg-gray-100 p-2 rounded-lg transition-colors duration-200">
                                                <input type="checkbox" name="statuses[]" value="{{ $status->id }}"
                                                    class="form-checkbox h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500"
                                                    {{ in_array($status->id, $selectedStatuses) ? 'checked' : '' }}>
                                                <span class="ml-3 text-gray-700">{{ $status->status }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            
                                <!-- Categories Filter -->
                                <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Categories</h3>
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                        @foreach($allCategories as $cat)
                                            <label class="inline-flex items-center hover:bg-gray-100 p-2 rounded-lg transition-colors duration-200">
                                                <input type="checkbox" name="categories[]" value="{{ $cat->id }}"
                                                    class="form-checkbox h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500"
                                                    {{ in_array($cat->id, $selectedCategories) ? 'checked' : '' }}>
                                                <span class="ml-3 text-gray-700">{{ $cat->category }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Departments Filter -->
                                <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Departments</h3>
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                        @foreach($allDepartments as $dept)
                                            <label class="inline-flex items-center hover:bg-gray-100 p-2 rounded-lg transition-colors duration-200">
                                                <input type="checkbox" name="departments[]" value="{{ $dept->id }}"
                                                    class="form-checkbox h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500"
                                                    {{ in_array($dept->id, $selectedDepartments) ? 'checked' : '' }}>
                                                <span class="ml-3 text-gray-700">{{ $dept->department }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Locations Filter -->
                                <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Locations</h3>
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                        @foreach($allLocations as $loc)
                                            <label class="inline-flex items-center hover:bg-gray-100 p-2 rounded-lg transition-colors duration-200">
                                                <input type="checkbox" name="locations[]" value="{{ $loc->id }}"
                                                    class="form-checkbox h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500"
                                                    {{ in_array($loc->id, $selectedLocations) ? 'checked' : '' }}>
                                                <span class="ml-3 text-gray-700">{{ $loc->location }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Sites Filter -->
                                <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Sites</h3>
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                        @foreach($allSites as $site_item)
                                            <label class="inline-flex items-center hover:bg-gray-100 p-2 rounded-lg transition-colors duration-200">
                                                <input type="checkbox" name="sites[]" value="{{ $site_item->id }}"
                                                    class="form-checkbox h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500"
                                                    {{ in_array($site_item->id, $selectedSites) ? 'checked' : '' }}>
                                                <span class="ml-3 text-gray-700">{{ $site_item->site }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Suppliers Filter -->
                                <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Suppliers</h3>
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                        @foreach($allSuppliers as $sup)
                                            <label class="inline-flex items-center hover:bg-gray-100 p-2 rounded-lg transition-colors duration-200">
                                                <input type="checkbox" name="suppliers[]" value="{{ $sup->id }}"
                                                    class="form-checkbox h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500"
                                                    {{ in_array($sup->id, $selectedSuppliers) ? 'checked' : '' }}>
                                                <span class="ml-3 text-gray-700">{{ $sup->supplier }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Brands Filter -->
                                <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Brands</h3>
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                        @foreach($allBrands as $brand)
                                            <label class="inline-flex items-center hover:bg-gray-100 p-2 rounded-lg transition-colors duration-200">
                                                <input type="checkbox" name="brands[]" value="{{ $brand->id }}"
                                                    class="form-checkbox h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500"
                                                    {{ in_array($brand->id, $selectedBrands) ? 'checked' : '' }}>
                                                <span class="ml-3 text-gray-700">{{ $brand->brand }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Modal Actions -->
                                <div class="flex justify-end gap-4 pt-6 border-t border-gray-200">
                                    <button type="button" 
                                        onclick="document.getElementById('filterModal').classList.add('hidden')"
                                        class="px-6 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 transition-all duration-200">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                        class="px-6 py-2.5 bg-blue-600 text-white rounded-lg shadow-sm hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                                        Apply Filters
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <div class="relative flex-1">
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="w-full rounded-md border-0 py-2 pl-2 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6"
                                placeholder="Search for assets..." id="searchInput">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
                                    class="w-5 h-5 text-gray-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                </svg>
                            </div>
                        </div>
                        <button type="button" onclick="window.location.href='{{ route('asset.list') }}'"
                            class="flex gap-1 items-center bg-red-600 text-white hover:scale-105 transition-all duration-200 ease-in rounded-md px-4 p-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                            Clear
                        </button>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto overflow-y-auto rounded-lg border-2 border-slate-300">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th scope="col" class="px-6 py-3 bg-gradient-to-r from-blue-400 to-blue-400 text-white text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <span>Asset Tag ID</span>
                                    <a class="ml-2" href="{{ route('asset.list', ['sort' => 'asset_tag_id', 'direction' => ($direction == 'asc' && $sort == 'asset_tag_id') ? 'desc' : 'asc']) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                        </svg>
                                    </a>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 bg-gradient-to-r from-blue-400 to-blue-400 text-white text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <span>Assigned To</span>
                                    <a class="ml-2" href="{{ route('asset.list', ['sort' => 'assigned_to', 'direction' => ($direction == 'asc' && $sort == 'assigned_to') ? 'desc' : 'asc']) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                        </svg>
                                    </a>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 bg-gradient-to-r from-blue-400 to-blue-400 text-white text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <span>Cost</span>
                                    <a class="ml-2" href="{{ route('asset.list', ['sort' => 'cost', 'direction' => ($direction == 'asc' && $sort == 'cost') ? 'desc' : 'asc']) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                        </svg>
                                    </a>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 bg-gradient-to-r from-blue-400 to-blue-400 text-white text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <span>Supplier</span>
                                    <a class="ml-2" href="{{ route('asset.list', ['sort' => 'supplier_name', 'direction' => ($direction == 'asc' && $sort == 'supplier_name') ? 'desc' : 'asc']) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                        </svg>
                                    </a>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 bg-gradient-to-r from-blue-400 to-blue-400 text-white text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <span>Category</span>
                                    <a class="ml-2" href="{{ route('asset.list', ['sort' => 'category_name', 'direction' => ($direction == 'asc' && $sort == 'category_name') ? 'desc' : 'asc']) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                        </svg>
                                    </a>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 bg-gradient-to-r from-blue-400 to-blue-400 text-white text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <span>Status</span>
                                    <a class="ml-2" href="{{ route('asset.list', ['sort' => 'status_name', 'direction' => ($direction == 'asc' && $sort == 'status_name') ? 'desc' : 'asc']) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                        </svg>
                                    </a>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 bg-gradient-to-r from-blue-400 to-blue-400 text-white text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <span>Condition</span>
                                    <a class="ml-2" href="{{ route('asset.list', ['sort' => 'condition_name', 'direction' => ($direction == 'asc' && $sort == 'condition_name') ? 'desc' : 'asc']) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                        </svg>
                                    </a>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 bg-gradient-to-r from-blue-400 to-blue-400 text-white text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($assets as $asset)
                            <tr class="hover:bg-gray-50 transition-colors duration-200 cursor-pointer" onclick="window.location.href='{{ route('asset.view', $asset->id) }}'">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $asset->asset_tag_id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $asset->assigned_to ?: 'Not currently assigned' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">₱{{ number_format($asset->cost, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $asset->supplier_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $asset->category_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-6 py-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($asset->status_name == 'Available') bg-green-100 text-green-800 
                                        @elseif($asset->status_name == 'Leased') bg-blue-100 text-blue-800
                                        @else bg-red-100 text-red-800 
                                        @endif">
                                        {{ $asset->status_name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-sm leading-5 font-semibold rounded-full">
                                        {{ $asset->condition_name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center" onclick="event.stopPropagation();">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ route('asset.view', $asset->id) }}" 
                                           class="text-green-600 hover:text-blue-900 hover:scale-110 transition-transform duration-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        @if(Auth::user()->role->role != 'Department')
                                        <a href="{{ route('asset.edit', $asset->id) }}" 
                                           class="text-indigo-600 hover:text-indigo-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <button onclick="document.getElementById('delete-asset-modal{{ $asset->id }}').classList.remove('hidden')"
                                                class="text-red-600 hover:text-red-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                        {{-- Dispose Button --}}
                                        <button onclick="document.getElementById('dispose-asset-modal-{{ $asset->id }}').classList.remove('hidden')"
                                                class="text-orange-600 hover:text-orange-900 transition-transform duration-200"
                                                title="Dispose Asset">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
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
{{-- Add Dispose Modal for each asset --}}
@foreach ($assets as $asset)
<div id="dispose-asset-modal-{{ $asset->id }}" tabindex="-1" aria-hidden="true" class="fixed inset-0 z-50 overflow-y-auto bg-gray-900 bg-opacity-50 backdrop-blur-sm hidden">
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="relative w-full max-w-lg transform overflow-hidden rounded-2xl bg-white shadow-2xl transition-all">
            <form action="{{ route('asset.dispose', $asset->id) }}" method="POST">
                @csrf
                <!-- Header -->
                <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">Dispose Asset: {{ $asset->asset_tag_id }}</h3>
                        <button type="button" class="text-gray-400 hover:text-gray-500" onclick="document.getElementById('dispose-asset-modal-{{ $asset->id }}').classList.add('hidden')">
                            <span class="sr-only">Close</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="p-6 space-y-4">
                    <div>
                        {{-- Label with optional asterisk span --}}
                        <label for="disposed_amount_{{ $asset->id }}" class="block text-sm font-medium text-gray-700">
                            Disposed Amount (₱) <span id="disposed_amount_required_star_{{ $asset->id }}" class="text-red-500 hidden">*</span>
                        </label>
                        <div class="mt-1">
                            {{-- Removed required attribute --}}
                            <input type="number" id="disposed_amount_{{ $asset->id }}" name="disposed_amount" step="0.01" min="0"
                                class="shadow-sm p-2 border focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-2 bg-slate-50 border-gray-300 rounded-md">
                        </div>
                    </div>
                    <div>
                        <label for="disposed_status_id_{{ $asset->id }}" class="block text-sm font-medium text-gray-700">Disposal Status</label>
                        <div class="mt-1">
                            {{-- Add data attribute to fetch status name --}}
                            <select id="disposed_status_id_{{ $asset->id }}" name="disposed_status_id" required
                                    onchange="toggleDisposeAmountRequired({{ $asset->id }})"
                                    class="shadow-sm p-2 border focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-2 bg-slate-50 border-gray-300 rounded-md">
                                <option value="" disabled selected>Select disposal status</option>
                                @foreach($allDisposedStatuses as $disposedStatus)
                                    {{-- Store status text in a data attribute --}}
                                    <option value="{{ $disposedStatus->id }}" data-status-name="{{ $disposedStatus->status }}">
                                        {{ $disposedStatus->status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mt-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M8.485 3.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 3.495zM10 14a1 1 0 110-2 1 1 0 010 2zm0-7a1 1 0 011 1v3a1 1 0 11-2 0V8a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                Disposing this asset will set its condition to 'Disposed' and status to 'Unavailable'. This action cannot be easily undone.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3">
                    <button type="button"
                        class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                        onclick="document.getElementById('dispose-asset-modal-{{ $asset->id }}').classList.add('hidden')">
                        Cancel
                    </button>
                    <button type="submit"
                        class="inline-flex items-center rounded-md border border-transparent bg-orange-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2">
                        Confirm Disposal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

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
    document.addEventListener('DOMContentLoaded', function() {
        // Reset filters on page load/reload
        if (performance.navigation.type === 1) { // Check if it's a page reload
            window.location.href = "{{ route('asset.list') }}";
        }

        const searchInput = document.getElementById('searchInput');
        const tableBody = document.querySelector('tbody'); // Get reference to tbody
        let typingTimer;
        const doneTypingInterval = 300;

        searchInput.addEventListener('input', function() {
            clearTimeout(typingTimer);
            
            // If the search input is empty, reload the page
            if (this.value.trim() === '') {
                window.location.href = "{{ route('asset.list') }}";
                return;
            }
            
            typingTimer = setTimeout(performSearch, doneTypingInterval);
        });

        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
            }
        });

        function performSearch() {
            const searchQuery = searchInput.value;
            
            // Get all active filters
            const conditions = Array.from(document.querySelectorAll('input[name="conditions[]"]:checked')).map(el => el.value);
            const categories = Array.from(document.querySelectorAll('input[name="categories[]"]:checked')).map(el => el.value);
            const statuses = Array.from(document.querySelectorAll('input[name="statuses[]"]:checked')).map(el => el.value);
            const departments = Array.from(document.querySelectorAll('input[name="departments[]"]:checked')).map(el => el.value);
            const brands = Array.from(document.querySelectorAll('input[name="brands[]"]:checked')).map(el => el.value);

            // Create FormData to properly handle array parameters
            const params = new URLSearchParams();
            params.append('search', searchQuery);
            
            conditions.forEach(value => params.append('conditions[]', value));
            categories.forEach(value => params.append('categories[]', value));
            statuses.forEach(value => params.append('statuses[]', value));
            departments.forEach(value => params.append('departments[]', value));
            brands.forEach(value => params.append('brands[]', value));
            
            fetch(`{{ route('asset.search') }}?${params.toString()}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                updateTable(data.assets);
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        function updateTable(assets) {
            tableBody.innerHTML = ''; // Clear existing rows
            
            assets.forEach(asset => {
                const row = document.createElement('tr');
                row.className = 'hover:bg-gray-50 transition-colors duration-200'; // Removed cursor-pointer as row isn't clickable
                // Removed row click handler:
                // row.onclick = () => window.location.href = `/asset/${asset.id}/view`; 
                
                const statusClass = getStatusClass(asset.status_name);
                const userRole = '{{ Auth::user()->role->role }}'; 

                // Define action buttons conditionally using data attributes for delegation
                let actionButtons = '';
                if (userRole !== 'Department') {
                    actionButtons = `
                        <a href="/asset/${asset.id}/edit" class="text-indigo-600 hover:text-indigo-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>
                        <button type="button" class="text-red-600 hover:text-red-900 delete-asset-button" data-asset-id="${asset.id}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                        <button type="button" class="text-orange-600 hover:text-orange-900 transition-transform duration-200 dispose-asset-button" data-asset-id="${asset.id}" title="Dispose Asset">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 pointer-events-none">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                            </svg>
                        </button>
                    `;
                }

                // Set innerHTML for the row (same as before)
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${asset.asset_tag_id}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${asset.assigned_to || 'Not currently assigned'}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">₱${Number(asset.cost).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${asset.supplier_name}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${asset.category_name}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-6 py-2 inline-flex text-xs leading-5 font-semibold rounded-full ${statusClass}">
                            ${asset.status_name}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-sm leading-5 font-semibold rounded-full">
                            ${asset.condition_name}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center"> 
                        <div class="flex justify-center space-x-2">
                            <a href="/asset/${asset.id}/view" class="text-green-600 hover:text-blue-900 hover:scale-110 transition-transform duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                            ${actionButtons} 
                        </div>
                    </td>
                `;
                
                tableBody.appendChild(row);
            });
        }

        // Event Delegation for dynamic buttons (keep existing function)
        tableBody.addEventListener('click', function(event) {
            // ... (rest of event delegation logic remains the same) ...
            const deleteButton = event.target.closest('.delete-asset-button');
            const disposeButton = event.target.closest('.dispose-asset-button');

            if (deleteButton) {
                event.preventDefault(); 
                event.stopPropagation(); 
                const assetId = deleteButton.getAttribute('data-asset-id');
                const modal = document.getElementById(`delete-asset-modal${assetId}`);
                if (modal) {
                    modal.classList.remove('hidden');
                }
            } else if (disposeButton) {
                event.preventDefault();
                event.stopPropagation(); 
                const assetId = disposeButton.getAttribute('data-asset-id');
                const modal = document.getElementById(`dispose-asset-modal-${assetId}`);
                if (modal) {
                    modal.classList.remove('hidden');
                    const amountInput = modal.querySelector(`#disposed_amount_${assetId}`);
                    const statusSelect = modal.querySelector(`#disposed_status_id_${assetId}`);
                    if(amountInput) amountInput.value = '';
                    if(statusSelect) statusSelect.value = '';
                    toggleDisposeAmountRequired(assetId); 
                }
            }
        });

        function getStatusClass(status) {
            // ... (keep existing function) ...
            switch(status) {
                case 'Available':
                    return 'bg-green-100 text-green-800';
                case 'Leased':
                    return 'bg-blue-100 text-blue-800';
                default:
                    return 'bg-red-100 text-red-800';
            }
        }
    });
</script>
<script>
    // File upload handling
    document.addEventListener('DOMContentLoaded', function () {
        const fileInput = document.getElementById('file');
        const fileNameDisplay = document.getElementById('file-name');
        const importModal = document.getElementById('importModal');

        fileInput.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                const fileName = this.files[0].name;
                fileNameDisplay.textContent = `Selected file: ${fileName}`;

                // Validate file size (2MB = 2 * 1024 * 1024 bytes)
                if (this.files[0].size > 2 * 1024 * 1024) {
                    alert('File size exceeds 2MB limit. Please choose a smaller file.');
                    this.value = '';
                    fileNameDisplay.textContent = '';
                }
            } else {
                fileNameDisplay.textContent = '';
            }
        });

        // Close modal when clicking outside
        window.onclick = function (event) {
            if (event.target == importModal) {
                importModal.classList.add('hidden');
                fileInput.value = '';
                fileNameDisplay.textContent = '';
            }
        }
    });
</script>

<script>
    // Function to toggle the 'required' attribute for dispose amount
    function toggleDisposeAmountRequired(assetId) {
        const statusSelect = document.getElementById(`disposed_status_id_${assetId}`);
        const amountInput = document.getElementById(`disposed_amount_${assetId}`);
        const requiredStar = document.getElementById(`disposed_amount_required_star_${assetId}`);
        
        const selectedOption = statusSelect.options[statusSelect.selectedIndex];
        const selectedStatusName = selectedOption ? selectedOption.getAttribute('data-status-name') : null;

        if (selectedStatusName && selectedStatusName.toLowerCase() === 'sold') {
            amountInput.setAttribute('required', 'required');
            requiredStar.classList.remove('hidden');
        } else {
            amountInput.removeAttribute('required');
            requiredStar.classList.add('hidden');
        }
    }

    // Initial check (keep existing function)
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('select[id^="disposed_status_id_"]').forEach(select => {
            const assetId = select.id.split('_').pop();
            toggleDisposeAmountRequired(assetId);
        });
        // ... (keep existing DOMContentLoaded code)
    });
</script>

@endsection
