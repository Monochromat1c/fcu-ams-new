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
                        $notification->status === 'approved' ? 'border-green-500 bg-green-50' : 
                        ($notification->status === 'rejected' ? 'border-red-500 bg-red-50' : 
                        ($notification->status === 'cancelled' ? 'border-gray-500 bg-gray-50' : 
                        'border-yellow-500 bg-yellow-50')) 
                    }}">
                        <!-- Status Icon -->
                        <div class="flex-shrink-0">
                            @if($notification->status === 'approved')
                                <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            @elseif($notification->status === 'rejected')
                                <svg class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            @elseif($notification->status === 'cancelled')
                                <svg class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            @else
                                <svg class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            @endif
                        </div>

                        <!-- Notification Content -->
                        <div class="flex-1">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="text-sm font-medium {{ 
                                        $notification->status === 'approved' ? 'text-green-800' : 
                                        ($notification->status === 'rejected' ? 'text-red-800' : 
                                        ($notification->status === 'cancelled' ? 'text-gray-800' : 
                                        'text-yellow-800')) 
                                    }}">
                                        @if($notification->status === 'approved')
                                            Your request #{{ $notification->request_group_id }} has been approved
                                        @elseif($notification->status === 'rejected')
                                            Your request #{{ $notification->request_group_id }} has been rejected
                                        @elseif($notification->status === 'cancelled')
                                            Your request #{{ $notification->request_group_id }} has been cancelled
                                        @else
                                            Your request #{{ $notification->request_group_id }} is pending approval
                                        @endif
                                    </p>
                                    <p class="mt-1 text-sm text-gray-600">
                                        {{ $notification->items_count }} {{ Str::plural('item', $notification->items_count) }} requested
                                    </p>
                                    @if($notification->notes)
                                        <p class="mt-1 text-sm text-gray-600">
                                            Notes: {{ $notification->notes }}
                                        </p>
                                    @endif
                                    <a href="{{ route('inventory.supply-request.details', $notification->request_group_id) }}" 
                                        class="inline-flex items-center mt-2 text-sm text-blue-600 hover:text-blue-800">
                                        <span>View Details</span>
                                        <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                                <div class="flex flex-col items-end">
                                    <span class="text-sm text-gray-500">
                                        Requested: {{ date('Y-m-d h:i A', strtotime($notification->request_date)) }}
                                    </span>
                                    <span class="text-sm text-gray-500">
                                        Updated: {{ date('Y-m-d h:i A', strtotime($notification->updated_at)) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <p class="mt-4 text-lg font-medium text-gray-900">No notifications</p>
                        <p class="mt-2 text-sm text-gray-500">You don't have any notifications at the moment.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
