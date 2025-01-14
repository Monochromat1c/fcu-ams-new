@extends('layouts.layout')
@section('content')
<link rel="stylesheet" href="{{ asset('css/stockin.css') }}">
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

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
            <h1 class="my-auto text-3xl">Notifications</h1>
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
            </div>
        </nav>

        <div class="bg-white m-3 shadow-md rounded-md p-6">
            <div class="space-y-4">
                @forelse($notifications as $notification)
                    <div class="p-4 rounded-lg border-l-4 flex items-start gap-4 {{ 
                        $notification->primary_status === 'approved' ? 'border-green-500 bg-green-50' : 
                        ($notification->primary_status === 'rejected' ? 'border-red-500 bg-red-50' : 
                        ($notification->primary_status === 'cancelled' ? 'border-gray-500 bg-gray-50' : 
                        ($notification->primary_status === 'partially_approved' ? 'border-blue-500 bg-blue-50' :
                        'border-yellow-500 bg-yellow-50'))) 
                    }}">
                        <!-- Status Icon -->
                        <div class="flex-shrink-0">
                            @if($notification->primary_status === 'approved')
                                <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            @elseif($notification->primary_status === 'rejected')
                                <svg class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            @elseif($notification->primary_status === 'cancelled')
                                <svg class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            @elseif($notification->primary_status === 'partially_approved')
                                <svg class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                </svg>
                            @else
                                <svg class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            @endif
                        </div>
        
                        <!-- Content -->
                        <div class="flex-1">
                            <div class="flex justify-between">
                                <p class="text-sm font-medium">
                                    Your request #{{ $notification->request_group_id }} {{ 
                                        $notification->primary_status === 'approved' ? 'has been approved' : 
                                        ($notification->primary_status === 'rejected' ? 'has been rejected' : 
                                        ($notification->primary_status === 'cancelled' ? 'has been cancelled' : 
                                        ($notification->primary_status === 'partially_approved' ? 'has been partially approved' :
                                        'is pending approval'))) 
                                    }}
                                </p>
                                <p class="text-sm text-gray-500">{{ $notification->created_at->format('M d, Y h:i A') }}</p>
                            </div>
                            <p class="mt-1 text-sm text-gray-600">{{ $notification->items_count }} item(s) requested</p>
                            @if($notification->notes)
                                <p class="mt-2 text-sm text-gray-600">Notes: {{ $notification->notes }}</p>
                            @endif
                            <a href="{{ route('inventory.supply-request.details', $notification->request_group_id) }}" 
                                        class="inline-flex items-center mt-2 text-sm text-blue-600 hover:text-blue-800">
                                        <span>View Details</span>
                                        <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <p class="mt-4 text-lg font-medium text-gray-900">No notifications</p>
                        <p class="mt-1 text-sm text-gray-500">You don't have any notifications at the moment.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
