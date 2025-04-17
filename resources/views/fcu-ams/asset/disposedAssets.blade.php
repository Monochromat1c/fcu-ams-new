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
            <h1 class="my-auto text-3xl">Disposed Assets</h1>
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

        <div class="bg-white p-5 shadow-md m-3 rounded-md">
            <div class="flex justify-between mb-6">
                <h2 class="text-2xl font-bold my-auto">Disposed Assets List</h2>
                <!-- Add Dispose Assets Button -->
                <button type="button" onclick="document.getElementById('disposeMultipleAssetsModal').classList.remove('hidden')"
                    class="flex gap-2 items-center bg-orange-600 text-white hover:scale-105 transition-all duration-200 ease-in rounded-md px-4 p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                    </svg>
                    Dispose Assets
                </button>
                <!-- End Dispose Assets Button -->
            </div>

            <div class="overflow-x-auto overflow-y-auto rounded-lg border-2 border-slate-300">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th scope="col" class="px-6 py-3 bg-gradient-to-r from-blue-400 to-blue-400 text-white text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <span>Asset Tag ID</span>
                                    <a class="ml-2" href="{{ route('asset.disposed', ['sort' => 'asset_tag_id', 'direction' => ($direction == 'asc' && $sort == 'asset_tag_id') ? 'desc' : 'asc']) }}">
                                        {{-- <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                        </svg> --}}
                                    </a>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 bg-gradient-to-r from-blue-400 to-blue-400 text-white text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <span>Category</span>
                                    <a class="ml-2" href="{{ route('asset.disposed', ['sort' => 'category_name', 'direction' => ($direction == 'asc' && $sort == 'category_name') ? 'desc' : 'asc']) }}">
                                        {{-- <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                        </svg> --}}
                                    </a>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 bg-gradient-to-r from-blue-400 to-blue-400 text-white text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <span>Brand</span>
                                    <a class="ml-2" href="{{ route('asset.disposed', ['sort' => 'brand_name', 'direction' => ($direction == 'asc' && $sort == 'brand_name') ? 'desc' : 'asc']) }}">
                                        {{-- <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                        </svg> --}}
                                    </a>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 bg-gradient-to-r from-blue-400 to-blue-400 text-white text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <span>Model</span>
                                    <a class="ml-2" href="{{ route('asset.disposed', ['sort' => 'model', 'direction' => ($direction == 'asc' && $sort == 'model') ? 'desc' : 'asc']) }}">
                                        {{-- <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                        </svg> --}}
                                    </a>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 bg-gradient-to-r from-blue-400 to-blue-400 text-white text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <span>Department</span>
                                    <a class="ml-2" href="{{ route('asset.disposed', ['sort' => 'department_name', 'direction' => ($direction == 'asc' && $sort == 'department_name') ? 'desc' : 'asc']) }}">
                                        {{-- <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                        </svg> --}}
                                    </a>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 bg-gradient-to-r from-blue-400 to-blue-400 text-white text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <span>Disposed Status</span>
                                    <a class="ml-2" href="{{ route('asset.disposed', ['sort' => 'disposed_status_name', 'direction' => ($direction == 'asc' && $sort == 'disposed_status_name') ? 'desc' : 'asc']) }}">
                                        {{-- <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                        </svg> --}}
                                    </a>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 bg-gradient-to-r from-blue-400 to-blue-400 text-white text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($disposedAssets as $asset)
                            <tr class="hover:bg-gray-50 transition-colors duration-200 cursor-pointer" onclick="window.location.href='{{ route('asset.view', $asset->id) }}'">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $asset->asset_tag_id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $asset->category_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $asset->brand_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $asset->model }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $asset->department_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div>{{ $asset->disposed_status_name }}</div>
                                    @if($asset->disposed_status_name == 'Sold' && $asset->disposed_amount !== null)
                                        <div class="text-xs text-gray-500 mt-1">
                                            Amount: ₱{{ number_format($asset->disposed_amount, 2) }}
                                        </div>
                                    @endif
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
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center space-y-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                        <p class="text-xl font-medium text-gray-500">No disposed assets found</p>
                                        <p class="text-sm text-gray-400">There are currently no disposed assets in the system.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $disposedAssets->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Dispose Multiple Assets Modal -->
