@extends('layouts.layout')
@section('content')
<link rel="stylesheet" href="{{ asset('css/viewAsset.css') }}">
<link rel="stylesheet" href="{{ asset('css/asset.css') }}">

<div class="grid grid-cols-6">
    @include('layouts.sidebar')
    <div class="content min-h-screen bg-slate-200 col-span-5">
        <nav class="bg-white flex justify-between py-3 px-4 m-3 shadow-md rounded-md">
            <a href="{{ url()->previous() }}" class="mr-4 hover:bg-gray-100 my-auto p-2 rounded-full transition">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
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
        <div class="bg-white p-5 shadow-md m-3 rounded-md">
                <div class="p-3">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Asset Details</h2>
                        <!-- Asset Image -->
                        <div class="space-y-1 inline-block border-2 border-gray-300 shadow-md rounded-lg bg-slate-50">
                            <div class="w-16 h-16 rounded-lg overflow-hidden bg-gray-100">
                                @if($asset->asset_image)
                                    <img src="{{ asset($asset->asset_image) }}" alt="Asset Image" 
                                        class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                                            stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-gray-400">
                                            <path stroke-linecap="round" stroke-linejoin="round" 
                                                d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Asset Basic Info - Wrapped in styled container -->
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm border border-gray-200 space-y-4">
                            <div class="flex items-center gap-2 border-b pb-2 border-gray-200 bg-gray-100 -m-4 mb-4 p-4 rounded-t-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-blue-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                </svg>
                                <h3 class="text-lg font-semibold text-gray-800">Basic Information</h3>
                            </div>
                            <div class="grid grid-cols-2 gap-x-4 gap-y-3"> {{-- Use 2 columns inside the block --}}
                                <div class="space-y-1">
                                    <label class="text-xs font-medium text-gray-500 uppercase">Asset Tag ID</label>
                                    <p class="text-sm font-semibold text-gray-900">{{ $asset->asset_tag_id }}</p> {{-- Increased font weight --}}
                                </div>
                                <div class="space-y-1">
                                    <label class="text-xs font-medium text-gray-500 uppercase">Model</label>
                                    <p class="text-sm font-semibold text-gray-900">{{ $asset->model }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-xs font-medium text-gray-500 uppercase">Serial Number</label>
                                    <p class="text-sm font-semibold text-gray-900">{{ $asset->serial_number }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-xs font-medium text-gray-500 uppercase">Cost</label>
                                    <p class="text-sm font-semibold text-gray-900">₱{{ number_format($asset->cost, 2) }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-xs font-medium text-gray-500 uppercase">Category</label>
                                    <p class="text-sm font-semibold text-gray-900">{{ $asset->category->category }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-xs font-medium text-gray-500 uppercase">Brand</label>
                                    <p class="text-sm font-semibold text-gray-900">{{ $asset->brand->brand }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-xs font-medium text-gray-500 uppercase">Supplier</label>
                                    <p class="text-sm font-semibold text-gray-900">{{ $asset->supplier->supplier }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-xs font-medium text-gray-500 uppercase">Purchase Date</label>
                                    <p class="text-sm font-semibold text-gray-900">{{ date('F j, Y', strtotime($asset->purchase_date)) }}</p>
                                </div>
                                <div class="space-y-1 col-span-2"> {{-- Span full width --}}
                                    <label class="text-xs font-medium text-gray-500 uppercase">Specifications</label>
                                    <p class="text-sm font-semibold text-gray-900">{{ $asset->specs }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Depreciation Information - Wrapped in styled container -->
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm border border-gray-200 space-y-4">
                            <div class="flex items-center gap-2 border-b pb-2 border-gray-200 bg-gray-100 -m-4 mb-4 p-4 rounded-t-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-blue-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                <h3 class="text-lg font-semibold text-gray-800">Depreciation Details</h3>
                            </div>
                            <div class="grid grid-cols-2 gap-x-4 gap-y-3"> {{-- Use 2 columns inside the block --}}
                                <div class="space-y-1">
                                    <label class="text-xs font-medium text-gray-500 uppercase">Current Value</label>
                                    <p class="text-sm font-semibold text-gray-900">₱{{ number_format($asset->current_value, 2) }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-xs font-medium text-gray-500 uppercase">Depreciated Amount</label>
                                    <p class="text-sm font-semibold text-gray-900">₱{{ number_format($asset->cost - $asset->current_value, 2) }}</p>
                                </div>
                                <div class="space-y-1 col-span-2">
                                    <label class="text-xs font-medium text-gray-500 uppercase">Depreciation Rate</label>
                                    <p class="text-sm font-semibold text-gray-900">20% per year (5-year straight-line)</p>
                                </div>
                                <div class="space-y-1 col-span-2">
                                    <label class="text-xs font-medium text-gray-500 uppercase">Time Elapsed</label>
                                    <p class="text-sm font-semibold text-gray-900">
                                        {{ $asset->months_elapsed }} months
                                        @if($asset->months_elapsed < 60)
                                            ({{ 60 - $asset->months_elapsed }} months left)
                                        @else
                                            (Fully depreciated)
                                        @endif
                                    </p>
                                </div>
                                <div class="relative pt-1 col-span-2">
                                    <label class="text-xs font-medium text-gray-500 uppercase">Depreciation Progress</label>
                                    <div class="overflow-hidden h-2 mt-1 text-xs flex rounded bg-gray-300">
                                        <div style="width:{{ min(($asset->months_elapsed / 60) * 100, 100) }}%"
                                            class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500 transition-all duration-500">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Asset Location - Wrapped in styled container -->
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm border border-gray-200 space-y-4">
                            <div class="flex items-center gap-2 border-b pb-2 border-gray-200 bg-gray-100 -m-4 mb-4 p-4 rounded-t-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-blue-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                </svg>
                                <h3 class="text-lg font-semibold text-gray-800">Location Details</h3>
                            </div>
                            <div class="grid grid-cols-1 gap-y-3"> {{-- Single column layout --}}
                                <div class="space-y-1">
                                    <label class="text-xs font-medium text-gray-500 uppercase">Site</label>
                                    <p class="text-sm font-semibold text-gray-900">{{ $asset->site->site }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-xs font-medium text-gray-500 uppercase">Location</label>
                                    <p class="text-sm font-semibold text-gray-900">{{ $asset->location->location }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-xs font-medium text-gray-500 uppercase">Department</label>
                                    <p class="text-sm font-semibold text-gray-900">{{ $asset->department->department }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Asset Status - Wrapped in styled container -->
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm border border-gray-200 space-y-4">
                            <div class="flex items-center gap-2 border-b pb-2 border-gray-200 bg-gray-100 -m-4 mb-4 p-4 rounded-t-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-blue-600">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                                </svg>
                                <h3 class="text-lg font-semibold text-gray-800">Status Information</h3>
                            </div>
                            <div class="gap-x-4 gap-y-3"> {{-- Use 2 columns inside the block --}}
                                <div class="space-y-1">
                                    <label class="text-xs font-medium text-gray-500 uppercase">Status</label>
                                    <p class="text-sm font-medium">
                                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{-- Adjusted padding --}}
                                            @if($asset->status_id == 1) bg-green-100 text-green-800 border border-green-200
                                            @elseif($asset->status_id == 2) bg-yellow-100 text-yellow-800 border border-yellow-200
                                            @else bg-red-100 text-red-800 border border-red-200
                                            @endif">
                                            {{ $asset->status->status }}
                                        </span>
                                    </p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-xs font-medium text-gray-500 uppercase">Condition</label>
                                    <p class="text-sm font-medium">
                                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{-- Adjusted padding --}}
                                            @if($asset->condition_id == 1) bg-green-100 text-green-800 border border-green-200
                                            @elseif($asset->condition_id == 2) bg-yellow-100 text-yellow-800 border border-yellow-200
                                            @else bg-red-100 text-red-800 border border-red-200
                                            @endif">
                                            {{ $asset->condition->condition }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Assignment Details - Wrapped in styled container -->
                        <div
                            class="bg-gray-50 p-4 rounded-lg shadow-sm border border-gray-200 space-y-4 md:col-span-2">
                            <div class="flex items-center gap-2 border-b pb-2 border-gray-200 bg-gray-100 -m-4 mb-4 p-4 rounded-t-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-blue-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                                <h3 class="text-lg font-semibold text-gray-800">Assignment Details</h3>
                            </div>
                            <div class="grid grid-cols-1 gap-y-3"> {{-- Single column layout --}}
                                <div class="space-y-1">
                                    <label class="text-xs font-medium text-gray-500 uppercase">Assigned To</label>
                                    <p class="text-sm font-semibold text-gray-900">{{ $asset->assigned_to ?? 'Not Assigned' }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-xs font-medium text-gray-500 uppercase">Date Issued</label>
                                    <p class="text-sm font-semibold text-gray-900">{{ $asset->issued_date ? date('F j, Y', strtotime($asset->issued_date)) : 'Not Set' }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-xs font-medium text-gray-500 uppercase">Date Returned</label>
                                    <p class="text-sm font-semibold text-gray-900">{{ $asset->return_date ? date('F j, Y', strtotime($asset->return_date)) : 'Not Set' }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-xs font-medium text-gray-500 uppercase">Notes</label>
                                    <div class="rounded-md border border-gray-300 bg-white p-3 max-h-40 overflow-y-auto shadow-inner">
                                        @if($asset->notes)
                                            <div class="whitespace-pre-wrap text-sm font-medium text-gray-800 font-mono">{{ $asset->notes }}</div>
                                        @else
                                            <p class="text-sm text-gray-500 italic">No notes available</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                    </div>
                </div>
                <div class="flex gap-3 justify-end mt-6 border-t border-gray-200 pt-4">
                    @if(Auth::user()->role->role != 'Department')
                        <a href="{{ route('asset.qrCode', $asset->id) }}" class="rounded-md shadow-md px-5 py-2 bg-blue-600 hover:shadow-md hover:bg-blue-500 transition-all
                            duration-200 hover:scale-105 ease-in hover:shadow-inner text-white flex gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 3.75 9.375v-4.5ZM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 0 1-1.125-1.125v-4.5ZM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 0 1-1.125-1.125v-4.5Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75ZM6.75 16.5h.75v.75h-.75v-.75ZM16.5 6.75h.75v.75h-.75v-.75ZM13.5 13.5h.75v.75h-.75v-.75ZM13.5 19.5h.75v.75h-.75v-.75ZM19.5 13.5h.75v.75h-.75v-.75ZM19.5 19.5h.75v.75h-.75v-.75ZM16.5 16.5h.75v.75h-.75v-.75Z" />
                            </svg>
                            Generate Asset Tag
                        </a>
                        @if($asset->assigned_to)
                            <!-- Return Asset Button triggers modal -->
                            <button type="button" onclick="document.getElementById('return-modal').classList.remove('hidden')"
                                class="rounded-md shadow-md px-5 py-2 bg-red-600 hover:shadow-md hover:bg-red-500 transition-all
                                duration-200 hover:scale-105 ease-in hover:shadow-inner text-white flex gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                </svg>
                                Return Asset
                            </button>
                        @endif
                    @endif
                </div>
            </div>
            
        @if($turnoverHistory->isNotEmpty())
            <div class="bg-white p-6 shadow-lg m-3 rounded-lg">
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-purple-600" fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor" >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        <h2 class="text-2xl font-bold text-gray-800">Turnover History</h2>
                    </div>
                    <span class="text-sm text-gray-500">Showing latest turnovers</span>
                </div>
                <div class="overflow-hidden rounded-lg border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Turned Over By
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Transferred To
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Notes
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($turnoverHistory as $history)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap align-top text-sm text-gray-500">
                                        <div>
                                            {{ $history->previous_assignee }}
                                            @if($history->assignment_start_date)
                                                <div class="flex items-center gap-1 text-xs text-gray-500 mt-0.5">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-gray-400">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                                    </svg>
                                                    {{ $history->assignment_start_date->format('M d, Y') }} – {{ $history->turnover_date->format('M d, Y') }}
                                                </div>
                                            @else
                                                <div class="flex items-center gap-1 text-xs text-gray-400 mt-0.5 italic">
                                                    N/A
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap align-top text-sm">
                                        <div class="flex flex-col gap-1">
                                            <div class="flex items-center gap-2">
                                                @if($loop->last && $history->new_assignee === $asset->assigned_to)
                                                    <span class="text-green-600 font-semibold">
                                                        {{ $history->new_assignee }}
                                                    </span>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full border border-blue-300 bg-blue-50 shadow-sm text-xs font-bold uppercase text-blue-700 ml-1">
                                                        <svg class="w-3 h-3 mr-1 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M10 2a8 8 0 100 16 8 8 0 000-16zm1 11H9v-2h2v2zm0-4H9V7h2v2z"/>
                                                        </svg>
                                                        Current Owner
                                                    </span>
                                                @else
                                                    <span>
                                                        {{ $history->new_assignee }}
                                                    </span>
                                                @endif
                                            </div>
                                            @if($history->turnover_date)
                                                <div class="flex items-center gap-1 text-xs text-gray-500 mt-0.5">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-gray-400">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                                    </svg>
                                                    Assigned: {{ $history->turnover_date->format('M d, Y') }}
                                                </div>
                                            @else
                                                <div class="flex items-center gap-1 text-xs text-gray-400 mt-0.5 italic">
                                                    N/A
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $history->notes ?? 'No notes provided' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 flex items-center justify-between px-4">
                    <div class="flex items-center gap-2">
                        <a href="{{ $turnoverHistory->url(1) }}" class="p-2 inline-flex items-center justify-center rounded-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M15.707 15.707a1 1 0 01-1.414 0l-5-5a1 1 0 010-1.414l5-5a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 010 1.414zm-6 0a1 1 0 01-1.414 0l-5-5a1 1 0 010-1.414l5-5a1 1 0 011.414 1.414L5.414 10l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="{{ $turnoverHistory->previousPageUrl() }}" class="p-2 inline-flex items-center justify-center rounded-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12.707 15.707a1 1 0 01-1.414 0l-5-5a1 1 0 010-1.414l5-5a1 1 0 011.414 1.414L8.414 10l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                    
                    <div class="text-sm text-gray-700">
                        <span>Showing</span>
                        <span class="font-medium">{{ $turnoverHistory->firstItem() ?? 0 }}</span>
                        <span>to</span>
                        <span class="font-medium">{{ $turnoverHistory->lastItem() ?? 0 }}</span>
                        <span>of</span>
                        <span class="font-medium">{{ $turnoverHistory->total() }}</span>
                        <span>results</span>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="{{ $turnoverHistory->nextPageUrl() }}" class="p-2 inline-flex items-center justify-center rounded-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 15.707a1 1 0 001.414 0l5-5a1 1 0 000-1.414l-5-5a1 1 0 00-1.414 1.414L10.586 10l-4.293 4.293a1 1 0 000 1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="{{ $turnoverHistory->url($turnoverHistory->lastPage()) }}" class="p-2 inline-flex items-center justify-center rounded-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 15.707a1 1 0 001.414 0l5-5a1 1 0 000-1.414l-5-5a1 1 0 00-1.414 1.414L8.586 10l-4.293 4.293a1 1 0 000 1.414zm6 0a1 1 0 001.414 0l5-5a1 1 0 000-1.414l-5-5a1 1 0 00-1.414 1.414L14.586 10l-4.293 4.293a1 1 0 000 1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        @endif
        @if($editHistory->isNotEmpty())
            <div class="bg-white p-6 shadow-lg m-3 rounded-lg">
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" 
                            stroke="currentColor" class="w-6 h-6 text-blue-600">
                            <path stroke-linecap="round" stroke-linejoin="round" 
                                d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <h2 class="text-2xl font-bold text-gray-800">Edit History</h2>
                    </div>
                    <span class="text-sm text-gray-500">Showing latest change</span>
                </div>
                <div class="overflow-hidden rounded-lg border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Modified by
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Changes Made
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($editHistory as $history)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap align-top">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-8 w-8">
                                                @if($history->user->profile_picture)
                                                    <img class="h-8 w-8 rounded-full object-cover" 
                                                        src="{{ asset($history->user->profile_picture) }}" alt="">
                                                @else
                                                    <div class="h-8 w-8 rounded-full bg-blue-600 flex items-center justify-center">
                                                        <span class="text-white text-sm font-medium">
                                                            {{ substr($history->user->first_name, 0, 1) }}{{ substr($history->user->last_name, 0, 1) }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900">
                                                    {{ $history->user->first_name }} {{ $history->user->last_name }}
                                                </p>
                                                <div class="flex items-center gap-1 text-xs text-gray-500 mt-0.5">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                                                        stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-gray-400">
                                                        <path stroke-linecap="round" stroke-linejoin="round" 
                                                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                                    </svg>
                                                    {{ $history->created_at->format('F d, Y g:i A') }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        <div class="">
                                            {!! nl2br($history->changes) !!}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 flex items-center justify-between px-4 mb-3">
                    <div class="flex items-center gap-2">
                        <a href="{{ $editHistory->url(1) }}" class="p-2 inline-flex items-center justify-center rounded-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M15.707 15.707a1 1 0 01-1.414 0l-5-5a1 1 0 010-1.414l5-5a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 010 1.414zm-6 0a1 1 0 01-1.414 0l-5-5a1 1 0 010-1.414l5-5a1 1 0 011.414 1.414L5.414 10l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="{{ $editHistory->previousPageUrl() }}" class="p-2 inline-flex items-center justify-center rounded-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12.707 15.707a1 1 0 01-1.414 0l-5-5a1 1 0 010-1.414l5-5a1 1 0 011.414 1.414L8.414 10l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                    
                    <div class="text-sm text-gray-700">
                        <span>Showing</span>
                        <span class="font-medium">{{ $editHistory->firstItem() ?? 0 }}</span>
                        <span>to</span>
                        <span class="font-medium">{{ $editHistory->lastItem() ?? 0 }}</span>
                        <span>of</span>
                        <span class="font-medium">{{ $editHistory->total() }}</span>
                        <span>results</span>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="{{ $editHistory->nextPageUrl() }}" class="p-2 inline-flex items-center justify-center rounded-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 15.707a1 1 0 001.414 0l5-5a1 1 0 000-1.414l-5-5a1 1 0 00-1.414 1.414L10.586 10l-4.293 4.293a1 1 0 000 1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="{{ $editHistory->url($editHistory->lastPage()) }}" class="p-2 inline-flex items-center justify-center rounded-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 15.707a1 1 0 001.414 0l5-5a1 1 0 000-1.414l-5-5a1 1 0 00-1.414 1.414L8.586 10l-4.293 4.293a1 1 0 000 1.414zm6 0a1 1 0 001.414 0l5-5a1 1 0 000-1.414l-5-5a1 1 0 00-1.414 1.414L14.586 10l-4.293 4.293a1 1 0 000 1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Return Modal -->
<div id="return-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-40">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
        <h2 class="text-lg font-bold mb-4">Return Asset</h2>
        <form action="{{ route('asset.return', $asset->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="return_date" class="block text-sm font-medium text-gray-700 mb-1">Date Returned</label>
                <input type="datetime-local" name="return_date" id="return_date"
                    class="w-full border rounded p-2"
                    value="{{ now()->format('Y-m-d\TH:i') }}" required>
            </div>
            <div class="mb-4">
                <label for="returned_by" class="block text-sm font-medium text-gray-700 mb-1">Returned By</label>
                <input type="text" name="returned_by" id="returned_by"
                    class="w-full border rounded p-2"
                    value="{{ $asset->assigned_to ?? '' }}" required>
            </div>
            <div class="mb-4">
                <label for="condition_id" class="block text-sm font-medium text-gray-700 mb-1">Asset Condition</label>
                <select name="condition_id" id="condition_id" class="w-full border rounded p-2" required>
                    @foreach(\App\Models\Condition::where('condition', '!=', 'Disposed')->orderBy('condition')->get() as $condition)
                        <option value="{{ $condition->id }}" {{ $asset->condition_id == $condition->id ? 'selected' : '' }}>
                            {{ $condition->condition }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="received_by" class="block text-sm font-medium text-gray-700 mb-1">Received By</label>
                <input type="text" name="received_by" id="received_by"
                    class="w-full border rounded p-2" required>
            </div>
            <div class="mb-4">
                <label for="return_notes" class="block text-sm font-medium text-gray-700 mb-1">Remarks / Notes</label>
                <textarea name="return_notes" id="return_notes" rows="3" class="w-full border rounded p-2" placeholder="Enter remarks or notes (optional)"></textarea>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('return-modal').classList.add('hidden')" class="px-4 py-2 bg-gray-200 rounded">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Return</button>
            </div>
        </form>
    </div>
</div>
<script>
    // Optional: Close modal on ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === "Escape") {
            document.getElementById('return-modal').classList.add('hidden');
        }
    });
</script>

<script src="{{ asset('js/chart.js') }}"></script>
 
<script>
    document.addEventListener('DOMContentLoaded', function () {
                // Get the current URL
                var currentUrl = window.location.href;
                // Get all dropdown buttons
                var dropdownButtons = document.querySelectorAll('.relative button');
                            // Loop through each dropdown link
            dropdownLinks.forEach(function (link) {
                // Check if the current URL matches the link's href
                if (currentUrl === link.href) {
                    // Open the dropdown
                    button.click();
                }
            });
        });

</script>

@endsection