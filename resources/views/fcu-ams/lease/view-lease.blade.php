@extends('layouts.layout')

@section('content')
<link rel="stylesheet" href="{{ asset('css/asset.css') }}">

<div class="grid grid-cols-6">
    @include('layouts.sidebar')
    <div class="content min-h-screen bg-slate-200 col-span-5">
        <!-- Enhanced Navigation Bar -->
        <nav class="bg-white flex justify-between items-center py-4 px-6 m-4 shadow-md rounded-lg border border-gray-100">
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
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Lease Information</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Customer</p>
                        <p class="text-lg font-medium text-gray-900">{{ $lease->customer }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Lease Date</p>
                        <p class="text-lg font-medium text-gray-900">{{ \Carbon\Carbon::parse($lease->lease_date)->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Lease Expiration</p>
                        <div class="flex items-center">
                            @php
                                $expirationDate = \Carbon\Carbon::parse($lease->lease_expiration);
                                $daysUntilExpiration = now()->diffInDays($expirationDate, false);
                            @endphp
                            
                            @if($daysUntilExpiration < 0)
                                <span class="inline-flex items-center px-4 py-2 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Expired
                                </span>
                            @elseif($daysUntilExpiration <= 7)
                                <span class="inline-flex items-center px-4 py-2 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Expires in {{ $daysUntilExpiration }} days
                                </span>
                            @else
                                <span class="inline-flex items-center px-4 py-2 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Active
                                </span>
                            @endif
                            <span class="ml-2 text-lg font-medium text-gray-900">{{ $expirationDate->format('M d, Y') }}</span>
                        </div>
                    </div>
                    @if($lease->note)
                    <div>
                        <p class="text-sm text-gray-600">Note</p>
                        <p class="text-lg font-medium text-gray-900">{{ $lease->note }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Leased Assets -->
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Leased Assets</h2>
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
                            @foreach($lease->assets as $asset)
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
            </div>
        </div>
    </div>
</div>
@endsection
