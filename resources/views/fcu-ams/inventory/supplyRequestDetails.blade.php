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
                        <a href="javascript:void(0);" onclick="history.back();"
                        class="mr-4 hover:bg-gray-100 my-auto p-2 rounded-full transition">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                        </a>
                        <h1 class="text-2xl font-semibold text-gray-900">Supply Request Details</h1>
                        <a href="javascript:void(0);" onclick="history.back();"
                            class="mr-4 hover:bg-gray-100 my-auto p-2 rounded-full transition invisible">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                        </a>
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
                @if($requests->first()->status === 'pending' && Auth::user()->role->role !== 'Viewer')
                    <div class="flex gap-4">
                        <form action="{{ route('inventory.supply-request.approve', ['request_group_id' => $requests->first()->request_group_id]) }}" method="POST">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-white border-2 border-green-500 hover:bg-green-500 text-green-600 hover:text-white text-sm font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200 ease-in-out">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Approve
                            </button>
                        </form>
                        <!-- approve button -->
                        <form action="{{ route('inventory.supply-request.reject', ['request_group_id' => $requests->first()->request_group_id]) }}" method="POST">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-white border-2 border-red-500 hover:bg-red-500 text-red-600 hover:text-white text-sm font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200 ease-in-out">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Reject
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
                                {{ $requests->first()->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                ($requests->first()->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                'bg-red-100 text-red-800') }}">
                                {{ ucfirst($requests->first()->status) }}
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
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Item</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Quantity</th>
                                <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider">Unit Price</th>
                                <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($requests as $request)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $request->item_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $request->quantity }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                        ₱{{ number_format($request->unit_price, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                        ₱{{ number_format($request->subtotal, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                            <tr class="bg-gray-50">
                                <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-right">
                                    Total:
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600 text-right">
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
