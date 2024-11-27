@extends('layouts.layout')
@section('content')
<link rel="stylesheet" href="{{ asset('css/addAsset.css') }}">

<div class="grid grid-cols-6">
    @include('layouts.sidebar')
    <div class="content min-h-screen bg-slate-100 col-span-5">
        <nav class="bg-white flex justify-between py-3 px-4 m-3 shadow-md rounded-md">
            <div></div>
            <h1 class="my-auto text-3xl">Alerts Dashboard</h1>
            <a href="{{ route('profile.index') }}" class="flex gap-3" style="min-width:100px;">
                <div>
                    @if(auth()->user()->profile_picture)
                        <img src="{{ asset(auth()->user()->profile_picture) }}" alt="User Profile"
                            class="w-14 h-14 object-cover bg-no-repeat rounded-full mx-auto">
                    @else
                        <img src="{{ asset('profile/defaultProfile.png') }}" alt="Default Image"
                            class="w-14 h-14 object-cover bg-no-repeat rounded-full mx-auto">
                    @endif
                </div>
                <p class="my-auto">
                    {{ (auth()->user() ? auth()->user()->first_name . ' ' . auth()->user()->last_name : 'N/A') }}
                </p>
            </a>
        </nav>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4 p-4">
            <!-- Assets Past Maintenance Alert -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-red-500 text-white p-4 flex items-center">
                    <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                    <h2 class="text-xl font-bold">Maintenance Overdue Assets</h2>
                </div>
                <div class="p-4">
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
                                                {{ \Carbon\Carbon::parse($asset->maintenance_end_date)->diffForHumans() }}
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
                        @if($totalPastDueAssets->count() > 5)
                            <div class="text-center mt-4">
                                <a href="{{ route('alerts.maintenance') }}" class="text-red-600 hover:underline">
                                    View All {{ $totalPastDueAssets->count() }} Overdue Assets
                                </a>
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            <!-- Placeholder for Future Alerts -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-yellow-500 text-white p-4 flex items-center">
                    <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                        </path>
                    </svg>
                    <h2 class="text-xl font-bold">Upcoming Alerts</h2>
                </div>
                <div class="p-4 text-center text-gray-500">
                    No additional alerts at the moment.
                </div>
            </div>

            <!-- Additional Alert Placeholders
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-blue-500 text-white p-4 flex items-center">
                    <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3 .138z">
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