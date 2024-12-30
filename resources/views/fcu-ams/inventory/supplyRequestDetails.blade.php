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
                <div class="flex justify-between">
                    <a href="{{ url()->previous() }}"
                    class="mr-4 hover:bg-gray-100 my-auto p-2 rounded-full transition">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
                    <h1 class="text-2xl font-semibold text-gray-900 my-auto mx-auto">Supply Request Details</h1>
                    <div class="flex items-center space-x-3">
                        @if($requests->first()->status === 'pending' && Auth::user()->role->role !== 'Viewer')
                            <form action="{{ route('inventory.supply-request.approve', ['request_group_id' => $requests->first()->request_group_id]) }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="return_url" value="{{ url()->previous() }}">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 text-white text-sm font-medium rounded-md shadow-sm hover:shadow-md transition-all duration-200 ease-in-out">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Approve
                                </button>
                            </form>
                            <form action="{{ route('inventory.supply-request.reject', ['request_group_id' => $requests->first()->request_group_id]) }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="return_url" value="{{ url()->previous() }}">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-300 text-white text-sm font-medium rounded-md shadow-sm hover:shadow-md transition-all duration-200 ease-in-out">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Reject
                                </button>
                            </form>
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
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <h3 class="text-lg font-semibold mb-4">Request Information</h3>
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
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
