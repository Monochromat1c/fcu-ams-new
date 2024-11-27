@extends('layouts.layout')
@section('content')
<div class="grid grid-cols-6">
    @include('layouts.sidebar')
    <div class="content min-h-screen bg-slate-100 col-span-5">
        <nav class="bg-white flex justify-between py-3 px-4 m-3 shadow-md rounded-md">
            <div class="flex items-center">
                <a href="javascript:void(0);" onclick="history.back();"
                    class="mr-4 hover:bg-gray-100 p-2 rounded-full transition">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <h1 class="text-3xl font-semibold text-gray-800">Asset Details</h1>
            </div>
        </nav>

        <div class="bg-white p-6 m-3 rounded-md shadow-md">
            <div class="grid md:grid-cols-2 gap-8">
                <div class="bg-slate-50 p-6 rounded-lg border border-slate-200">
                    <h2 class="text-2xl font-bold mb-5 pb-3 border-b border-slate-300 text-gray-700">Asset Information
                    </h2>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center border-b border-slate-200 pb-2">
                            <label class="font-semibold text-gray-600 w-1/3">Asset Tag ID:</label>
                            <p class="text-gray-800 font-medium w-2/3 text-right">{{ $asset->asset_tag_id }}</p>
                        </div>
                        <div class="flex justify-between items-center border-b border-slate-200 pb-2">
                            <label class="font-semibold text-gray-600 w-1/3">Brand:</label>
                            <p class="text-gray-800 font-medium w-2/3 text-right">{{ $asset->brand->brand }}</p>
                        </div>
                        <div class="flex justify-between items-center border-b border-slate-200 pb-2">
                            <label class="font-semibold text-gray-600 w-1/3">Model:</label>
                            <p class="text-gray-800 font-medium w-2/3 text-right">{{ $asset->model }}</p>
                        </div>
                        <div class="flex justify-between items-center">
                            <label class="font-semibold text-gray-600 w-1/3">Serial Number:</label>
                            <p class="text-gray-800 font-medium w-2/3 text-right">{{ $asset->serial_number }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-50 p-6 rounded-lg border border-slate-200">
                    <h2 class="text-2xl font-bold mb-5 pb-3 border-b border-slate-300 text-gray-700">Additional Details
                    </h2>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center border-b border-slate-200 pb-2">
                            <label class="font-semibold text-gray-600 w-1/3">Site:</label>
                            <p class="text-gray-800 font-medium w-2/3 text-right">{{ $asset->site->site }}</p>
                        </div>
                        <div class="flex justify-between items-center border-b border-slate-200 pb-2">
                            <label class="font-semibold text-gray-600 w-1/3">Location:</label>
                            <p class="text-gray-800 font-medium w-2/3 text-right">{{ $asset->location->location }}
                            </p>
                        </div>
                        <div class="flex justify-between items-center border-b border-slate-200 pb-2">
                            <label class="font-semibold text-gray-600 w-1/3">Category:</label>
                            <p class="text-gray-800 font-medium w-2/3 text-right">{{ $asset->category->category }}
                            </p>
                        </div>
                        <div class="flex justify-between items-center border-b border-slate-200 pb-2">
                            <label class="font-semibold text-gray-600 w-1/3">Department:</label>
                            <p class="text-gray-800 font-medium w-2/3 text-right">
                                {{ $asset->department->department }}</p>
                        </div>
                        <div class="flex justify-between items-center">
                            <label class="font-semibold text-gray-600 w-1/3">Maintenance End Date:</label>
                            <p class="text-gray-800 font-medium w-2/3 text-right">
                                {{ \Carbon\Carbon::parse($asset->maintenance_end_date)->format('F d, Y') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Maintenance Status Section -->
            <div class="mt-8 bg-slate-50 p-6 rounded-lg border border-slate-200">
                <h2 class="text-2xl font-bold mb-5 pb-3 border-b border-slate-300 text-gray-700">Maintenance Status</h2>
                <div class="flex items-center">
                    @php
                        $maintenanceEndDate = \Carbon\Carbon::parse($asset->maintenance_end_date);
                        $isOverdue = $maintenanceEndDate->isPast();
                    @endphp
                    <div class="w-full">
                        <div class="flex justify-between items-center mb-2">
                            <span class="font-semibold text-gray-600">
                                {{ $isOverdue ? 'Maintenance Overdue' : 'Maintenance Status' }}
                            </span>
                            <span
                                class="{{ $isOverdue ? 'text-red-600' : 'text-green-600' }} font-bold">
                                {{ $isOverdue ? 'Overdue' : 'Current' }}
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="{{ $isOverdue ? 'bg-red-500' : 'bg-green-500' }} h-2.5 rounded-full"
                                style="width: {{ $isOverdue ? '100%' : '100%' }}">
                            </div>
                        </div>
                        <div class="text-sm text-gray-500 mt-2">
                            @if($isOverdue)
                                Maintenance was due on
                                {{ $maintenanceEndDate->format('F d, Y') }}
                            @else
                                Maintenance is current
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection