@extends('layouts.layout')
@section('content')
<link rel="stylesheet" href="{{ asset('css/stockin.css') }}">
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="grid grid-cols-6">
    @include('layouts.sidebar')
    <div class="content min-h-screen bg-slate-200 col-span-5">
        <!-- Header -->
        <div class="bg-white m-3 shadow-md rounded-md 2xl:max-w-7xl 2xl:mx-auto">
            <div class="px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex justify-between items-center">
                    <div class="flex items-center justify-between w-full">
                        <a href="{{ Auth::user()->role->role === 'Department' ? route('inventory.my.requests') : route('requests.index') }}"
                        class="mr-4 hover:bg-gray-100 my-auto p-2 rounded-full transition">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                        </a>
                        <h1 class="text-2xl font-semibold text-gray-900">Supply Request Details</h1>
                        @php
                            $allItemsApproved = $requests->every(function($request) {
                                return $request->status === 'approved';
                            });
                        @endphp
                        @if($allItemsApproved && Auth::user()->role->role !== 'Department')
                        
                            <button onclick="window.location.href='{{ route('inventory.supply.request.print', $requests->first()->request_group_id) }}'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                                </svg>
                                Print
                            </button>
                        @else
                            <p class="invisible">.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="m-3 rounded-md 2xl:max-w-7xl 2xl:mx-auto">
                @include('layouts.messageWithoutTimerForError')
        </div>

        <!-- Request Information -->
        <div class="bg-white m-3 shadow-md rounded-md p-6 2xl:max-w-7xl 2xl:mx-auto">
            <div class="flex justify-between items-start mb-6">
                <h3 class="text-lg font-semibold">Request Information</h3>
                @if(Auth::user()->role->role !== 'Department')
                    <div class="flex gap-4">
                        <form action="{{ route('inventory.supply-request.approve', ['request_group_id' => $requests->first()->request_group_id]) }}" method="POST">
                            @csrf
                            <button type="submit" 
                                {{ $overallStatus === 'approved' || $overallStatus === 'rejected' ? 'disabled' : '' }}
                                class="inline-flex items-center px-4 py-2 bg-white border-2 border-green-500 hover:bg-green-500 text-green-600 hover:text-white text-sm font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200 ease-in-out disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:bg-white disabled:hover:text-green-600">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Approve
                            </button>
                        </form>
                        <form action="{{ route('inventory.supply-request.reject', ['request_group_id' => $requests->first()->request_group_id]) }}" method="POST">
                            @csrf
                            <button type="submit"
                                {{ $overallStatus === 'approved' || $overallStatus === 'rejected' || $overallStatus === 'partially_approved' ? 'disabled' : '' }}
                                class="inline-flex items-center px-4 py-2 bg-white border-2 border-red-500 hover:bg-red-500 text-red-600 hover:text-white text-sm font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200 ease-in-out disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:bg-white disabled:hover:text-red-600">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Reject
                            </button>
                        </form>
                    </div>
                @else
                    <div class="flex gap-4">
                        @if($overallStatus !== 'cancelled' && $overallStatus !== 'approved')
                            <!-- Edit button -->
                            <button type="button" 
                                onclick="document.getElementById('editRequestModal').classList.toggle('hidden')"
                                class="inline-flex items-center px-4 py-2 bg-white border-2 border-blue-500 hover:bg-blue-500 text-blue-600 hover:text-white text-sm font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200 ease-in-out">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit
                            </button>
                            <!-- Cancel button -->
                            <form action="{{ route('inventory.supply-request.cancel', ['request_group_id' => $requests->first()->request_group_id]) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-white border-2 border-red-500 hover:bg-red-500 text-red-600 hover:text-white text-sm font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200 ease-in-out">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Cancel
                                </button>
                            </form>
                        @endif
                        <!-- Print button -->
                        @if(auth()->user()->role->role !== 'Department')
                        <a href="{{ route('inventory.supply-request.print', ['request_group_id' => $requests->first()->request_group_id]) }}" target="_blank"
                            class="inline-flex items-center px-4 py-2 bg-white border-2 border-gray-500 hover:bg-gray-500 text-gray-600 hover:text-white text-sm font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200 ease-in-out">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                            </svg>
                            Print
                        </a>
                        @endif
                    </div>
                @endif
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <div class="bg-white rounded-lg border border-slate-200">
                        <div class="px-4 py-3 border-b border-slate-200">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Requester</p>
                                    <p class="text-sm font-semibold text-gray-900">{{ $requests->first()->requester }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 border-b border-slate-200">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Department</p>
                                    <p class="text-sm font-semibold text-gray-900">{{ $requests->first()->department->department }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 border-b border-slate-200">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Request Date</p>
                                    <p class="text-sm font-semibold text-gray-900">{{ date('M d, Y h:i A', strtotime($requests->first()->created_at)) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 border-b border-slate-200">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Status</p>
                                    <span class="inline-flex px-2 py-0.5 text-xs font-medium rounded-full mt-1
                                        {{ $overallStatus === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                           ($overallStatus === 'approved' ? 'bg-green-100 text-green-800' : 
                                           ($overallStatus === 'partially_approved' ? 'bg-blue-100 text-blue-800' :
                                           ($overallStatus === 'cancelled' ? 'bg-gray-100 text-gray-800' :
                                           'bg-red-100 text-red-800'))) }}">
                                        {{ ucfirst(str_replace('_', ' ', $overallStatus)) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3">
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0 mt-1">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Additional Comments</p>
                                    <p class="text-sm text-gray-700">{{ $requests->first()->notes ? $requests->first()->notes : 'No additional comments provided.' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="bg-white rounded-lg border border-slate-200">
                        <div class="px-4 py-3 border-b border-slate-200">
                            <h3 class="text-sm font-semibold text-gray-900">Summary</h3>
                        </div>
                        <div class="px-4 py-3">
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-500">Total Items</span>
                                    <span class="text-sm font-semibold text-gray-900">{{ $totalItems }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-500">Total Price</span>
                                    <span class="text-sm font-semibold text-blue-600">₱{{ number_format($totalPrice, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Requested Items Table -->
            <div class="mt-8">
                <h3 class="text-lg font-semibold mb-4">Requested Items</h3>
                <div class="overflow-x-auto border-2 border-slate-300 rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gradient-to-r from-blue-400 to-blue-500 text-white">
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Item</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Quantity</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Unit</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Unit Price</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Total Price</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($requests as $request)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $request->item_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 text-xs font-medium rounded-full
                                        {{ $request->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                           ($request->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                           ($request->status === 'partially_approved' ? 'bg-blue-100 text-blue-800' :
                                           ($request->status === 'cancelled' ? 'bg-gray-100 text-gray-800' :
                                           'bg-red-100 text-red-800'))) }}">
                                        {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $request->quantity }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $request->unit_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">₱{{ number_format($request->unit_price, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">₱{{ number_format($request->total_price, 2) }}</td>
                            </tr>
                            @endforeach
                            <tr class="bg-gray-50">
                                <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-right">
                                    Total:
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600 text-left">
                                    ₱{{ number_format($totalPrice, 2) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Request Modal -->
<div id="editRequestModal" style="min-height:100vh; background-color: rgba(0, 0, 0, 0.5);" tabindex="-1" aria-hidden="true"
    class="modalBg flex fixed top-0 left-0 right-0 bottom-0 z-50 p-4 w-full md:inset-0 hidden">
    <div class="relative my-auto mx-auto p-4 w-full max-w-4xl h-full md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-xl dark:bg-white border-0">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 border-b rounded-t">
                <h3 class="text-xl font-semibold text-gray-900">
                    Edit Supply Request
                </h3>
                <button type="button"
                    onclick="document.getElementById('editRequestModal').classList.toggle('hidden')"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 flex items-center justify-center">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-6">
                <form id="edit-request-form" method="POST" action="{{ route('inventory.supply-request.update', $requests->first()->request_group_id) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <div class="flex gap-4 mb-6">
                            <div class="flex-1 relative">
                                <input type="text" id="edit_item_name" class="block w-full px-4 py-2 border-2 border-slate-300 rounded-md shadow-sm focus:border-blue-500 bg-slate-50 focus:ring-1 focus:ring-blue-500 sm:text-sm transition duration-150 ease-in-out" placeholder="Search Item">
                                <div id="edit-suggestions-container" class="absolute w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg z-50 max-h-60 overflow-y-auto hidden">
                                    <!-- Add loading spinner -->
                                    <div id="edit-suggestions-loading" class="hidden">
                                        <div class="flex items-center justify-center p-4">
                                            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-500"></div>
                                            <span class="ml-2 text-gray-600">Searching...</span>
                                        </div>
                                    </div>
                                    <ul id="edit-suggestions-list" class="py-1">
                                    </ul>
                                </div>
                            </div>
                            <div class="flex-1">
                                <input type="number" id="edit_item_quantity" class="block w-full rounded-md border-0 py-1.5 pl-3 pr-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" placeholder="Quantity" min="1">
                            </div>
                            <button type="button" id="edit-add-item-button" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                                Add Item
                            </button>
                        </div>

                        <div class="overflow-y-auto max-h-64">
                            <div class="max-w-4xl mx-auto overflow-x-auto overflow-y-auto rounded-lg border-2 border-slate-300">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr class="bg-gradient-to-r from-blue-400 to-blue-500 text-white">
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Item</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Unit</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Unit Price</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Quantity</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Total Price</th>
                                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="edit-items-table-body" class="bg-white divide-y divide-gray-200">
                                        @foreach($requests as $request)
                                        <tr data-request-id="{{ $request->id }}" 
                                            data-name="{{ $request->item_name }}"
                                            data-quantity="{{ $request->quantity }}"
                                            data-unit="{{ $request->unit ? $request->unit->unit : ($request->inventory ? $request->inventory->unit->unit : '') }}"
                                            data-unit-price="{{ $request->inventory ? $request->inventory->unit_price : $request->estimated_unit_price }}">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $request->item_name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $request->unit ? $request->unit->unit : ($request->inventory ? $request->inventory->unit->unit : '') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                ₱{{ number_format($request->inventory ? $request->inventory->unit_price : $request->estimated_unit_price, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <input type="number" 
                                                    name="quantities[{{ $request->id }}]" 
                                                    value="{{ $request->quantity }}"
                                                    min="1"
                                                    class="block w-24 rounded-md border-0 py-1.5 pl-3 pr-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6"
                                                    required>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                ₱{{ number_format(($request->inventory ? $request->inventory->unit_price : $request->estimated_unit_price) * $request->quantity, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                                <button type="button" class="delete-row-button inline-flex items-center p-2 border border-transparent rounded-full text-red-600 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150 ease-in-out">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="bg-gray-50">
                                            <td colspan="4" class="px-6 py-4 text-right font-semibold text-gray-900">Overall Total:</td>
                                            <td id="edit-modal-total" class="px-6 py-4 text-left font-semibold text-gray-900">₱{{ number_format($totalPrice, 2) }}</td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center justify-end pt-4 border-t border-gray-200 gap-3">
                        <button type="button" 
                            onclick="document.getElementById('editRequestModal').classList.toggle('hidden')"
                            class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">
                            Cancel
                        </button>
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Empty Field Validation Modal -->
<div id="editValidationModal" style="min-height:100vh; background-color: rgba(0, 0, 0, 0.5);" tabindex="-1" aria-hidden="true"
    class="modalBg flex fixed top-0 left-0 right-0 bottom-0 z-50 p-4 w-full md:inset-0 hidden">
    <div class="relative my-auto mx-auto p-4 w-full max-w-md h-full md:h-auto">
        <div class="relative bg-white rounded-lg shadow-xl dark:bg-white border-0">
            <div class="flex items-center justify-between p-4 border-b rounded-t">
                <h3 class="text-xl font-semibold text-gray-900">
                    Validation Error
                </h3>
                <button type="button" onclick="document.getElementById('editValidationModal').classList.add('hidden')" 
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 flex items-center justify-center">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
            <div class="p-6">
                <p class="text-gray-700">Please enter both item name and a valid quantity.</p>
            </div>
            <div class="flex items-center justify-end p-4 border-t border-gray-200">
                <button type="button" onclick="document.getElementById('editValidationModal').classList.add('hidden')"
                    class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                    OK
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Insufficient Stock Warning Modal -->
<div id="editInsufficientStockModal" style="min-height:100vh; background-color: rgba(0, 0, 0, 0.5);" tabindex="-1" aria-hidden="true"
    class="modalBg flex fixed top-0 left-0 right-0 bottom-0 z-50 p-4 w-full md:inset-0 hidden">
    <div class="relative my-auto mx-auto p-4 w-full max-w-md h-full md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 border-b rounded-t">
                <h3 class="text-xl font-semibold text-yellow-600">
                    ⚠️ Insufficient Stock Warning
                </h3>
                <button type="button" onclick="document.getElementById('editInsufficientStockModal').classList.add('hidden')"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 flex items-center justify-center">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-6">
                <p id="editInsufficientStockMessage" class="text-gray-700"></p>
                <p class="mt-4 text-sm text-gray-600">Your request will be forwarded to the admin for approval.</p>
            </div>
            <!-- Modal footer -->
            <div class="flex items-center justify-end p-4 border-t border-gray-200">
                <button type="button" onclick="document.getElementById('editInsufficientStockModal').classList.add('hidden')"
                    class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                    Continue
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Item Not Found Modal -->
<div id="editItemNotFoundModal" style="min-height:100vh; background-color: rgba(0, 0, 0, 0.5);" tabindex="-1" aria-hidden="true"
    class="modalBg flex fixed top-0 left-0 right-0 bottom-0 z-50 p-4 w-full md:inset-0 hidden">
    <div class="relative my-auto mx-auto p-4 w-full max-w-md h-full md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 border-b rounded-t bg-red-500">
                <h3 class="text-xl font-semibold text-white">
                    Item Not Found in Inventory
                </h3>
                <button type="button" onclick="document.getElementById('editItemNotFoundModal').classList.add('hidden')"
                    class="text-white bg-transparent hover:bg-red-600 hover:text-gray-100 rounded-lg text-sm w-8 h-8 flex items-center justify-center">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-6">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="flex-shrink-0">
                        <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <p id="editItemNotFoundMessage" class="text-gray-700 font-medium"></p>
                        <p class="text-sm text-gray-500 mt-1">Please try searching with a different keyword or check if the item name is correct.</p>
                    </div>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="flex items-center justify-end p-4 border-t border-gray-200">
                <button type="button" onclick="document.getElementById('editItemNotFoundModal').classList.add('hidden')"
                    class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-sm font-medium px-5 py-2.5 hover:scale-105 transition-all duration-200">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Add Brand Modal -->
<x-add-item-modal 
    title="Add New Brand"
    id="add-brand-modal"
    route="{{ route('brand.add') }}"
    field="brand"
/>

<!-- Add Unit Modal -->
<x-add-item-modal 
    title="Add New Unit"
    id="add-unit-modal"
    route="{{ route('unit.add') }}"
    field="unit"
/>

<!-- Add Supplier Modal -->
<x-add-item-modal 
    title="Add New Supplier"
    id="add-supplier-modal"
    route="{{ route('supplier.add') }}"
    field="supplier"
/>

<script>
    let editSelectedItemData = null;
    let editSearchTimeout = null;

    function searchEditItems(query) {
        if (editSearchTimeout) {
            clearTimeout(editSearchTimeout);
        }

        const suggestionsContainer = document.getElementById('edit-suggestions-container');
        const loadingSpinner = document.getElementById('edit-suggestions-loading');
        const suggestionsList = document.getElementById('edit-suggestions-list');

        if (!query.trim()) {
            suggestionsContainer.classList.add('hidden');
            return;
        }

        suggestionsContainer.classList.remove('hidden');
        loadingSpinner.classList.remove('hidden');
        suggestionsList.classList.add('hidden');

        editSearchTimeout = setTimeout(() => {
            fetch('{{ url("/inventory/search-items") }}?query=' + encodeURIComponent(query))
                .then(response => response.json())
                .then(items => {
                    loadingSpinner.classList.add('hidden');
                    suggestionsList.classList.remove('hidden');
                    
                    if (!items || items.length === 0) {
                        suggestionsList.innerHTML = '<li class="px-4 py-2 text-gray-500">No items found</li>';
                        return;
                    }

                    suggestionsList.innerHTML = '';
                    items.forEach(item => {
                        const li = document.createElement('li');
                        li.className = 'px-4 py-2 hover:bg-blue-50 cursor-pointer';
                        const displayName = `${item.brand} - ${item.items_specs}`;
                        li.innerHTML = `
                            <div class="flex justify-between items-center">
                                <div>
                                    <span class="font-medium">${displayName}</span>
                                    <span class="text-gray-500">(${item.unit})</span>
                                </div>
                                <div class="text-right">
                                    <span class="text-blue-600">${formatPrice(item.price)}</span>
                                    <span class="text-gray-500 ml-2">${item.quantity} left${item.quantity == 0 ? ' <span class="text-red-500 font-medium">(Pre-Order)</span>' : ''}</span>
                                </div>
                            </div>
                        `;
                        li.addEventListener('click', () => {
                            document.getElementById('edit_item_name').value = displayName;
                            editSelectedItemData = {
                                name: displayName,
                                unit: item.unit,
                                price: item.price,
                                quantity: item.quantity
                            };
                            document.getElementById('edit_item_quantity').value = '1';
                            suggestionsContainer.classList.add('hidden');
                            document.getElementById('edit_item_quantity').focus();
                        });
                        suggestionsList.appendChild(li);
                    });
                })
                .catch(error => {
                    console.error('Error fetching items:', error);
                    loadingSpinner.classList.add('hidden');
                    suggestionsList.classList.remove('hidden');
                    suggestionsList.innerHTML = '<li class="px-4 py-2 text-red-500">Error loading items</li>';
                });
        }, 300);
    }

    function updateEditModalTotal() {
        let total = 0;
        const rows = document.querySelectorAll('#edit-items-table-body tr');
        
        rows.forEach(row => {
            const unitPrice = parseFloat(row.getAttribute('data-unit-price'));
            const quantity = parseFloat(row.querySelector('input[type="number"]').value);
            
            if (!isNaN(unitPrice) && !isNaN(quantity)) {
                total += unitPrice * quantity;
            }
        });
        
        document.getElementById('edit-modal-total').textContent = formatPrice(total);
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Add event listeners for the edit modal
        const editItemNameInput = document.getElementById('edit_item_name');
        const editSuggestionsContainer = document.getElementById('edit-suggestions-container');
        
        if (editItemNameInput) {
            editItemNameInput.addEventListener('input', function() {
                searchEditItems(this.value.trim());
            });
        }

        // Close suggestions when clicking outside
        document.addEventListener('click', function(e) {
            if (!editItemNameInput?.contains(e.target) && !editSuggestionsContainer?.contains(e.target)) {
                editSuggestionsContainer?.classList.add('hidden');
            }
        });

        // Add event listener for quantity changes
        document.querySelectorAll('#edit-items-table-body input[type="number"]').forEach(input => {
            input.addEventListener('change', updateEditModalTotal);
        });

        // Add event listener for the add item button in edit modal
        const editAddItemButton = document.getElementById('edit-add-item-button');
        if (editAddItemButton) {
            editAddItemButton.addEventListener('click', function(e) {
                e.preventDefault();
                const itemName = document.getElementById('edit_item_name').value.trim();
                const itemQuantity = parseInt(document.getElementById('edit_item_quantity').value);

                if (!itemName || !itemQuantity || itemQuantity < 1) {
                    document.getElementById('editValidationModal').classList.remove('hidden');
                    return;
                }

                if (!editSelectedItemData) {
                    document.getElementById('editItemNotFoundModal').classList.remove('hidden');
                    return;
                }

                if (editSelectedItemData.quantity < itemQuantity) {
                    const message = `Insufficient stock for ${itemName}. Current stock: ${editSelectedItemData.quantity}. Your request: ${itemQuantity}.`;
                    document.getElementById('editInsufficientStockMessage').textContent = message;
                    document.getElementById('editInsufficientStockModal').classList.remove('hidden');
                }

                const totalPrice = calculateTotalPrice(itemQuantity, editSelectedItemData.price);

                const newRow = document.createElement('tr');
                newRow.setAttribute('data-request-id', editSelectedItemData.request_id);
                newRow.setAttribute('data-name', itemName);
                newRow.setAttribute('data-quantity', itemQuantity);
                newRow.setAttribute('data-unit', editSelectedItemData.unit);
                newRow.setAttribute('data-unit-price', editSelectedItemData.price);
                
                newRow.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${itemName}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${editSelectedItemData.unit}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${formatPrice(editSelectedItemData.price)}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${itemQuantity}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${formatPrice(totalPrice)}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                        <button type="button" class="delete-row-button inline-flex items-center p-2 border border-transparent rounded-full text-red-600 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150 ease-in-out">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </td>
                `;

                // Add delete functionality to the new row
                const deleteButton = newRow.querySelector('.delete-row-button');
                deleteButton.addEventListener('click', function() {
                    newRow.remove();
                    updateEditModalTotal();
                });

                // Add quantity change listener
                const quantityInput = newRow.querySelector('input[type="number"]');
                quantityInput.addEventListener('change', updateEditModalTotal);

                document.getElementById('edit-items-table-body').appendChild(newRow);
                updateEditModalTotal();

                // Clear input fields and selected item data
                document.getElementById('edit_item_name').value = '';
                document.getElementById('edit_item_quantity').value = '';
                editSelectedItemData = null;
                document.getElementById('edit_item_name').focus();
            });
        }

        // Add delete functionality to existing rows
        document.querySelectorAll('#edit-items-table-body .delete-row-button').forEach(button => {
            button.addEventListener('click', function() {
                this.closest('tr').remove();
                updateEditModalTotal();
            });
        });

        // Handle edit form submission
        const editRequestForm = document.getElementById('edit-request-form');
        if (editRequestForm) {
            editRequestForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Get all rows from the table
                const rows = document.querySelectorAll('#edit-items-table-body tr');
                if (rows.length === 0) {
                    alert('Please add at least one item to the request');
                    return;
                }

                const existingItems = [];
                const newItems = [];

                // Collect all items (both existing and new)
                Array.from(rows).forEach(row => {
                    const quantity = row.querySelector('input[type="number"]').value;
                    const requestId = row.getAttribute('data-request-id');
                    
                    if (requestId) {
                        // Existing items
                        existingItems.push({
                            request_id: requestId,
                            quantity: parseInt(quantity)
                        });
                    } else {
                        // New items
                        newItems.push({
                            name: row.getAttribute('data-name'),
                            quantity: parseInt(quantity),
                            unit: row.getAttribute('data-unit'),
                            unit_price: parseFloat(row.getAttribute('data-unit-price'))
                        });
                    }
                });

                // Send the request using fetch
                fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        _method: 'PUT',
                        items: JSON.stringify(existingItems),
                        new_items: JSON.stringify(newItems)
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        alert(data.message || 'Error updating request');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while updating the request');
                });
            });
        }
    });

    function showQuantityValidationModal(maxQuantity) {
        document.getElementById('maxQuantitySpan').textContent = maxQuantity;
        document.getElementById('quantityValidationModal').classList.remove('hidden');
    }
    
    function closeQuantityValidationModal() {
        document.getElementById('quantityValidationModal').classList.add('hidden');
    }

    function showValidationModal() {
        const modal = document.getElementById('validationModal');
        modal.classList.remove('hidden');
    }
    
    document.querySelectorAll('.close-validation-modal').forEach(button => {
        button.addEventListener('click', function() {
            document.getElementById('validationModal').classList.add('hidden');
        });
    });

    function submitForm() {
        const form = document.getElementById('supply-request-form');
        form.submit();
    }

    function formatPrice(price) {
        if (!price || isNaN(price)) return 'N/A';
        return new Intl.NumberFormat('en-PH', {
            style: 'currency',
            currency: 'PHP'
        }).format(price);
    }

    function calculateTotalPrice(quantity, unitPrice) {
        if (!unitPrice || isNaN(unitPrice)) return 'N/A';
        return quantity * unitPrice;
    }

    function calculateOverallTotal(tableBody) {
        let total = 0;
        const rows = tableBody.querySelectorAll('tr');
        
        rows.forEach(row => {
            const unitPrice = row.getAttribute('data-unit-price');
            const quantity = row.getAttribute('data-quantity');
            
            if (unitPrice && unitPrice !== 'N/A' && !isNaN(unitPrice)) {
                total += parseFloat(unitPrice) * parseFloat(quantity);
            }
        });
        
        return total;
    }

    function updateOverallTotals() {
        // Update modal total
        const modalTableBody = document.getElementById('added-items-table-body');
        const modalTotal = calculateOverallTotal(modalTableBody);
        document.getElementById('modal-overall-total').textContent = formatPrice(modalTotal);

        // Update main view total
        const mainTableBody = document.getElementById('selected-items');
        const mainTotal = calculateOverallTotal(mainTableBody);
        document.getElementById('main-overall-total').textContent = formatPrice(mainTotal);
    }

    function updateSelectedItems() {
        const rows = document.querySelectorAll('#added-items-table tbody tr');
        const items = [];

        rows.forEach(row => {
            const isNewItem = row.getAttribute('data-is-new-item') === 'true';
            const item = {
                name: row.getAttribute('data-name'),
                quantity: row.getAttribute('data-quantity'),
                is_new_item: isNewItem
            };

            if (isNewItem) {
                item.brand_id = row.getAttribute('data-brand-id');
                item.unit_id = row.getAttribute('data-unit-id');
                item.supplier_id = row.getAttribute('data-supplier-id');
                item.unit_price = row.getAttribute('data-unit-price');
            }

            items.push(item);
        });

        document.querySelector('#selected_items').value = JSON.stringify({ items: items });
    }

    function showInsufficientStockModal(itemName, currentStock, requestedQuantity, unit) {
        const message = `Insufficient stock for ${itemName}. Current stock: ${currentStock}. Your request: ${requestedQuantity}.`;
        document.getElementById('insufficientStockMessage').textContent = message;
        document.getElementById('insufficientStockModal').classList.remove('hidden');
    }

    function closeInsufficientStockModal() {
        document.getElementById('insufficientStockModal').classList.add('hidden');
    }

    let searchTimeout = null;
    let selectedItemData = null;

    function updateQuantityField(selectedItem) {
        const quantityInput = document.getElementById('new_item_quantity');
        quantityInput.value = 1;
    }

    function searchItems(query) {
        if (searchTimeout) {
            clearTimeout(searchTimeout);
        }

        const suggestionsContainer = document.getElementById('suggestions-container');
        const loadingSpinner = document.getElementById('suggestions-loading');
        const suggestionsList = document.getElementById('suggestions-list');

        if (!query.trim()) {
            suggestionsContainer.classList.add('hidden');
            return;
        }

        // Show loading spinner and container
        suggestionsContainer.classList.remove('hidden');
        loadingSpinner.classList.remove('hidden');
        suggestionsList.classList.add('hidden');

        searchTimeout = setTimeout(() => {
            console.log('Searching for:', query);
            const url = '{{ url("/inventory/search-items") }}?query=' + encodeURIComponent(query);
            console.log('Fetching from:', url);
            
            fetch(url)
                .then(response => {
                    console.log('Response status:', response.status);
                    console.log('Response headers:', response.headers);
                    return response.text().then(text => {
                        try {
                            console.log('Raw response:', text);
                            return JSON.parse(text);
                        } catch (e) {
                            console.error('JSON parse error:', e);
                            throw new Error('Invalid JSON response');
                        }
                    });
                })
                .then(items => {
                    console.log('Parsed items:', items);
                    
                    // Hide loading spinner and show suggestions list
                    loadingSpinner.classList.add('hidden');
                    suggestionsList.classList.remove('hidden');
                    
                    if (!items || items.length === 0) {
                        suggestionsList.innerHTML = '<li class="px-4 py-2 text-gray-500">No items found</li>';
                        return;
                    }

                    suggestionsList.innerHTML = '';
                    items.forEach(item => {
                        const li = document.createElement('li');
                        li.className = 'px-4 py-2 hover:bg-blue-50 cursor-pointer';
                        const displayName = `${item.brand} - ${item.items_specs}`;
                        li.innerHTML = `
                            <div class="flex justify-between items-center">
                                <div>
                                    <span class="font-medium">${displayName}</span>
                                    <span class="text-gray-500">(${item.unit})</span>
                                </div>
                                <div class="text-right">
                                    <span class="text-blue-600">${formatPrice(item.price)}</span>
                                    <span class="text-gray-500 ml-2">${item.quantity} left${item.quantity == 0 ? ' <span class="text-red-500 font-medium">(Pre-Order)</span>' : ''}</span>
                                </div>
                            </div>
                        `;
                        li.addEventListener('click', () => {
                            document.getElementById('new_item_name').value = displayName;
                            selectedItemData = {
                                name: displayName,
                                unit: item.unit,
                                price: item.price,
                                quantity: item.quantity
                            };
                            updateQuantityField(selectedItemData);
                            suggestionsContainer.classList.add('hidden');
                            document.getElementById('new_item_quantity').focus();
                        });
                        suggestionsList.appendChild(li);
                    });
                })
                .catch(error => {
                    console.error('Error fetching items:', error);
                    loadingSpinner.classList.add('hidden');
                    suggestionsList.classList.remove('hidden');
                    suggestionsList.innerHTML = '<li class="px-4 py-2 text-red-500">Error loading items</li>';
                });
        }, 300);
    }

    function showItemNotFoundModal(itemName) {
        // Get the values from the add item form
        const itemNameInput = document.getElementById('new_item_name').value;
        const quantityInput = document.getElementById('new_item_quantity').value;

        // Set the values in the Item Not Found modal
        document.getElementById('items_specs_not_found').value = itemNameInput;
        document.getElementById('quantity_not_found').value = quantityInput;

        document.getElementById('itemNotFoundMessage').textContent = `The item you requested is not in the inventory. Please provide more details for approval.`;
        document.getElementById('itemNotFoundModal').classList.remove('hidden');
    }

    function populateDropdowns() {
        // Populate brands dropdown
        fetch('{{ route("inventory.brands") }}')
            .then(response => response.json())
            .then(brands => {
                const brandSelect = document.getElementById('brand_id_not_found');
                brands.forEach(brand => {
                    const option = new Option(brand.brand, brand.id);
                    brandSelect.add(option);
                });
            });

        // Populate units dropdown
        fetch('{{ route("inventory.units") }}')
            .then(response => response.json())
            .then(units => {
                const unitSelect = document.getElementById('unit_id_not_found');
                units.forEach(unit => {
                    const option = new Option(unit.unit, unit.id);
                    unitSelect.add(option);
                });
            });

        // Populate suppliers dropdown
        fetch('{{ route("inventory.suppliers") }}')
            .then(response => response.json())
            .then(suppliers => {
                const supplierSelect = document.getElementById('supplier_id_not_found');
                suppliers.forEach(supplier => {
                    const option = new Option(supplier.supplier, supplier.id);
                    supplierSelect.add(option);
                });
            });
    }

    function submitRequestedItem(event) {
        event.preventDefault();
        
        const formData = {
            brand_id: document.getElementById('brand_id_not_found').value,
            items_specs: document.getElementById('items_specs_not_found').value,
            unit_id: document.getElementById('unit_id_not_found').value,
            quantity: document.getElementById('quantity_not_found').value,
            unit_price: document.getElementById('unit_price_not_found').value,
            supplier_id: document.getElementById('supplier_id_not_found').value,
        };

        fetch('{{ route("inventory.request.item.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('itemNotFoundModal').classList.add('hidden');
                // You might want to show a success message here
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // You might want to show an error message here
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        console.log('DOM Content Loaded');
        // Set default request date to today
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();
        today = yyyy + '-' + mm + '-' + dd;
        document.getElementById('request_date').value = today;

        let rowCounter = 0;
        const addItemButton = document.getElementById('add-item-button');
        const addedItemsTableBody = document.getElementById('added-items-table-body');
        const modal = document.getElementById('defaultModal');
        const form = document.getElementById('supply-request-form');

        // Prevent form submission on enter key in the modal
        modal.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                if (document.activeElement === document.getElementById('new_item_name') ||
                    document.activeElement === document.getElementById('new_item_quantity')) {
                    addItemButton.click();
                }
                return false;
            }
        });

        // Handle form submission
        const supplyRequestForm = document.getElementById('supply-request-form');
        const submitButton = document.getElementById('submit-request-button');

        submitButton.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Get all items from the table
            const rows = document.querySelectorAll('#added-items-table tbody tr');
            if (rows.length === 0) {
                document.getElementById('validationModal').classList.remove('hidden');
                return;
            }

            const items = [];
            rows.forEach(row => {
                const isNewItem = row.getAttribute('data-is-new-item') === 'true';
                const item = {
                    name: row.getAttribute('data-name'),
                    quantity: row.getAttribute('data-quantity'),
                    is_new_item: isNewItem
                };

                if (isNewItem) {
                    item.brand_id = row.getAttribute('data-brand-id');
                    item.unit_id = row.getAttribute('data-unit-id');
                    item.supplier_id = row.getAttribute('data-supplier-id');
                    item.unit_price = row.getAttribute('data-unit-price');
                }

                items.push(item);
            });

            // Set the items data in the hidden input
            document.getElementById('selected_items').value = JSON.stringify({ items: items });
            
            // Submit the form
            supplyRequestForm.submit();
        });

        // Close modal buttons
        document.querySelectorAll('.close-modal-button').forEach(button => {
            button.addEventListener('click', function() {
                modal.classList.add('hidden');
            });
        });

        // Done button
        document.querySelector('.done-button').addEventListener('click', function() {
            updateSelectedItems();
            modal.classList.add('hidden');
        });

        addItemButton.addEventListener('click', function(e) {
            e.preventDefault();
            const itemName = document.getElementById('new_item_name').value.trim();
            const itemQuantity = parseInt(document.getElementById('new_item_quantity').value);

            if (!itemName || !itemQuantity || itemQuantity < 1) {
                showValidationModal();
                return;
            }

            // Check if we have selected item data
            if (!selectedItemData) {
                showItemNotFoundModal(itemName);
                return;
            }

            // Show warning if quantity exceeds available stock
            if (selectedItemData.quantity < itemQuantity) {
                showInsufficientStockModal(itemName, selectedItemData.quantity, itemQuantity, selectedItemData.unit);
            }

            const totalPrice = calculateTotalPrice(itemQuantity, selectedItemData.price);

            const newRow = document.createElement('tr');
            newRow.setAttribute('data-name', itemName);
            newRow.setAttribute('data-quantity', itemQuantity);
            newRow.setAttribute('data-unit', selectedItemData.unit);
            newRow.setAttribute('data-unit-price', selectedItemData.price);
            
            newRow.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${itemName}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${selectedItemData.unit}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${formatPrice(selectedItemData.price)}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${itemQuantity}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${formatPrice(totalPrice)}</td>
                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                    <button type="button" class="delete-row-button inline-flex items-center p-2 border border-transparent rounded-full text-red-600 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150 ease-in-out">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </td>
            `;

            // Add delete functionality to the new row
            const deleteButton = newRow.querySelector('.delete-row-button');
            deleteButton.addEventListener('click', function() {
                newRow.remove();
                updateSelectedItems();
                updateOverallTotals();
            });

            addedItemsTableBody.appendChild(newRow);
            updateSelectedItems();
            updateOverallTotals();

            // Clear input fields and selected item data
            document.getElementById('new_item_name').value = '';
            document.getElementById('new_item_quantity').value = '';
            selectedItemData = null;
            document.getElementById('new_item_name').focus();
            
            rowCounter++;
        });

        // Add event listener for opening the modal
        document.querySelector('button[onclick*="defaultModal"]').addEventListener('click', function(e) {
            e.preventDefault();
            modal.classList.remove('hidden');
            setTimeout(() => {
                document.getElementById('new_item_name').focus();
            }, 100);
        });

        // Add submit button handler
        document.getElementById('submit-request-button').addEventListener('click', function(e) {
            e.preventDefault();
            submitForm();
        });

        const itemNameInput = document.getElementById('new_item_name');
        const suggestionsContainer = document.getElementById('suggestions-container');

        if (!itemNameInput) {
            console.error('Item name input not found!');
            return;
        }

        // Add input event listener for search
        itemNameInput.addEventListener('input', function() {
            const query = this.value.trim();
            console.log('Input event triggered:', query);
            searchItems(query);
        });

        // Close suggestions when clicking outside
        document.addEventListener('click', function(e) {
            if (!itemNameInput.contains(e.target) && !suggestionsContainer.contains(e.target)) {
                suggestionsContainer.classList.add('hidden');
            }
        });

        // Add event listeners for the new modal's close buttons
        document.getElementById('itemNotFoundModal').querySelectorAll('.item-not-found-close-button').forEach(button => {
            button.addEventListener('click', function() {
                document.getElementById('itemNotFoundModal').classList.add('hidden');
            });
        });

        // Add form submit handler
        const requestedItemForm = document.querySelector('#itemNotFoundModal form');
        requestedItemForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const brandSelect = document.getElementById('brand_id_not_found');
            const unitSelect = document.getElementById('unit_id_not_found');
            const brandText = brandSelect.options[brandSelect.selectedIndex].text;
            const itemSpecs = document.getElementById('items_specs_not_found').value;
            const unitText = unitSelect.options[unitSelect.selectedIndex].text;
            const quantity = document.getElementById('quantity_not_found').value;
            const unitPrice = document.getElementById('unit_price_not_found').value;
            const totalPrice = calculateTotalPrice(quantity, unitPrice);

            // Create new row
            const newRow = document.createElement('tr');
            const displayName = `${brandText} - ${itemSpecs}`;
            newRow.setAttribute('data-name', displayName);
            newRow.setAttribute('data-quantity', quantity);
            newRow.setAttribute('data-unit', unitText);
            newRow.setAttribute('data-unit-price', unitPrice);
            newRow.setAttribute('data-is-new-item', 'true');
            newRow.setAttribute('data-brand-id', brandSelect.value);
            newRow.setAttribute('data-unit-id', unitSelect.value);
            newRow.setAttribute('data-supplier-id', document.getElementById('supplier_id_not_found').value);
            
            newRow.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${displayName}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${unitText}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${formatPrice(unitPrice)}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${quantity}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${formatPrice(totalPrice)}</td>
                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                    <button type="button" class="delete-row-button inline-flex items-center p-2 border border-transparent rounded-full text-red-600 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150 ease-in-out">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </td>
            `;

            // Add delete functionality to the new row
            const deleteButton = newRow.querySelector('.delete-row-button');
            deleteButton.addEventListener('click', function() {
                newRow.remove();
                updateSelectedItems();
                updateOverallTotals();
            });

            addedItemsTableBody.appendChild(newRow);
            updateSelectedItems();
            updateOverallTotals();

            // Clear form and close modal
            requestedItemForm.reset();
            document.getElementById('itemNotFoundModal').classList.add('hidden');
        });
    });
</script>
@endsection
