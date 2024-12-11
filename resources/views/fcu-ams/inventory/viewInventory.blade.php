@extends('layouts.layout')
@section('content')
<link rel="stylesheet" href="{{ asset('css/viewInventory.css') }}">
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

<div class="grid grid-cols-6">
    @include('layouts.sidebar')
    <div class="content min-h-screen bg-slate-100 col-span-5">
        <nav class="bg-white flex justify-between py-3 px-4 m-3 shadow-md rounded-md">
            <a href=""
            onclick="window.history.back(); return false;"
            class="mr-4 hover:bg-gray-100 my-auto p-2 rounded-full transition">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="my-auto text-3xl">Inventory</h1>
            <a href="{{ route('profile.index') }}" class="flex gap-3" style="min-width:100px;">
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
        <div class="bg-white p-5 shadow-md m-3 rounded-md">
            <div class="p-3">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Inventory Details</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Basic Info -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-blue-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-800">Basic Information</h3>
                        </div>
                        <div class="grid gap-4">
                            <div class="space-y-1">
                                <label class="text-xs font-medium text-gray-500 uppercase">Items & Specs</label>
                                <p class="text-sm font-medium text-gray-900">{{ $inventory->items_specs }}</p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs font-medium text-gray-500 uppercase">Brand</label>
                                <p class="text-sm font-medium text-gray-900">{{ $inventory->brand->brand }}</p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs font-medium text-gray-500 uppercase">Unit</label>
                                <p class="text-sm font-medium text-gray-900">{{ $inventory->unit->unit }}</p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs font-medium text-gray-500 uppercase">Quantity</label>
                                <p class="text-sm font-medium text-gray-900">{{ $inventory->quantity }}</p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs font-medium text-gray-500 uppercase">Unit Price</label>
                                <p class="text-sm font-medium text-gray-900">₱{{ number_format($inventory->unit_price, 2) }}</p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs font-medium text-gray-500 uppercase">Total Value</label>
                                <p class="text-sm font-medium text-gray-900">₱{{ number_format($inventory->quantity * $inventory->unit_price, 2) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Supplier Info -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-blue-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-800">Supplier Information</h3>
                        </div>
                        <div class="grid gap-4">
                            <div class="space-y-1">
                                <label class="text-xs font-medium text-gray-500 uppercase">Supplier Name</label>
                                <p class="text-sm font-medium text-gray-900">{{ $inventory->supplier->supplier }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($editHistory->isNotEmpty())
            <div class="bg-white p-6 shadow-lg m-3 rounded-lg">
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" 
                            stroke="currentColor" class="w-6 h-6 text-blue-600">
                            <path stroke-linecap="round" stroke-linejoin="round" 
                                d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <h2 class="text-2xl font-bold text-gray-800">Edit History</h2>
                    </div>
                    <span class="text-sm text-gray-500">Showing latest changes</span>
                </div>
                <div class="overflow-hidden rounded-lg border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date & Time
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Modified by
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Changes Made
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($editHistory as $history)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        <div class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                                                stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-gray-400">
                                                <path stroke-linecap="round" stroke-linejoin="round" 
                                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                            </svg>
                                            {{ $history->created_at->format('Y-m-d H:i:s') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-8 w-8">
                                                @if($history->user->profile_picture)
                                                    <img class="h-8 w-8 rounded-full object-cover" 
                                                        src="{{ asset($history->user->profile_picture) }}" alt="">
                                                @else
                                                    <img class="h-8 w-8 rounded-full object-cover" 
                                                        src="{{ asset('profile/defaultProfile.png') }}" alt="">
                                                @endif
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900">
                                                    {{ $history->user->first_name }} {{ $history->user->last_name }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {!! $history->changes !!}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $editHistory->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection