@extends('layouts.layout')
@section('content')
<link rel="stylesheet" href="{{ asset('css/viewAsset.css') }}">
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

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
        <div class="bg-white p-5 shadow-md m-3 rounded-md">
                <div class="p-3">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Asset Details</h2>
                        <div class="flex gap-3">
                            @if(Auth::user()->role->role != 'Viewer')
                            <a href="{{ route('asset.qrCode', $asset->id) }}" class="rounded-md shadow-md px-5 py-2 bg-blue-600 hover:shadow-md hover:bg-blue-500 transition-all
                                duration-200 hover:scale-105 ease-in hover:shadow-inner text-white flex gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 3.75 9.375v-4.5ZM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 0 1-1.125-1.125v-4.5ZM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 13.5 9.375v-4.5Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.75 6.75h.75v.75h-.75v-.75ZM6.75 16.5h.75v.75h-.75v-.75ZM16.5 6.75h.75v.75h-.75v-.75ZM13.5 13.5h.75v.75h-.75v-.75ZM13.5 19.5h.75v.75h-.75v-.75ZM19.5 13.5h.75v.75h-.75v-.75ZM19.5 19.5h.75v.75h-.75v-.75ZM16.5 16.5h.75v.75h-.75v-.75Z" />
                                </svg>
                                Generate Asset Tag
                            </a>
                            @endif
                            <a href="{{ route('asset.list') }}" class="rounded-md shadow-md px-5 py-2 bg-red-600 hover:shadow-md hover:bg-red-500 transition-all duration-200 hover:scale-105 
                                ease-in hover:shadow-inner text-white flex gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                                </svg>
                                Back to Asset List
                            </a>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
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
                                    <p class="text-sm font-medium text-gray-900">{{ $asset->cost }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Asset Location -->
                        <div class="space-y-4">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-blue-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
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
                                <div class="space-y-1">
                                    <label class="text-xs font-medium text-gray-500 uppercase">Supplier</label>
                                    <p class="text-sm font-medium text-gray-900">{{ $asset->supplier->supplier }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Asset Status -->
                        <div class="space-y-4">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-blue-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                                </svg>
                                <h3 class="text-lg font-semibold text-gray-800">Status Information</h3>
                            </div>
                            <div class="grid gap-4">
                                <div class="space-y-1">
                                    <label class="text-xs font-medium text-gray-500 uppercase">Status</label>
                                    <p class="text-sm font-medium">
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold
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
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                                            @if($asset->condition_id == 1) bg-green-100 text-green-800
                                            @elseif($asset->condition_id == 2) bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800
                                            @endif">
                                            {{ $asset->condition->condition }}
                                        </span>
                                    </p>
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
                                    <label class="text-xs font-medium text-gray-500 uppercase">Purchase Date</label>
                                    <p class="text-sm font-medium text-gray-900">{{ $asset->purchase_date }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
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
                <div class="mt-4">
                    {{ $editHistory->links() }}
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