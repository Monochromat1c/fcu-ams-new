@extends('layouts.layout')
@section('content')
<link rel="stylesheet" href="{{ asset('css/stockin.css') }}">
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

<div class="grid grid-cols-6">
    @include('layouts.sidebar')
    <div class="content min-h-screen bg-slate-200 col-span-5">
        <!-- Header -->
        <nav class="bg-white flex justify-between py-3 px-4 m-3 shadow-md rounded-md">
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="invisible flex gap-3 focus:outline-none" style="min-width:100px;">
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
            <h1 class="my-auto text-3xl">Supply Request</h1>
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

        <!-- Filter Modal -->
        <div id="filterModal" class="fixed inset-0 flex items-center justify-center z-50 hidden backdrop-blur-sm">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-50 transition-opacity duration-300"></div>
            <div class="bg-white rounded-xl shadow-2xl p-8 w-11/12 md:w-2/3 lg:w-1/2 max-h-[85vh] overflow-y-auto relative z-50 transform transition-all duration-300">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Filter Requests</h2>
                    <button type="button" onclick="document.getElementById('filterModal').classList.add('hidden')" 
                        class="text-gray-400 hover:text-gray-500 transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form id="filterForm" action="{{ route('requests.index') }}" method="GET" class="space-y-6">
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

        <div class="m-3 rounded-md">
            @include('layouts.messageWithoutTimerForError')
        </div>

        <!-- Requests List -->
        <div class="bg-white m-3 shadow-md rounded-md p-6 ">
            <div class="flex gap-2 justify-between mb-3">
                <h2 class="text-2xl font-semibold text-gray-900">Item Requests</h2>
                <div class="flex gap-2">
                    <button type="button" onclick="document.getElementById('filterModal').classList.remove('hidden')"
                        class="flex gap-1 items-center bg-blue-600 text-white hover:scale-105 transition-all duration-200 ease-in rounded-md px-4 p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
                        </svg>
                        Filter
                    </button>
                    <button type="button"
                        onclick="window.location.href='{{ route('requests.index') }}'"
                        class="flex gap-1 items-center bg-red-600 text-white hover:scale-105 transition-all duration-200 ease-in rounded-md px-4 p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                        Clear
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto border-2 border-slate-300 rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="bg-gradient-to-r from-blue-400 to-blue-500 text-white">
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Requester</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Department</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Items</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($requests as $request)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $request->requester }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $request->department->department }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $request->total_items }} items
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($request->request_date)->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($request->group_status === 'pending')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Pending
                                        </span>
                                    @elseif($request->group_status === 'approved')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Approved
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Rejected
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ route('inventory.supply-request.details', ['request_group_id' => $request->request_group_id]) }}" 
                                           class="text-green-600 hover:text-blue-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        @if(Auth::user()->role->role !== 'Viewer')
                                            <button onclick="document.getElementById('delete-request-modal{{ $request->request_group_id }}').classList.remove('hidden')"
                                                class="text-red-600 hover:text-red-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            <!-- Delete Confirmation Modal -->
                            <div id="delete-request-modal{{ $request->request_group_id }}" class="fixed inset-0 flex items-center justify-center z-50 hidden backdrop-blur-sm">
                                <div class="fixed inset-0 bg-gray-500 bg-opacity-50 transition-opacity duration-300"></div>
                                <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-4 overflow-hidden">
                                    <!-- Modal Header -->
                                    <div class="bg-white px-6 pt-6 pb-4">
                                        <div class="flex items-center justify-between mb-4">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 bg-red-100 rounded-full p-3 mr-3">
                                                    <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                    </svg>
                                                </div>
                                                <h3 class="text-lg font-medium text-gray-900">Delete Request</h3>
                                            </div>
                                            <button type="button" onclick="document.getElementById('delete-request-modal{{ $request->request_group_id }}').classList.add('hidden')" 
                                                class="text-gray-400 hover:text-gray-500 focus:outline-none">
                                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="mt-3">
                                            <p class="text-sm text-gray-500">
                                                Are you sure you want to delete this request? This action cannot be undone and will permanently remove the request from the system.
                                            </p>
                                        </div>
                                    </div>
                                    <!-- Modal Footer -->
                                    <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3">
                                        <button type="button" 
                                            onclick="document.getElementById('delete-request-modal{{ $request->request_group_id }}').classList.add('hidden')"
                                            class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                            Cancel
                                        </button>
                                        <form action="{{ route('requests.destroy', $request->request_group_id) }}" method="POST" class="inline-flex">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                                Delete Request
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                    No requests found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($requests->hasPages())
            <div class="mt-4 flex items-center justify-between px-4 mb-3">
                <div class="flex items-center gap-2">
                    <a href="{{ $requests->url(1) }}" class="p-2 inline-flex items-center justify-center rounded-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M15.707 15.707a1 1 0 01-1.414 0l-5-5a1 1 0 010-1.414l5-5a1 1 0 011.414 1.414L11.414 10l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            <path fill-rule="evenodd" d="M8.707 15.707a1 1 0 01-1.414 0l-5-5a1 1 0 010-1.414l5-5a1 1 0 011.414 1.414L4.414 10l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="{{ $requests->previousPageUrl() }}" class="p-2 inline-flex items-center justify-center rounded-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.707 15.707a1 1 0 01-1.414 0l-5-5a1 1 0 010-1.414l5-5a1 1 0 011.414 1.414L8.414 10l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            
                <span class="text-sm text-gray-700">
                    Page {{ $requests->currentPage() }} of {{ $requests->lastPage() }}
                </span>
            
                <div class="flex items-center gap-2">
                    <a href="{{ $requests->nextPageUrl() }}" class="p-2 inline-flex items-center justify-center rounded-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M7.293 4.293a1 1 0 011.414 0l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414-1.414L11.586 10 7.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="{{ $requests->url($requests->lastPage()) }}" class="p-2 inline-flex items-center justify-center rounded-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            <path fill-rule="evenodd" d="M11.293 4.293a1 1 0 011.414 0l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414-1.414L15.586 10l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Reset filters on page load/reload
        if (performance.navigation.type === 1) { // Check if it's a page reload
            window.location.href = "{{ route('requests.index') }}";
        }
    });

    window.onclick = function (event) {
        const filterModal = document.getElementById('filterModal');
        if (event.target == filterModal) {
            filterModal.classList.add('hidden');
        }

        // Close delete modals when clicking outside
        document.querySelectorAll('[id^="delete-request-modal"]').forEach(modal => {
            if (event.target == modal) {
                modal.classList.add('hidden');
            }
        });
    }
</script>

@endsection 