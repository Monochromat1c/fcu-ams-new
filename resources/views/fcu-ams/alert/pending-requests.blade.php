@extends('layouts.layout')
@section('content')
<link rel="stylesheet" href="{{ asset('css/asset.css') }}">

<div class="grid grid-cols-6">
    @include('layouts.sidebar')
    <div class="content min-h-screen bg-slate-200 col-span-5">
        <nav class="bg-white flex justify-between py-3 px-4 m-3 shadow-md rounded-md">
            <div class="flex items-center">
                <a href="{{ route('alerts.index') }}"
                    class="mr-4 hover:bg-gray-100 p-2 rounded-full transition">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <h1 class="text-3xl font-semibold text-gray-800">Pending Supply Requests</h1>
            </div>
        </nav>

        <div class="bg-white p-6 m-3 rounded-md shadow-md">
            @if($pendingRequests->isEmpty())
                <div class="text-center py-8">
                    <p class="text-gray-500 text-lg">No pending supply requests found.</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($pendingRequests as $request)
                        <div class="bg-yellow-50 p-6 rounded-lg border border-yellow-200 relative">
                            <div class="absolute top-4 right-4">
                                <a href="{{ route('inventory.supply-request.details', ['request_group_id' => $request->request_group_id]) }}"
                                    class="text-yellow-600 hover:text-yellow-800">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg>
                                </a>
                            </div>
                            <div class="space-y-4">
                                <div class="flex justify-between items-center border-b border-yellow-200 pb-2">
                                    <label class="font-semibold text-gray-600 w-1/3">Requester:</label>
                                    <p class="text-gray-800 font-medium w-2/3 text-right">{{ $request->requester }}</p>
                                </div>
                                <div class="flex justify-between items-center border-b border-yellow-200 pb-2">
                                    <label class="font-semibold text-gray-600 w-1/3">Department:</label>
                                    <p class="text-gray-800 font-medium w-2/3 text-right">{{ $request->department->department }}</p>
                                </div>
                                <div class="flex justify-between items-center border-b border-yellow-200 pb-2">
                                    <label class="font-semibold text-gray-600 w-1/3">Items Count:</label>
                                    <p class="text-gray-800 font-medium w-2/3 text-right">
                                        {{ $request->items_count }} {{ Str::plural('item', $request->items_count) }}
                                    </p>
                                </div>
                                <div class="flex justify-between items-center">
                                    <label class="font-semibold text-gray-600 w-1/3">Request Date:</label>
                                    <p class="text-gray-800 font-medium w-2/3 text-right">
                                        {{ \Carbon\Carbon::parse($request->request_date)->format('F d, Y') }}
                                        <span class="text-yellow-600 ml-2">
                                            ({{ \Carbon\Carbon::parse($request->request_date)->diffForHumans() }})
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $pendingRequests->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 