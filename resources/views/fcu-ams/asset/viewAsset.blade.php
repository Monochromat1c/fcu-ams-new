@extends('layouts.layout')
@section('content')
<link rel="stylesheet" href="{{ asset('css/viewAsset.css') }}">

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
            <div class="flex justify-between mb-3">
                <h2 class="text-2xl font-bold my-auto">View Asset</h2>
                <div class="flex align-items-center gap-3">
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
                    <a href="{{ route('asset.list') }}"
                        class="rounded-md shadow-md px-5 py-2 bg-red-600 hover:shadow-md hover:bg-red-500 transition-all duration-200 hover:scale-105 
                        ease-in hover:shadow-inner text-white flex gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                        </svg>
                        Back to Asset List
                    </a>
                </div>
            </div>
            <div class="overflow-x-auto overflow-y-auto">
                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-center bg-slate-200 border border-slate-400 whitespace-nowrap">Asset Image</th>
                            <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400 whitespace-nowrap">Asset Tag ID</th>
                            <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400 whitespace-nowrap">Specification</th>
                            <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400 whitespace-nowrap">Brand</th>
                            <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400 whitespace-nowrap">Model</th>
                            <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400 whitespace-nowrap">Serial Number</th>
                            <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400 whitespace-nowrap">Category</th>
                            <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400 whitespace-nowrap">Site</th>
                            <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400 whitespace-nowrap">Location</th>
                            <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400 whitespace-nowrap">Department</th>
                            <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400 whitespace-nowrap">Cost</th>
                            <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400 whitespace-nowrap">Supplier</th>
                            <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400 whitespace-nowrap">Purchase Date</th>
                            <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400 whitespace-nowrap">Status</th>
                            <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400 whitespace-nowrap">Condition</th>
                            <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400 whitespace-nowrap">Start of Maintenance</th>
                            <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400 whitespace-nowrap">End of Maintenance</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border border-slate-300 px-4 py-2 min-width">
                                @if($asset->asset_image)
                                    <img src="{{ asset($asset->asset_image) }}" alt="Asset Image"
                                        class="mx-auto rounded-full" style="width:2.7rem;height:2.7rem;">
                                @else
                                    <img src="{{ asset('profile/defaultIcon.png') }}"
                                        alt="Default Image" class="w-14 h-14 rounded-full mx-auto">
                                @endif
                            </td>
                            <td class="border border-slate-300 px-4 py-2  whitespace-nowrap">{{ $asset->asset_tag_id }}</td>
                            <td class="border border-slate-300 px-4 py-2  whitespace-nowrap">{{ $asset->specs }}</td>
                            <td class="border border-slate-300 px-4 py-2  whitespace-nowrap">{{ $asset->brand->brand }}</td>
                            <td class="border border-slate-300 px-4 py-2  whitespace-nowrap">{{ $asset->model }}</td>
                            <td class="border border-slate-300 px-4 py-2  whitespace-nowrap">{{ $asset->serial_number }}</td>
                            <td class="border border-slate-300 px-4 py-2  whitespace-nowrap">{{ $asset->category->category }}</td>
                            <td class="border border-slate-300 px-4 py-2  whitespace-nowrap">{{ $asset->site->site }}</td>
                            <td class="border border-slate-300 px-4 py-2  whitespace-nowrap">{{ $asset->location->location }}</td>
                            <td class="border border-slate-300 px-4 py-2  whitespace-nowrap">{{ $asset->department->department }}</td>
                            <td class="border border-slate-300 px-4 py-2  whitespace-nowrap">{{ $asset->cost }}</td>
                            <td class="border border-slate-300 px-4 py-2  whitespace-nowrap">{{ $asset->supplier->supplier }}</td>
                            <td class="border border-slate-300 px-4 py-2  whitespace-nowrap">{{ $asset->purchase_date }}</td>
                            <td class="border border-slate-300 px-4 py-2 whitespace-nowrap">
                                <div class="flex items-center gap-1">
                                    @if($asset->status->status == 'Available')
                                        <span class="inline-block w-4 h-4 bg-green-500 rounded-full"></span>
                                    @elseif($asset->status->status == 'Not Available')
                                        <span class="inline-block w-4 h-4 bg-red-500 rounded-full"></span>
                                    @endif
                                    {{ $asset->status->status }}
                                </div>
                            </td>
                            <td class="border border-slate-300 px-4 py-2  whitespace-nowrap">{{ $asset->condition->condition }}</td>
                            <td class="border border-slate-300 px-4 py-2  whitespace-nowrap">
                                {{ $asset->maintenance_start_date ?? 'N/A' }}</td>
                            <td class="border border-slate-300 px-4 py-2  whitespace-nowrap">
                                {{ $asset->maintenance_end_date ?? 'N/A' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        @if($asset->editHistory->isNotEmpty())
            <div class="bg-white p-5 shadow-md m-3 rounded-md">
                <div class="flex justify-between mb-3">
                    <h2 class="text-2xl font-bold my-auto">Edit History</h2>
                    <div class="flex align-items-center gap-1"></div>
                </div>
                <div class="overflow-x-auto overflow-y-auto">
                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400">Date</th>
                                <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400">User</th>
                                <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400">Changes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($asset->editHistory as $editHistory)
                                <tr>
                                    <td class="border border-slate-300 px-4 py-2">
                                        {{ $editHistory->created_at->format('Y-m-d H:i:s') }}</td>
                                    <td class="border border-slate-300 px-4 py-2">{{ $editHistory->user->first_name }}
                                        {{ $editHistory->user->last_name }}</td>
                                    <td class="border border-slate-300 px-4 py-2">{!! nl2br($editHistory->changes) !!}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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