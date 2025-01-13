@extends('layouts.layout')
@section('content')
<link rel="stylesheet" href="{{ asset('css/addAsset.css') }}">

<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

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
    
            <h1 class="my-auto text-3xl">Alerts Dashboard</h1>
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
        <div class="m-3">
            @include('layouts.messageWithoutTimerForError')
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4 p-4">
            <!-- Expiring Leases -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col">
                <div class="bg-orange-500 text-white p-4 flex items-center">
                    <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0zm-6 9l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                        </path>
                    </svg>
                    <h2 class="text-xl font-bold">Expiring Leases</h2>
                </div>
                <div class="p-4 flex-1">
                    @if($expiringLeases->isEmpty())
                        <p class="text-center text-gray-500">No leases expiring soon.</p>
                    @else
                        <div class="space-y-3">
                            @foreach($expiringLeases as $lease)
                                <div class="border-l-4 border-orange-500 bg-orange-50 p-3 rounded">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="font-semibold">{{ $lease->customer }}</p>
                                            <p class="text-sm text-gray-600">
                                                {{ $lease->assets->count() }}
                                                {{ Str::plural('asset', $lease->assets->count()) }}
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                Expires
                                                {{ \Carbon\Carbon::parse($lease->lease_expiration)->diffForHumans() }}
                                            </p>
                                        </div>
                                        <a href="{{ route('lease.show', $lease->id) }}"
                                            class="text-orange-600 hover:text-orange-800">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                </path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                @if($totalExpiringLeases > 5)
                    <div class="p-4 text-center border-t border-gray-200">
                        <a href="{{ route('alerts.expiring-leases') }}"
                            class="text-orange-600 hover:underline">
                            View All {{ $totalExpiringLeases }} Expiring Leases
                        </a>
                    </div>
                @endif
            </div>

            <!-- Assets Past Maintenance Alert -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col">
                <div class="bg-red-500 text-white p-4 flex items-center">
                    <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                    <h2 class="text-xl font-bold">Maintenance Overdue Assets</h2>
                </div>
                <div class="p-4 flex-1">
                    @if($pastDueAssets->isEmpty())
                        <p class="text-center text-gray-500">No assets past maintenance due date.</p>
                    @else
                        <div class="space-y-3">
                            @foreach($pastDueAssets as $asset)
                                <div class="border-l-4 border-red-500 bg-red-50 p-3 rounded">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="font-semibold">{{ $asset->asset_tag_id }} -
                                                {{ $asset->model }}</p>
                                            <p class="text-sm text-gray-600">
                                                Maintenance Due:
                                                {{ \Carbon\Carbon::parse($asset->maintenance_end_date)->toFormattedDateString() }}
                                            </p>
                                        </div>
                                        <a href="{{ route('asset.show', $asset->id) }}"
                                            class="text-red-600 hover:text-red-800">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                </path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                @if($pastDueCount > 1)
                    <div class="p-4 text-center border-t border-gray-200">
                        <a href="{{ route('alerts.maintenance') }}" class="text-red-600 hover:underline">
                            View All {{ $pastDueCount }} Overdue Assets
                        </a>
                    </div>
                @endif
            </div>

            <!-- Pending Supply Requests -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col">
                <div class="bg-yellow-500 text-white p-4 flex items-center">
                    <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                        </path>
                    </svg>
                    <h2 class="text-xl font-bold">Pending Supply Requests</h2>
                </div>
                <div class="p-4 flex-1">
                    @if($pendingRequests->isEmpty())
                        <p class="text-center text-gray-500">No pending supply requests.</p>
                    @else
                        <div class="space-y-3">
                            @foreach($pendingRequests as $request)
                                <div class="border-l-4 border-yellow-500 bg-yellow-50 p-3 rounded">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="font-semibold">{{ $request->requester }}</p>
                                            <p class="text-sm text-gray-600">
                                                {{ $request->department->department }} - 
                                                {{ $request->items_count }} {{ Str::plural('item', $request->items_count) }}
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                Requested on {{ \Carbon\Carbon::parse($request->request_date)->toFormattedDateString() }}
                                            </p>
                                        </div>
                                        <a href="{{ route('inventory.supply-request.details', ['request_group_id' => $request->request_group_id]) }}"
                                            class="text-yellow-600 hover:text-yellow-800">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                </path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                @if($totalPendingRequests > 5)
                    <div class="p-4 text-center border-t border-gray-200">
                        <a href="{{ route('alerts.pending-requests') }}" class="text-yellow-600 hover:underline">
                            View All {{ $totalPendingRequests }} Pending Requests
                        </a>
                    </div>
                @endif
            </div>

            <!-- Additional Alert Placeholders
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-blue-500 text-white p-4 flex items-center">
                    <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                        </path>
                    </svg>
                    <h2 class="text-xl font-bold">Additional Alerts</h2>
                </div>
                <div class="p-4 text-center text-gray-500">
                    No additional alerts at the moment.
                </div>
            </div> -->
        </div>
    </div>
</div>

<script src="{{ asset('js/chart.js') }}"></script>

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

@endsection