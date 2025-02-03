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
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- Asset Basic Info -->
                        <div class="space-y-4">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-blue-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                </svg>
                                <h3 class="text-lg font-semibold text-gray-800">Basic Information</h3>
                            </div>
                            <div class="grid gap-4">
                                <div class="space-y-1">
                                    <label class="text-xs font-medium text-gray-500 uppercase">Asset Tag ID</label>
                                    <p class="text-sm font-medium text-gray-900">{{ $asset->asset_tag_id }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-xs font-medium text-gray-500 uppercase">Model</label>
                                    <p class="text-sm font-medium text-gray-900">{{ $asset->model }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-xs font-medium text-gray-500 uppercase">Serial Number</label>
                                    <p class="text-sm font-medium text-gray-900">{{ $asset->serial_number }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-xs font-medium text-gray-500 uppercase">Specifications</label>
                                    <p class="text-sm font-medium text-gray-900">{{ $asset->specs }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-xs font-medium text-gray-500 uppercase">Cost</label>
                                    <p class="text-sm font-medium text-gray-900">₱{{ number_format($asset->cost, 2) }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-xs font-medium text-gray-500 uppercase">Category</label>
                                    <p class="text-sm font-medium text-gray-900">{{ $asset->category->category }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-xs font-medium text-gray-500 uppercase">Brand</label>
                                    <p class="text-sm font-medium text-gray-900">{{ $asset->brand->brand }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-xs font-medium text-gray-500 uppercase">Supplier</label>
                                    <p class="text-sm font-medium text-gray-900">{{ $asset->supplier->supplier }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-xs font-medium text-gray-500 uppercase">Purchase Date</label>
                                    <p class="text-sm font-medium text-gray-900">{{ date('F j, Y', strtotime($asset->purchase_date)) }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Asset Location -->
                        <div class="space-y-4">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-blue-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm-9-3.75h.008v.008H12V8.25z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                </svg>
                                <h3 class="text-lg font-semibold text-gray-800">Location Details</h3>
                            </div>
                            <div class="grid gap-4">
                                <div class="space-y-1">
                                    <label class="text-xs font-medium text-gray-500 uppercase">Site</label>
                                    <p class="text-sm font-medium text-gray-900">{{ $asset->site->site }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-xs font-medium text-gray-500 uppercase">Location</label>
                                    <p class="text-sm font-medium text-gray-900">{{ $asset->location->location }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-xs font-medium text-gray-500 uppercase">Department</label>
                                    <p class="text-sm font-medium text-gray-900">{{ $asset->department->department }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Assignment Details -->
                        <div class="space-y-4">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-blue-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                                <h3 class="text-lg font-semibold text-gray-800">Assignment Details</h3>
                            </div>
                            <div class="grid gap-4">
                                <div class="space-y-1">
                                    <label class="text-xs font-medium text-gray-500 uppercase">Assigned To</label>
                                    <div class="flex items-center justify-between">
                                        <p class="text-sm font-medium text-gray-900">{{ $asset->assigned_to ?? 'Not Assigned' }}</p>
                                        @if($asset->assigned_to && Auth::user()->role->role != 'Department')
                                            <form action="{{ route('asset.return', $asset->id) }}" method="POST" class="ml-4">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="flex items-center gap-1 px-3 py-1 text-xs font-medium text-red-600 bg-red-50 rounded-full hover:bg-red-100 transition-colors duration-200">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                                                    </svg>
                                                    Return Asset
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-xs font-medium text-gray-500 uppercase">Date Issued</label>
                                    <p class="text-sm font-medium text-gray-900">{{ $asset->issued_date ? date('F j, Y', strtotime($asset->issued_date)) : 'Not Set' }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-xs font-medium text-gray-500 uppercase">Date Returned</label>
                                    <p class="text-sm font-medium text-gray-900">{{ $asset->return_date ? date('F j, Y', strtotime($asset->return_date)) : 'Not Set' }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-xs font-medium text-gray-500 uppercase">Notes</label>
                                    <p class="text-sm font-medium text-gray-900">{{ $asset->notes ?? 'No notes available' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Asset Status -->
                        <div class="space-y-4">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-blue-600">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                                </svg>
                                <h3 class="text-lg font-semibold text-gray-800">Status Information</h3>
                            </div>
                            <div class="grid gap-4">
                                <div class="space-y-1">
                                    <label class="text-xs font-medium text-gray-500 uppercase">Status</label>
                                    <p class="text-sm font-medium">
                                        <span class="px-4 py-2 rounded-full text-xs font-semibold
                                            @if($asset->status_id == 1) bg-green-100 text-green-800
                                            @elseif($asset->status_id == 2) bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800
                                            @endif">
                                            {{ $asset->status->status }}
                                        </span>
                                    </p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-xs font-medium text-gray-500 uppercase">Condition</label>
                                    <p class="text-sm font-medium">
                                        <span class="px-4 py-2 rounded-full text-xs font-semibold
                                            @if($asset->condition_id == 1) bg-green-100 text-green-800
                                            @elseif($asset->condition_id == 2) bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800
                                            @endif">
                                            {{ $asset->condition->condition }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex">
                            @if(Auth::user()->role->role != 'Department')
                            <a href="{{ route('asset.qrCode', $asset->id) }}" class="rounded-md shadow-md px-5 py-2 bg-blue-600 hover:shadow-md hover:bg-blue-500 transition-all
                                duration-200 hover:scale-105 ml-auto ease-in hover:shadow-inner text-white flex gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 3.75 9.375v-4.5ZM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 0 1-1.125-1.125v-4.5ZM13.5 4.875h.008v.008H12v-.008z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.75 6.75h.75v.75h-.75v-.75ZM6.75 16.5h.75v.75h-.75v-.75ZM16.5 6.75h.75v.75h-.75v-.75ZM13.5 13.5h.75v.75h-.75v-.75ZM13.5 19.5h.75v.75h-.75v-.75ZM19.5 13.5h.75v.75h-.75v-.75ZM19.5 19.5h.75v.75h-.75v-.75ZM16.5 16.5h.75v.75h-.75v-.75Z" />
                                </svg>
                                Generate Asset Tag
                            </a>
                            @endif
                        </div>
            </div>
            
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
                                    Date & Time
                                </th>
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
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        <div class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                                                stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-gray-400">
                                                <path stroke-linecap="round" stroke-linejoin="round" 
                                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                            </svg>
                                            {{ $history->created_at->format('Y-m-d H:i:s') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
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
                                <path fill-rule="evenodd" d="M15.707 15.707a1 1 0 01-1.414 0l-5-5a1 1 0 010-1.414l5-5a1 1 0 011.414 1.414L11.414 10l4.293 4.293a1 1 0 010 1.414zm-6 0a1 1 0 01-1.414 0l-5-5a1 1 0 010-1.414l5-5a1 1 0 011.414 1.414L5.414 10l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
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
    });

</script>

@endsection