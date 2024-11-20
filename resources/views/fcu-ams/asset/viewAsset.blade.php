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
            <div class="grid grid-cols-2 gap-3">
                <div class="mb-4">
                    <label for="asset_tag_id" class="block text-gray-700 font-bold mb-2">Asset Tag ID:</label>
                    <input type="text" id="asset_tag_id" name="asset_tag_id"
                        class="w-full p-2 border rounded-md bg-gray-100" value="{{ $asset->asset_tag_id }}" disabled>
                </div>
                <div class="mb-4">
                    <label for="model" class="block text-gray-700 font-bold mb-2">Model:</label>
                    <input type="text" id="model" name="model" class="w-full p-2 border rounded-md bg-gray-100"
                        value="{{ $asset->model }}" disabled>
                </div>
                <div class="mb-2">
                    <label for="spec" class="block text-gray-700 font-bold mb-2">Specification:</label>
                    <input type="text" id="specs" name="specs" class="w-full p-2 border rounded-md bg-gray-100"
                        value="{{ $asset->specs }}">
                </div>
                <div class="mb-4">
                    <label for="serial_number" class="block text-gray-700 font-bold mb-2">Serial Number:</label>
                    <input type="text" id="serial_number" name="serial_number"
                        class="w-full p-2 border rounded-md bg-gray-100" value="{{ $asset->serial_number }}" disabled>
                </div>
                <div class="mb-4">
                    <label for="cost" class="block text-gray-700 font-bold mb-2">Cost:</label>
                    <input type="number" id="cost" name="cost" class="w-full p-2 border rounded-md bg-gray-100"
                        value="{{ $asset->cost }}" min="0" disabled>
                </div>
                <div class="mb-4">
                    <label for="supplier_id" class="block text-gray-700 font-bold mb-2">Supplier:</label>
                    <select id="supplier_id" name="supplier_id" class="w-full p-2 border rounded-md bg-gray-100"
                        disabled>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}"
                                {{ $supplier->id == $asset->supplier_id ? 'selected' : '' }}>
                                {{ $supplier->supplier }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="site_id" class="block text-gray-700 font-bold mb-2">Site:</label>
                    <select id="site_id" name="site_id" class="w-full p-2 border rounded-md bg-gray-100" disabled>
                        @foreach($sites as $site)
                            <option value="{{ $site->id }}"
                                {{ $site->id == $asset->site_id ? 'selected' : '' }}>
                                {{ $site->site }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="location_id" class="block text-gray-700 font-bold mb-2">Location:</label>
                    <select id="location_id" name="location_id" class="w-full p-2 border rounded-md bg-gray-100"
                        disabled>
                        @foreach($locations as $location)
                            <option value="{{ $location->id }}"
                                {{ $location->id == $asset->location_id ? 'selected' : '' }}>
                                {{ $location->location }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="category_id" class="block text-gray-700 font-bold mb-2">Category:</label>
                    <select id="category_id" name="category_id" class="w-full p-2 border rounded-md bg-gray-100"
                        disabled>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ $category->id == $asset->category_id ? 'selected' : '' }}>
                                {{ $category->category }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="department_id" class="block text-gray-700 font-bold mb-2">Department:</label>
                    <select id="department_id" name="department_id" class="w-full p-2 border rounded-md bg-gray-100"
                        disabled>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}"
                                {{ $department->id == $asset->department_id ? 'selected' : '' }}>
                                {{ $department->department }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="brand_id" class="block text-gray-700 font-bold mb-2">Brand:</label>
                    <select id="brand_id" name="brand_id" class="w-full p-2 border rounded-md bg-gray-100" disabled>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}"
                                {{ $brand->id == $asset->brand_id ? 'selected' : '' }}>
                                {{ $brand->brand }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="status_id" class="block text-gray-700 font-bold mb-2">Status:</label>
                    <select id="status_id" name="status_id" class="w-full p-2 border rounded-md bg-gray-100" disabled>
                        @foreach($statuses as $status)
                            <option value="{{ $status->id }}"
                                {{ $status->id == $asset->status_id ? 'selected' : '' }}>
                                {{ $status->status }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="condition_id" class="block text-gray-700 font-bold mb-2">Condition:</label>
                    <select id="condition_id" name="condition_id" class="w-full p-2 border rounded-md bg-gray-100"
                        disabled>
                        @foreach($conditions as $condition)
                            <option value="{{ $condition->id }}"
                                {{ $condition->id == $asset->condition_id ? 'selected' : '' }}>
                                {{ $condition->condition }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="purchase_date" class="block text-gray-700 font-bold mb-2">Purchase Date:</label>
                    <input type="date" id="purchase_date" name="purchase_date"
                        class="w-full p-2 border rounded-md bg-gray-100" value="{{ $asset->purchase_date }}" disabled>
                </div>
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