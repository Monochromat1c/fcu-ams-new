@extends('layouts.layout')
@section('content')
<link rel="stylesheet" href="{{ asset('css/stockin.css') }}">
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

<div class="grid grid-cols-6">
    @include('layouts.sidebar')
    <div class="content min-h-screen bg-slate-200 col-span-5">
        <!-- Header -->
        <div class="bg-white m-3 shadow-md rounded-md 2xl:max-w-7xl 2xl:mx-auto">
            <div class="px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex justify-between items-center">
                    <div class="flex items-center justify-between w-full">
                        <a href="{{ Auth::user()->role->role === 'Viewer' ? route('inventory.my.requests') : route('requests.index') }}"
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
                        @if($allItemsApproved)
                        
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
                @if(Auth::user()->role->role !== 'Viewer')
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
                                {{ $overallStatus === 'approved' || $overallStatus === 'rejected' ? 'disabled' : '' }}
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
                        <!-- Edit button -->
                        <button type="button" 
                            {{ $requests->first()->status === 'approved' || $requests->first()->status === 'rejected' || $requests->first()->status === 'cancelled' ? 'disabled' : '' }}
                            class="inline-flex items-center px-4 py-2 bg-white border-2 border-blue-500 hover:bg-blue-500 text-blue-600 hover:text-white text-sm font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200 ease-in-out disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:bg-white disabled:hover:text-blue-600">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit
                        </button>
                        <!-- Cancel button -->
                        <form action="{{ route('inventory.supply-request.cancel', ['request_group_id' => $requests->first()->request_group_id]) }}" method="POST">
                            @csrf
                            <button type="submit"
                                {{ $requests->first()->status === 'approved' || $requests->first()->status === 'rejected' || $requests->first()->status === 'cancelled' ? 'disabled' : '' }}
                                class="inline-flex items-center px-4 py-2 bg-white border-2 border-red-500 hover:bg-red-500 text-red-600 hover:text-white text-sm font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200 ease-in-out disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:bg-white disabled:hover:text-red-600">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Cancel
                            </button>
                        </form>
                    </div>
                @endif
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <div class="space-y-3">
                        <div>
                            <span class="font-medium">Requester:</span>
                            <span class="ml-2">{{ $requests->first()->requester }}</span>
                        </div>
                        <div>
                            <span class="font-medium">Department:</span>
                            <span class="ml-2">{{ $requests->first()->department->department }}</span>
                        </div>
                        <div>
                            <span class="font-medium">Request Date:</span>
                            <span class="ml-2">{{ \Carbon\Carbon::parse($requests->first()->request_date)->format('M d, Y') }}</span>
                        </div>
                        <div>
                            <span class="font-medium">Status:</span>
                            <span class="ml-2 px-3 py-1 text-xs font-medium rounded-full
                                {{ $overallStatus === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                   ($overallStatus === 'approved' ? 'bg-green-100 text-green-800' : 
                                   ($overallStatus === 'partially_approved' ? 'bg-blue-100 text-blue-800' :
                                   ($overallStatus === 'cancelled' ? 'bg-gray-100 text-gray-800' :
                                   'bg-red-100 text-red-800'))) }}">
                                {{ ucfirst(str_replace('_', ' ', $overallStatus)) }}
                            </span>
                        </div>
                        <div>
                            <span class="font-medium">Note:</span>
                            <span class="ml-2">{{ $requests->first()->notes }}</span>
                        </div>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Summary</h3>
                    <div class="space-y-3">
                        <div>
                            <span class="font-medium">Total Items:</span>
                            <span class="ml-2">{{ $totalItems }}</span>
                        </div>
                        <div>
                            <span class="font-medium">Total Price:</span>
                            <span class="ml-2">₱{{ number_format($totalPrice, 2) }}</span>
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
@endsection
