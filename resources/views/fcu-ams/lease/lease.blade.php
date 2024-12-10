@extends('layouts.layout')

@section('content')
<div class="grid grid-cols-6">
    @include('layouts.sidebar')
    <div class="content min-h-screen bg-slate-100 col-span-5">
        <!-- Enhanced Navigation Bar -->
        <nav class="bg-white flex justify-between py-3 px-4 m-3 shadow-md rounded-md">
            <a href="{{ route('profile.index') }}" class="flex gap-3 invisible" style="min-width:100px;">
                <!-- <img src="{{ asset('profile/profile.png') }}" class="w-10 h-10 rounded-full" alt="" srcset=""> -->
                <div>
                     @if(auth()->user()->profile_picture)
                        <img src="{{ asset(auth()->user()->profile_picture) }}" alt="User Profile"
                            class="w-14 h-14  object-cover bg-no-repeat rounded-full mx-auto">
                    @else
                        <img src="{{ asset('profile/defaultProfile.png') }}" alt="Default Image"
                            class="w-14 h-14  object-cover bg-no-repeat rounded-full mx-auto">
                    @endif
                </div>
                <p class="my-auto">
                    {{ (auth()->user() ? auth()->user()->first_name . ' ' . auth()->user()->last_name : 'N/A') }}
                </p>
            </a>
            <h1 class="my-auto text-3xl">Lease Management</h1>
            <a href="{{ route('profile.index') }}" class="flex gap-3" style="min-width:100px;">
                <!-- <img src="{{ asset('profile/profile.png') }}" class="w-10 h-10 rounded-full" alt="" srcset=""> -->
                <div>
                     @if(auth()->user()->profile_picture)
                        <img src="{{ asset(auth()->user()->profile_picture) }}" alt="User Profile"
                            class="w-14 h-14  object-cover bg-no-repeat rounded-full mx-auto">
                    @else
                        <img src="{{ asset('profile/defaultProfile.png') }}" alt="Default Image"
                            class="w-14 h-14  object-cover bg-no-repeat rounded-full mx-auto">
                    @endif
                </div>
                <p class="my-auto">
                    {{ (auth()->user() ? auth()->user()->first_name . ' ' . auth()->user()->last_name : 'N/A') }}
                </p>
            </a>
        </nav>

        <!-- Action Buttons and Pagination -->
        <div class="flex justify-between items-center mx-4 mb-4">
            <div class="flex gap-3">
                <a href="{{ route('lease.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-500 transition-all duration-200 shadow-sm hover:shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Lease Asset
                </a>
            </div>
        </div>

        <div class="m-3">
            @include('layouts.messageWithoutTimerForError')
        </div>

        <!-- Main Content -->
        @if($leases->isEmpty())
        <div class="bg-white p-8 shadow-sm rounded-lg mx-3 border border-gray-100">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Leased Items</h2>
            <div class="flex flex-col items-center justify-center py-12">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
                <p class="text-xl text-gray-500">No leased assets found</p>
            </div>
        </div>
        @else
        <div class="bg-white p-6 shadow-sm rounded-lg mx-4 border border-gray-100">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Leased Items</h2>
                    <p class="text-sm text-gray-500 mt-1">Overview of currently leased assets</p>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr class="bg-gradient-to-r from-blue-400 to-blue-500 text-white">
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                <div class="flex items-center space-x-1">
                                    <span>Customer</span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                <div class="flex items-center space-x-1">
                                    <span>Lease Date</span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                <div class="flex items-center space-x-1">
                                    <span>Lease Expiration</span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                <div class="flex items-center space-x-1">
                                    <span>Assets Count</span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                <div class="flex items-center space-x-1">
                                    <span>Actions</span>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($leases as $lease)
                            <tr class="hover:bg-gray-50 transition-all duration-200">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8 bg-gray-100 rounded-full flex items-center justify-center">
                                            <span class="text-sm font-medium text-gray-600">
                                                {{ strtoupper(substr($lease->customer, 0, 1)) }}
                                            </span>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">{{ $lease->customer }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <span class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($lease->lease_date)->format('M d, Y') }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        @php
                                        $expirationDate = \Carbon\Carbon::parse($lease->lease_expiration);
                                        $daysUntilExpiration = now()->diffInDays($expirationDate, false);
                                        @endphp
                                        <span class="mr-2 text-sm text-gray-900">{{ $expirationDate->format('M d, Y') }}</span>
                                        
                                        @if($daysUntilExpiration < 0)
                                            <span class="inline-flex  items-center px-4 py-2 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Expired
                                            </span>
                                        @elseif($daysUntilExpiration <= 7)
                                            <span class="inline-flex  items-center px-4 py-2 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Expires in {{ $daysUntilExpiration }} days
                                            </span>
                                        @else
                                            <span class="inline-flex  items-center px-4 py-2 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Active
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $lease->assets->count() }} {{ Str::plural('asset', $lease->assets->count()) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-left">
                                    <a href="{{ route('lease.show', $lease->id) }}" class="text-green-600 hover:text-green-900 font-medium text-sm">
                                        View Details
                                        <span class="sr-only">, {{ $lease->customer }}</span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="mt-4 flex items-center justify-between px-4 mb-3">
                <div class="flex items-center gap-2">
                    <a href="{{ $leases->url(1) }}" class="p-2 inline-flex items-center justify-center rounded-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                        </svg>
                    </a>
                    <a href="{{ $leases->previousPageUrl() }}" class="p-2 inline-flex items-center justify-center rounded-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                </div>

                <div class="text-sm text-gray-700">
                    Showing {{ $leases->firstItem() ?? 0 }} to {{ $leases->lastItem() ?? 0 }} of {{ $leases->total() }} items
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ $leases->nextPageUrl() }}" class="p-2 inline-flex items-center justify-center rounded-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    <a href="{{ $leases->url($leases->lastPage()) }}" class="p-2 inline-flex items-center justify-center rounded-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