<div id="disposeMultipleAssetsModal" tabindex="-1" aria-hidden="true" class="fixed inset-0 z-50 overflow-y-auto bg-gray-900 bg-opacity-50 backdrop-blur-sm hidden">
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="relative w-full max-w-6xl transform overflow-hidden rounded-2xl bg-white shadow-2xl transition-all">
            <form action="{{ route('asset.dispose.multiple') }}" method="POST" id="disposeMultipleForm">
                @csrf
                <!-- Header -->
                <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">Select Assets to Dispose</h3>
                        <button type="button" class="text-gray-400 hover:text-gray-500" onclick="document.getElementById('disposeMultipleAssetsModal').classList.add('hidden')">
                            <span class="sr-only">Close</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="p-6 space-y-4 max-h-[60vh] overflow-y-auto">
                    <!-- Search Input -->
                    <div class="mb-4">
                        <input type="text" id="assetSearchInput" placeholder="Search by Tag, Brand, Model, Category..."
                               class="shadow-sm p-2 border focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-2 border-gray-300 rounded-md">
                    </div>
                    <!-- End Search Input -->

                    <!-- Asset Selection Table -->
                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="p-4 flex items-center">
                                        <input type="checkbox" id="selectAllAssets" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Asset Tag ID</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Brand</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Model</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Disposal Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Disposal Amount (₱)</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($allAssetsForDisposal as $assetForDisposal)
                                    <tr class="hover:bg-gray-50 asset-row" data-asset-id="{{ $assetForDisposal->id }}">
                                        <td class="p-4 whitespace-nowrap">
                                            <input type="checkbox" name="asset_ids[]" value="{{ $assetForDisposal->id }}" class="asset-checkbox h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $assetForDisposal->asset_tag_id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $assetForDisposal->brand->brand ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $assetForDisposal->model }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $assetForDisposal->category->category ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 align-top">
                                            <select name="disposed_status[{{ $assetForDisposal->id }}]" 
                                                    id="disposed_status_id_{{ $assetForDisposal->id }}_modal"
                                                    class="dispose-status-select shadow-sm p-2 border focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-2 bg-slate-50 border-gray-300 rounded-md disabled:bg-gray-200 disabled:cursor-not-allowed"
                                                    disabled>
                                                <option value="" selected>Select Status</option> 
                                                @foreach($allDisposedStatuses as $disposedStatus)
                                                    <option value="{{ $disposedStatus->id }}" data-status-name="{{ $disposedStatus->status }}">
                                                        {{ $disposedStatus->status }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 align-top">
                                            <div> 
                                                <input type="number" name="disposed_amount[{{ $assetForDisposal->id }}]" 
                                                       id="disposed_amount_{{ $assetForDisposal->id }}_modal"
                                                       step="0.01" min="0"
                                                       class="dispose-amount-input shadow-sm p-2 border focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-2 bg-slate-50 border-gray-300 rounded-md disabled:bg-gray-200 disabled:cursor-not-allowed"
                                                       disabled>
                                                <span id="disposed_amount_required_star_{{ $assetForDisposal->id }}_modal" class="text-red-500 text-xs hidden mt-1">Required if Sold</span>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">No non-disposed assets found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Disposal Fields - REMOVED -->
                    {{-- <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-gray-200">
                        <div>
                            <label for="disposed_status_id_modal" class="block text-sm font-medium text-gray-700">Disposal Status <span class="text-red-500">*</span></label>
                            <div class="mt-1">
                                <select id="disposed_status_id_modal" name="disposed_status_id" required
                                        onchange="toggleDisposeAmountRequiredModal()"
                                        class="shadow-sm p-2 border focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-2 bg-slate-50 border-gray-300 rounded-md">
                                    <option value="" disabled selected>Select disposal status</option>
                                    @foreach($allDisposedStatuses as $disposedStatus)
                                        <option value="{{ $disposedStatus->id }}" data-status-name="{{ $disposedStatus->status }}">
                                            {{ $disposedStatus->status }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div>
                            <label for="disposed_amount_modal" class="block text-sm font-medium text-gray-700">
                                Disposed Amount (₱) <span id="disposed_amount_required_star_modal" class="text-red-500 hidden">*</span>
                            </label>
                            <div class="mt-1">
                                <input type="number" id="disposed_amount_modal" name="disposed_amount" step="0.01" min="0"
                                       class="shadow-sm p-2 border focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-2 bg-slate-50 border-gray-300 rounded-md">
                            </div>
                        </div>
                    </div> --}}

                    <!-- <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mt-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M8.485 3.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 3.495zM10 14a1 1 0 110-2 1 1 0 010 2zm0-7a1 1 0 011 1v3a1 1 0 11-2 0V8a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                Disposing selected assets will set their condition to 'Disposed' and status to 'Unavailable'. This action cannot be easily undone.
                                </p>
                            </div>
                        </div>
                    </div> -->
                </div>

                <!-- Footer -->
                <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3">
                    <button type="button"
                        class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                        onclick="document.getElementById('disposeMultipleAssetsModal').classList.add('hidden')">
                        Cancel
                    </button>
                    <button type="submit"
                        class="inline-flex items-center rounded-md border border-transparent bg-orange-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2">
                        Dispose Selected Assets
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Dispose Multiple Assets Modal -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        let typingTimer;
        const doneTypingInterval = 300;

        // Commenting out search script as search box was removed
        // searchInput.addEventListener('input', function() {
        //     clearTimeout(typingTimer);
        //     typingTimer = setTimeout(performSearch, doneTypingInterval);
        // });

        // searchInput.addEventListener('keypress', function(e) {
        //     if (e.key === 'Enter') {
        //         e.preventDefault();
        //         performSearch();
        //     }
        // });

        // function performSearch() {
        //     const searchQuery = searchInput.value;
        //     window.location.href = `{{ route('asset.disposed') }}?search=${searchQuery}`;
        // }
    });

    // Function to toggle the 'required' attribute for dispose amount in the MULTIPLE dispose modal - ROW SPECIFIC
    function toggleDisposeAmountRequiredForRow(assetId) {
        const statusSelect = document.getElementById(`disposed_status_id_${assetId}_modal`);
        const amountInput = document.getElementById(`disposed_amount_${assetId}_modal`);
        const requiredStar = document.getElementById(`disposed_amount_required_star_${assetId}_modal`);

        if (!statusSelect || !amountInput || !requiredStar) return; // Elements might not exist if row is hidden

        const selectedOption = statusSelect.options[statusSelect.selectedIndex];
        const selectedStatusName = selectedOption ? selectedOption.getAttribute('data-status-name') : null;

        // Only require if the specific status select is enabled (meaning checkbox is checked)
        if (!statusSelect.disabled && selectedStatusName && selectedStatusName.toLowerCase() === 'sold') {
            amountInput.setAttribute('required', 'required');
            requiredStar.classList.remove('hidden');
        } else {
            amountInput.removeAttribute('required');
            requiredStar.classList.add('hidden');
        }
    }

    // Add event listener for the Select All checkbox
    const selectAllCheckbox = document.getElementById('selectAllAssets');
    const assetCheckboxes = document.querySelectorAll('.asset-checkbox');

    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            assetCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
                // Enable/disable fields in the row
                const row = checkbox.closest('.asset-row');
                const statusSelect = row.querySelector('.dispose-status-select');
                const amountInput = row.querySelector('.dispose-amount-input');
                if (statusSelect) statusSelect.disabled = !this.checked;
                if (amountInput) amountInput.disabled = !this.checked;
                // Clear values if unchecking all
                if (!this.checked) {
                    if (statusSelect) statusSelect.value = '';
                    if (amountInput) amountInput.value = '';
                }
                 // Trigger required check
                 const assetId = row.getAttribute('data-asset-id');
                 if (assetId) toggleDisposeAmountRequiredForRow(assetId);
            });
        });
    }

    // Add change event listener to each status select dropdown in the modal
    document.querySelectorAll('#disposeMultipleAssetsModal .dispose-status-select').forEach(select => {
        select.addEventListener('change', function() {
            const row = this.closest('.asset-row');
            const assetId = row.getAttribute('data-asset-id');
            if (assetId) {
                toggleDisposeAmountRequiredForRow(assetId);
            }
        });
    });

    // Add event listener to uncheck Select All if any individual checkbox is unchecked
    assetCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const row = this.closest('.asset-row');
            if (!row) return; // Safety check

            const statusSelect = row.querySelector('.dispose-status-select');
            const amountInput = row.querySelector('.dispose-amount-input');
            const assetId = row.getAttribute('data-asset-id');
            const shouldBeEnabled = this.checked;

            // console.log(`Checkbox for asset ${assetId} changed. Checked: ${this.checked}. Should be enabled: ${shouldBeEnabled}`);

            if (statusSelect) {
                statusSelect.disabled = !shouldBeEnabled;
                // console.log(`  Status select disabled: ${statusSelect.disabled}`);
                // Clear value if disabling
                if (!shouldBeEnabled) {
                    statusSelect.value = '';
                }
            }
            if (amountInput) {
                amountInput.disabled = !shouldBeEnabled;
                // console.log(`  Amount input disabled: ${amountInput.disabled}`);
                 // Clear value if disabling
                 if (!shouldBeEnabled) {
                    amountInput.value = '';
                }
            }

            // Trigger required check for the specific row
            if (assetId) {
                toggleDisposeAmountRequiredForRow(assetId);
            }

            // Update Select All checkbox state
            if (!this.checked) {
                if (selectAllCheckbox) selectAllCheckbox.checked = false;
            } else {
                // Check if all other checkboxes are checked
                let allChecked = true;
                // Consider only visible rows for select all logic when individual box is checked
                document.querySelectorAll('#disposeMultipleAssetsModal .asset-row').forEach(r => {
                    if (r.style.display !== 'none') { // Check if row is visible
                        const cb = r.querySelector('.asset-checkbox');
                        if (!cb || !cb.checked) {
                            allChecked = false;
                        }
                    }
                });
                if (selectAllCheckbox) selectAllCheckbox.checked = allChecked;
            }

            // Move row to top if checked
            if (this.checked) {
                const tableBody = row.closest('tbody');
                if (tableBody) {
                    tableBody.insertBefore(row, tableBody.firstChild);
                }
            }
        });
    });

    // Add click listener to table rows to toggle checkbox
    document.querySelectorAll('#disposeMultipleAssetsModal .asset-row').forEach(row => {
        row.addEventListener('click', function(event) {
            // Find the checkbox within this row
            const checkbox = this.querySelector('.asset-checkbox');
            if (!checkbox) return;

            // Prevent toggling if the click was directly on the checkbox or its label (if any)
            // Or if the click was on the input/select fields themselves
            if (event.target === checkbox || 
                event.target.closest('.dispose-status-select') || 
                event.target.closest('.dispose-amount-input')) {
                return; 
            }

            // Toggle the checkbox state
            checkbox.checked = !checkbox.checked;

            // Manually trigger the change event on the checkbox
            // This is crucial for our existing logic (enable/disable fields, update selectAll) to run
            const changeEvent = new Event('change', { bubbles: true });
            checkbox.dispatchEvent(changeEvent);
        });
    });

    // --- Dynamic Search for Modal Table --- 
    const searchInput = document.getElementById('assetSearchInput');
    const tableRows = document.querySelectorAll('#disposeMultipleAssetsModal .asset-row');
    const selectAllCheckboxForSearch = document.getElementById('selectAllAssets'); // Reuse existing variable if defined earlier

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            let allVisibleChecked = true;
            let anyVisible = false;

            tableRows.forEach(row => {
                const assetTag = row.cells[1]?.textContent.toLowerCase() || '';
                const brand = row.cells[2]?.textContent.toLowerCase() || '';
                const model = row.cells[3]?.textContent.toLowerCase() || '';
                const category = row.cells[4]?.textContent.toLowerCase() || '';
                const rowText = `${assetTag} ${brand} ${model} ${category}`;
                const isMatch = rowText.includes(searchTerm);
                const checkbox = row.querySelector('.asset-checkbox');

                if (isMatch) {
                    row.style.display = ''; // Show row
                    anyVisible = true;
                    if (!checkbox || !checkbox.checked) {
                        allVisibleChecked = false; // If any visible row is unchecked, Select All should be unchecked
                    }
                } else {
                    row.style.display = 'none'; // Hide row
                    // If a hidden row is unchecked, it doesn't affect the Select All state for *visible* rows
                    // If a hidden row *is* checked, it also shouldn't make Select All unchecked (as it's not visible)
                    // So, we only care about the state of *visible* rows for the Select All checkbox.
                }
            });

            // Update Select All checkbox based on visible rows
            if (selectAllCheckboxForSearch) {
                selectAllCheckboxForSearch.checked = anyVisible && allVisibleChecked;
            }
        });
    }
    // --- End Dynamic Search ---

    // REMOVE Initial check for the old global modal fields
    /*
    document.addEventListener('DOMContentLoaded', function() {
        toggleDisposeAmountRequiredModal();
    });
    */

</script>

@endsection 