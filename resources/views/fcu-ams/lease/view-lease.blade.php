@extends('layouts.layout')

@section('content')
<link rel="stylesheet" href="{{ asset('css/asset.css') }}">

<div class="grid grid-cols-6">
    @include('layouts.sidebar')
    <div class="content min-h-screen bg-slate-200 col-span-5">
        <!-- Enhanced Navigation Bar -->
        <nav class="bg-white flex justify-between items-center py-6 px-6 m-4 shadow-md rounded-lg border border-gray-100">
            <a href="{{ route('lease.index') }}" class="flex items-center text-gray-600 hover:text-gray-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <h1 class="text-3xl font-semibold text-gray-800">Lease Details</h1>
            <a href="{{ route('lease.index') }}" class="flex items-center text-gray-600 invisible hover:text-gray-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
        </nav>

        <!-- Main Content -->
        <div class="bg-white p-6 shadow-md rounded-lg mx-4 border border-gray-100 mb-6">
            <!-- Lease Information -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">Lease Details</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Customer Card -->
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                        <div class="flex items-center mb-4">
                            <div class="bg-blue-100 p-3 rounded-lg mr-4">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Customer</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $lease->customer }}</p>
                            </div>
                        </div>
                        <div class="space-y-3 border-t pt-4">
                            <div>
                                <p class="text-sm text-gray-500">Contact Information</p>
                                <div class="flex items-center mt-1">
                                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    <span class="font-medium text-gray-700">{{ $lease->contact_number }}</span>
                                </div>
                                <div class="flex items-center mt-1">
                                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="font-medium text-gray-700">{{ $lease->email }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Lease Timeline Card -->
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                        <div class="flex items-center mb-6">
                            <div class="bg-purple-100 p-3 rounded-lg mr-4">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Lease Period</p>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center pb-2 border-b">
                                <span class="text-sm text-gray-500">Start Date</span>
                                <span class="font-medium text-gray-700">
                                    {{ \Carbon\Carbon::parse($lease->lease_date)->format('M d, Y') }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center pt-2">
                                <span class="text-sm text-gray-500">Expiration</span>
                                <div class="flex items-center">
                                    @php
                                        $expirationDate = \Carbon\Carbon::parse($lease->lease_expiration);
                                        $daysUntilExpiration = now()->diffInDays($expirationDate, false);
                                    @endphp
                                    <div class="mr-3">
                                        @if($daysUntilExpiration < 0)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                                Expired
                                            </span>
                                        @elseif($daysUntilExpiration <= 7)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                                </svg>
                                                {{ $daysUntilExpiration }} days left
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                                Active
                                            </span>
                                        @endif
                                    </div>
                                    <span class="font-medium text-gray-700">
                                        {{ $expirationDate->format('M d, Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($lease->note)
                    <!-- Notes Card -->
                    <div class="md:col-span-2 bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                        <div class="flex items-center mb-4">
                            <div class="bg-yellow-100 p-3 rounded-lg mr-4">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Additional Notes</p>
                                <p class="mt-2 text-gray-700 leading-relaxed">{{ $lease->note }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Leased Assets -->
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">Leased Assets ({{ $assets->total() }})</h2>
                    <!-- <div class="text-sm text-gray-500">
                        Showing {{ $assets->firstItem() }} - {{ $assets->lastItem() }} of {{ $assets->total() }}
                    </div> -->
                </div>
                
                @if($assets->count())
                    <div class="overflow-x-auto rounded-lg border-2 border-slate-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr class="bg-gradient-to-r from-blue-400 to-blue-500 text-white">
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Asset Tag ID</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Category</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Brand</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Model</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Serial Number</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($assets as $asset)
                                    <tr class="hover:bg-gray-50 transition-all duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $asset->asset_tag_id }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $asset->category->category ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $asset->brand->brand ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $asset->model ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $asset->serial_number ?? 'N/A' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6 flex items-center justify-between px-4">
                        <div class="flex items-center gap-2">
                            <a href="{{ $assets->url(1) }}" class="p-2 inline-flex items-center justify-center rounded-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                                </svg>
                            </a>
                            <a href="{{ $assets->previousPageUrl() }}" class="p-2 inline-flex items-center justify-center rounded-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                </svg>
                            </a>
                        </div>

                        <div class="text-sm text-gray-700">
                            Showing {{ $assets->firstItem() ?? 0 }} to {{ $assets->lastItem() ?? 0 }} of {{ $assets->total() }} items
                        </div>

                        <div class="flex items-center gap-2">
                            <a href="{{ $assets->nextPageUrl() }}" class="p-2 inline-flex items-center justify-center rounded-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                            <a href="{{ $assets->url($assets->lastPage()) }}" class="p-2 inline-flex items-center justify-center rounded-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                @else
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 text-center text-gray-500">
                        No leased assets found
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
