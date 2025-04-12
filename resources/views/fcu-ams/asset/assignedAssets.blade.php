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
            <h1 class="my-auto text-3xl">Assigned Assets</h1>
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
        
        <div class="mb-1 flex justify-between m-3 rounded-md">
            <div class="space-x-2 flex">
                {{-- Removed Import/Export buttons --}}
            </div>
            <div class="pagination-here flex justify-between align-items-center">
                <div class="flex align-items-center">
                    <ul class="pagination my-auto flex">
                        <li class="page-item p-1 my-auto">
                            <a class="page-link my-auto" href="{{ $assignedAssets->url(1) }}">
                                {{-- First Page Icon --}}
                                <svg class="w-5 h-5 my-auto" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="previous"><g id="previous_2"><path id="Combined Shape" fill-rule="evenodd" clip-rule="evenodd" d="M28.9682 15.5438L39.257 8.52571C41.2485 7.16707 43.9486 8.59383 43.9486 11.0038V36.9158C43.9486 39.3272 41.249 40.7548 39.257 39.3958L20.2635 26.4382C18.5169 25.2492 18.5171 22.6726 20.2631 21.4817L26.9682 16.908V11.0064C26.9682 10.2023 26.0683 9.7271 25.4042 10.1802L6.43638 23.134C5.85532 23.5311 5.85532 24.3887 6.43618 24.7866L25.4038 37.7403C26.0683 38.1936 26.9682 37.7185 26.9682 36.9144V35.9744C26.9682 35.4221 27.4159 34.9744 27.9682 34.9744C28.5205 34.9744 28.9682 35.4221 28.9682 35.9744V36.9144C28.9682 39.3259 26.2685 40.7513 24.2762 39.3922L5.30706 26.4374C3.56509 25.2441 3.56509 22.6737 5.30824 21.4826L24.2766 8.52831C26.2685 7.16942 28.9682 8.59489 28.9682 11.0064V15.5438ZM26.9682 19.329V23.0024C26.9682 23.5547 27.4159 24.0024 27.9682 24.0024C28.5205 24.0024 28.9682 23.5547 28.9682 23.0024V17.9648L40.3841 10.1779C41.048 9.72496 41.9486 10.2009 41.9486 11.0038V36.9158C41.9486 37.7205 41.0482 38.1967 40.3842 37.7437L21.3892 24.785C20.8083 24.3898 20.8083 23.5308 21.3901 23.1339L26.9682 19.329Z" fill="#000000"/></g></g></svg>
                            </a>
                        </li>
                        <li class="page-item p-1 my-auto">
                            <a class="page-link my-auto" href="{{ $assignedAssets->previousPageUrl() }}">
                                {{-- Previous Page Icon --}}
                                <svg fill="#000000" class="w-5 h-5 my-auto" viewBox="0 0 24 24" id="previous" data-name="Line Color" xmlns="http://www.w3.org/2000/svg" class="icon line-color"><path id="primary" d="M17,3V21L5,12Z" style="fill: none; stroke: rgb(0, 0, 0); stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path></svg>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="text-center my-auto pr-4 pl-4 font_bold">
                    Showing {{ $assignedAssets->firstItem() }} to {{ $assignedAssets->lastItem() }} of
                    {{ $assignedAssets->total() }} items
                </div>
                <div class="flex align-items-center">
                    <ul class="pagination my-auto flex">
                        <li class="page-item p-1">
                            <a class="page-link" href="{{ $assignedAssets->nextPageUrl() }}">
                                {{-- Next Page Icon --}}
                                <svg fill="#000000" class="w-5 h-5 my-auto" viewBox="0 0 24 24" id="next" data-name="Line Color" xmlns="http://www.w3.org/2000/svg" class="icon line-color"><path id="primary" d="M17,12,5,21V3Z" style="fill: none; stroke: rgb(0, 0, 0); stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path></svg>
                            </a>
                        </li>
                        <li class="page-item p-1 my-auto">
                            <a class="page-link" href="{{ $assignedAssets->url($assignedAssets->lastPage()) }}">
                                {{-- Last Page Icon --}}
                                <svg class="w-5 h-5 my-auto" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="next"><g id="next_2"><path id="Combined Shape" fill-rule="evenodd" clip-rule="evenodd" d="M18.9792 32.3759L8.69035 39.3951C6.69889 40.7537 3.99878 39.3269 3.99878 36.917V11.005C3.99878 8.59361 6.69843 7.166 8.69028 8.52489L27.6843 21.4809C29.4304 22.672 29.4304 25.249 27.6843 26.4371L20.9792 31.0114V36.9144C20.9792 37.7185 21.8791 38.1937 22.5432 37.7406L41.5107 24.787C42.0938 24.3882 42.0938 23.5316 41.5112 23.1342L22.5436 10.1805C21.8791 9.72714 20.9792 10.2023 20.9792 11.0064V11.9464C20.9792 12.4987 20.5315 12.9464 19.9792 12.9464C19.4269 12.9464 18.9792 12.4987 18.9792 11.9464V11.0064C18.9792 8.59492 21.6789 7.16945 23.6711 8.52861L42.6387 21.4823C44.3845 22.6732 44.3845 25.2446 42.6391 26.4382L23.6707 39.3925C21.6789 40.7514 18.9792 39.3259 18.9792 36.9144V32.3759ZM18.9792 29.9548L7.56322 37.7429C6.89939 38.1958 5.99878 37.7199 5.99878 36.917V11.005C5.99878 10.2003 6.89924 9.72409 7.56321 10.1771L26.5573 23.1331C27.1391 23.53 27.1391  24.389 26.5573 24.785L18.9792 29.9548Z" fill="#000000"/></g></g></svg>
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
                <h2 class="text-2xl font-bold my-auto">Assigned Asset List</h2>
                <div class="searchBox flex gap-2">
                    {{-- Removed Filter button --}}
                    <form action="{{ route('asset.assigned') }}" method="GET" class="flex gap-2">
                        <div class="relative flex-1">
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="w-full rounded-md border-0 py-2 pl-2 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6"
                                placeholder="Search assigned assets..." id="searchInput">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-2">
                                <button type="submit" class="text-gray-400 hover:text-blue-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <button type="button" onclick="window.location.href='{{ route('asset.assigned') }}'"
                            class="flex gap-1 items-center bg-red-600 text-white hover:bg-red-700 transition-colors duration-200 ease-in rounded-md px-4 py-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                            Clear
                        </button>
                    </form>
                </div>
            </div>
            <div class="overflow-x-auto overflow-y-auto rounded-lg border-2 border-slate-300">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th scope="col" class="px-6 py-3 bg-gradient-to-r from-blue-400 to-blue-400 text-white text-left text-xs font-medium uppercase tracking-wider">
                                <div class="flex items-center">
                                    <span>Assigned To</span>
                                    <a class="ml-2" href="{{ route('asset.assigned', ['sort' => 'assigned_to', 'direction' => ($direction == 'asc' && $sort == 'assigned_to') ? 'desc' : 'asc']) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" /></svg>
                                    </a>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 bg-gradient-to-r from-blue-400 to-blue-400 text-white text-left text-xs font-medium uppercase tracking-wider">
                                <div class="flex items-center">
                                    <span>Asset Tag ID</span>
                                    <a class="ml-2" href="{{ route('asset.assigned', ['sort' => 'asset_tag_id', 'direction' => ($direction == 'asc' && $sort == 'asset_tag_id') ? 'desc' : 'asc']) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" /></svg>
                                    </a>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 bg-gradient-to-r from-blue-400 to-blue-400 text-white text-left text-xs font-medium uppercase tracking-wider">Brand</th>
                            <th scope="col" class="px-6 py-3 bg-gradient-to-r from-blue-400 to-blue-400 text-white text-left text-xs font-medium uppercase tracking-wider">Model</th>
                            <th scope="col" class="px-6 py-3 bg-gradient-to-r from-blue-400 to-blue-400 text-white text-left text-xs font-medium uppercase tracking-wider">Category</th>
                            <th scope="col" class="px-6 py-3 bg-gradient-to-r from-blue-400 to-blue-400 text-white text-left text-xs font-medium uppercase tracking-wider">Department</th>
                            <th scope="col" class="px-6 py-3 bg-gradient-to-r from-blue-400 to-blue-400 text-white text-left text-xs font-medium uppercase tracking-wider">Issued Date</th>
                            <th scope="col" class="px-6 py-3 bg-gradient-to-r from-blue-400 to-blue-400 text-white text-center text-xs font-medium uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php $currentUser = null; @endphp
                        @foreach($assignedAssets as $asset)
                            {{-- Optional: Grouping logic could be added here if desired, but sorting handles it well for now --}}
                            <tr class="hover:bg-gray-50 transition-colors duration-200 cursor-pointer" onclick="window.location.href='{{ route('asset.view', $asset->id) }}'">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $asset->assigned_to }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $asset->asset_tag_id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $asset->brand->brand ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $asset->model }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $asset->category->category ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $asset->department->department ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $asset->issued_date ? \Carbon\Carbon::parse($asset->issued_date)->format('M d, Y') : 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center" onclick="event.stopPropagation();">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ route('asset.view', $asset->id) }}" 
                                           class="text-green-600 hover:text-green-900 hover:scale-110 transition-transform duration-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        @if(Auth::user()->role->role != 'Department')
                                        <form id="return-asset-form-{{ $asset->id }}" action="{{ route('asset.return.from.assigned', $asset->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('PUT')
                                            <button type="button" 
                                                    onclick="openConfirmModal('return-asset-form-{{ $asset->id }}', 'Confirm Return', 'Do you want to return this asset? (Tag: {{ $asset->asset_tag_id }})')" 
                                                    class="text-blue-600 hover:text-blue-900 hover:scale-110 transition-transform duration-200" 
                                                    title="Return Asset">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M15.707 15.707a1 1 0 01-1.414 0l-5-5a1 1 0 010-1.414l5-5a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 010 1.414zm-6 0a1 1 0 01-1.414 0l-5-5a1 1 0 010-1.414l5-5a1 1 0 011.414 1.414L5.414 10l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        @if($assignedAssets->isEmpty())
                            <tr>
                                <td colspan="8" class="text-center py-4 text-gray-500">No assigned assets found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Include the new confirmation modal --}}
@include('layouts.modals.confirmActionModal')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const form = searchInput.closest('form');

        // Submit form on Enter key press
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                form.submit();
            }
        });

        // Clear search and reload page
        const clearButton = form.querySelector('button[type="button"]');
        clearButton.addEventListener('click', function() {
            searchInput.value = '';
            window.location.href = '{{ route("asset.assigned") }}';
        });
    });
</script>

@endsection 