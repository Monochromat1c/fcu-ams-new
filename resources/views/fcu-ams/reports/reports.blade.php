@extends('layouts.layout')
@section('content')
<link rel="stylesheet" href="{{ asset('css/asset.css') }}">
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

<style>
    .pagination-container nav > div:first-child {
        display: none !important;
    }
    .pagination-container nav > div:last-child {
        margin: 0 !important;
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
    }
    .pagination-container nav > div:last-child > div:first-child {
        margin-right: 1rem !important;
    }
    .pagination-container nav > div:last-child > div:last-child {
        margin-left: auto !important;
    }
    .pagination-container .pagination-previous,
    .pagination-container .pagination-next {
        display: invisible !important;
    }

    /* Add spacing between pagination elements */
    .pagination-container nav > div:last-child > div > span,
    .pagination-container nav > div:last-child > div > a {
        margin: 0 0.5rem !important;
    }

    .pagination-container nav > div:last-child > div > span:first-child,
    .pagination-container nav > div:last-child > div > a:first-child {
        margin-left: 0 !important;
    }

    .pagination-container nav > div:last-child > div > span:last-child,
    .pagination-container nav > div:last-child > div > a:last-child {
        margin-right: 0 !important;
    }
</style>

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
                <h1 class="text-3xl font-semibold text-gray-800 my-auto">Reports</h1>
            
            <!-- Profile section (right-aligned) -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex gap-3 focus:outline-none">
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
                <!-- Profile dropdown menu -->
                <div x-show="open" @click.away="open = false"
                    class="absolute right-0 mt-4 w-72 bg-white rounded-lg shadow-xl border border-gray-200 z-50">
                    <div class="p-4 border-b border-gray-100 rounded-t-lg bg-gradient-to-r from-gray-100 to-gray-200">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                @if(auth()->user()->profile_picture)
                                    <img src="{{ asset(auth()->user()->profile_picture) }}" alt="User Profile"
                                        class="w-12 h-12 rounded-full object-cover ring-2 ring-blue-500">
                                @else
                                    <img src="{{ asset('profile/defaultProfile.png') }}" alt="Default Profile"
                                        class="w-12 h-12 rounded-full object-cover ring-2 ring-blue-500">
                                @endif
                            </div>
                            <div class="ml-3 flex-grow">
                                <div class="font-semibold text-base text-gray-800">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</div>
                                <div class="text-sm text-gray-600">{{ auth()->user()->email }}</div>
                            </div>
                            <a href="{{ route('profile.index') }}" class="ml-2 p-1 hover:bg-gray-100 rounded-full transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 hover:text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                    <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="divide-y divide-gray-200">
                        <div class="flex items-center px-4 py-3.5 text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
                            </svg>
                            <p class="font-medium">Role</p>
                            <p class="ml-auto text-gray-600">{{ auth()->user()->role->role }}</p>
                        </div>
                        <div class="flex items-center px-4 py-3.5 text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                            <span class="font-medium">Username</span>
                            <span class="ml-auto text-gray-600">{{ auth()->user()->username }}</span>
                        </div>
                        <button onclick="document.getElementById('logout-modal').classList.toggle('hidden')"
                            class="flex items-center px-4 py-3.5 text-red-600 hover:bg-red-50 w-full text-left transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" />
                            </svg>
                            <span class="font-medium">Logout</span>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <div class="content-area mx-3">
            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <!-- Total Inventory Card -->
                <div class="bg-white rounded-lg shadow-md p-6 flex-1">
                    <div class="flex items-center justify-between">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-gray-500 text-sm">Total Inventory Items</p>
                            <h3 class="text-2xl font-semibold text-gray-800 mt-1">{{ $inventories->total() }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Total Assets Card -->
                <div class="bg-white rounded-lg shadow-md p-6 flex-1">
                    <div class="flex items-center justify-between">
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-gray-500 text-sm">Total Assets</p>
                            <h3 class="text-2xl font-semibold text-gray-800 mt-1">{{ $assets->total() }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Stock Out Records Card -->
                <div class="bg-white rounded-lg shadow-md p-6 flex-1">
                    <div class="flex items-center justify-between">
                        <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-gray-500 text-sm">Stock Out Records</p>
                            <h3 class="text-2xl font-semibold text-gray-800 mt-1">{{ $stockOutRecords->total() }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Purchase Orders Card -->
                <div class="bg-white rounded-lg shadow-md p-6 flex-1">
                    <div class="flex items-center justify-between">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-gray-500 text-sm">Purchase Orders</p>
                            <h3 class="text-2xl font-semibold text-gray-800 mt-1">{{ $purchaseOrders->total() }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart Section -->
            <!-- <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl segoe font-bold text-gray-700 mb-4">Inventory Distribution by Supplier</h2>
                    <div class="w-full h-[300px] flex items-center justify-center">
                        <canvas id="inventoryChart"></canvas>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl segoe font-bold text-gray-700 mb-4">Asset Distribution by Department</h2>
                    <div class="w-full h-[300px] flex items-center justify-center">
                        <canvas id="departmentChart"></canvas>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-2xl segoe font-bold text-gray-700 mb-4">Stock-Out Trends (Last 6 Months)</h2>
                    <div class="w-full h-[300px] flex items-center justify-center">
                        <canvas id="trendChart"></canvas>
                    </div>
                </div>
            </div> -->
            <!-- Assigned Assets Section -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl segoe font-bold text-gray-700">Assigned Assets</h2>
                    <div class="flex items-center gap-4">
                        <!-- Search Form -->
                        <form method="GET" action="{{ route('reports.index') }}" class="flex items-center">
                            <div class="relative">
                                <input type="text" name="assignee" id="assignee" value="{{ $assigneeQuery }}"
                                    placeholder="Search by assignee name..."
                                    class="w-64 rounded-md border-2 border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-white px-4 py-2">
                                <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 p-1.5 rounded-full bg-blue-500 hover:bg-blue-600 transition-colors duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </button>
                            </div>
                        </form>
                        @if(isset($assignedAssets) && !$assignedAssets->isEmpty())
                            <form method="GET" action="{{ route('reports.print-assigned') }}" target="_blank">
                                <input type="hidden" name="assignee" value="{{ $assigneeQuery }}">
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                    </svg>
                                    Print Report
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Divider -->
                <div class="border-b-2 border-slate-200 mb-6"></div>

                @if(isset($assignedAssets))
                    @if($assignedAssets->isEmpty())
                        <p class="text-center text-gray-500 py-4">No assets found assigned to
                            "{{ $assigneeQuery }}".
                        </p>
                    @else
                        <div class="overflow-x-auto border-2 border-slate-300 rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                            Assigned To</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                            Asset Tag ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                            Brand</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                            Model</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                            Department</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                            Location</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                            Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                            Condition</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($assignedAssets as $asset)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4">{{ $asset->assigned_to ?? 'N/A' }}</td>
                                            <td class="px-6 py-4">{{ $asset->asset_tag_id }}</td>
                                            <td class="px-6 py-4">{{ $asset->brand->brand }}</td>
                                            <td class="px-6 py-4">{{ $asset->model }}</td>
                                            <td class="px-6 py-4">{{ $asset->department->department }}</td>
                                            <td class="px-6 py-4">{{ $asset->location->location }}</td>
                                            <td class="px-6 py-4">{{ $asset->status->status }}</td>
                                            <td class="px-6 py-4">{{ $asset->condition->condition }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4 pagination-container flex w-full">
                            {{ $assignedAssets->links() }}
                        </div>
                    @endif
                @else
                    <p class="text-center text-gray-500 py-4">Enter an assignee name to search for their assigned
                        assets.</p>
                @endif
            </div>
            <!-- Purchase Order -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl segoe font-bold text-gray-700">Purchase Order</h2>
                    <span class="text-sm text-gray-500">{{ $poDateRangeDisplay }}</span>
                </div>
                
                <!-- Filter Form -->
                <form method="GET" action="{{ route('reports.index') }}" class="bg-gray-50 rounded-lg p-6 mb-4 border-2 border-slate-300">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="po_start_date" class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                            <input type="date" name="po_start_date" id="po_start_date"
                                value="{{ request('po_start_date', now()->startOfMonth()->toDateString()) }}"
                                class="mt-1 block w-full rounded-md border-2 border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-white px-4 py-2">
                        </div>
                        <div>
                            <label for="po_end_date" class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                            <input type="date" name="po_end_date" id="po_end_date"
                                value="{{ request('po_end_date', now()->endOfMonth()->toDateString()) }}"
                                class="mt-1 block w-full rounded-md border-2 border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-white px-4 py-2">
                        </div>
                        <div class="flex items-end">
                            <button type="submit"
                                class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Apply Filter
                            </button>
                        </div>
                    </div>
                </form>

                @if($purchaseOrders->isEmpty())
                    <p class="text-center text-gray-500 py-4">No purchase order records available.</p>
                @else
                    <div class="overflow-x-auto border-2 border-slate-300 rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Department</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($purchaseOrders as $record)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4">{{ $record->department->department }}</td>
                                            <td class="px-6 py-4">{{ $record->po_date }}</td>
                                            <td class="px-6 py-4">
                                    <a href="{{ route('purchase-order-details', $record->id) }}"
                                                    class="text-blue-600 hover:text-blue-900">View Details</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
                        <div class="mt-4 pagination-container flex w-full">
                            {{ $purchaseOrders->appends(['po_page' => request('po_page')])->links() }}
                        </div>
            @endif
                                        </div>

                <!-- Stock Out Records Section -->
                <div class="bg-white rounded-lg shadow-md mb-6 p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl segoe font-bold text-gray-700">Stock Out Records</h2>
                        <span class="text-sm text-gray-500">{{ $stockOutDateRangeDisplay }}</span>
                    </div>

                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('reports.index') }}" class="bg-gray-50 rounded-lg p-6 mb-4 border-2 border-slate-300">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="stock_out_start_date" class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                                <input type="date" name="stock_out_start_date" id="stock_out_start_date"
                                    value="{{ request('stock_out_start_date', now()->startOfMonth()->toDateString()) }}"
                                    class="mt-1 block w-full rounded-md border-2 border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-white px-4 py-2">
                            </div>
                            <div>
                                <label for="stock_out_end_date" class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                                <input type="date" name="stock_out_end_date" id="stock_out_end_date"
                                    value="{{ request('stock_out_end_date', now()->endOfMonth()->toDateString()) }}"
                                    class="mt-1 block w-full rounded-md border-2 border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-white px-4 py-2">
                            </div>
                            <div class="flex items-end">
                                <button type="submit"
                                    class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    Apply Filter
                                </button>
                            </div>
                        </div>
                    </form>

                    @if($stockOutRecords->isEmpty())
                        <p class="text-center text-gray-500 py-4">No stock out records available.</p>
                    @else
                        <div class="overflow-x-auto border-2 border-slate-300 rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Receiver</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($stockOutRecords as $record)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4">{{ $record->receiver }}</td>
                                            <td class="px-6 py-4">{{ $record->stock_out_date }}</td>
                                            <td class="px-6 py-4">
                                        <a href="{{ route('stock.out.details', $record->id) }}"
                                                    class="text-blue-600 hover:text-blue-900">View Details</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                        <div class="mt-4 pagination-container flex w-full">
                            {{ $stockOutRecords->appends(['stock_out_page' => request('stock_out_page')])->links() }}
                        </div>
                    @endif
                                    </div>

                <!-- Supply Requests Section -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6 col-span-2">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl segoe font-bold text-gray-700">Supply Requests</h2>
                        <span class="text-sm text-gray-500">{{ $supplyRequestDateRangeDisplay }}</span>
                    </div>

                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('reports.index') }}" class="bg-gray-50 rounded-lg p-6 mb-4 border-2 border-slate-300">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="supply_request_start_date" class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                                <input type="date" name="supply_request_start_date" id="supply_request_start_date"
                                    value="{{ request('supply_request_start_date', now()->startOfMonth()->toDateString()) }}"
                                    class="mt-1 block w-full rounded-md border-2 border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-white px-4 py-2">
                            </div>
                            <div>
                                <label for="supply_request_end_date" class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                                <input type="date" name="supply_request_end_date" id="supply_request_end_date"
                                    value="{{ request('supply_request_end_date', now()->endOfMonth()->toDateString()) }}"
                                    class="mt-1 block w-full rounded-md border-2 border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-white px-4 py-2">
                            </div>
                            <div class="flex items-end">
                                <button type="submit"
                                    class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    Apply Filter
                                </button>
                            </div>
                        </div>
                    </form>

                    @if($approvedRequests->isEmpty())
                        <p class="text-center text-gray-500 py-4">No approved requests available.</p>
                    @else
                        <div class="overflow-x-auto border-2 border-slate-300 rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Requester</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Department</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Items</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($approvedRequests as $request)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4">{{ $request->requester }}</td>
                                            <td class="px-6 py-4">{{ $request->department->department }}</td>
                                            <td class="px-6 py-4">{{ $request->total_items }} items</td>
                                            <td class="px-6 py-4">{{ \Carbon\Carbon::parse($request->request_date)->format('M d, Y') }}</td>
                                            <td class="px-6 py-4">
                                                <a href="{{ route('reports.print-approved-request', $request->request_group_id) }}" 
                                                   class="text-blue-600 hover:text-blue-900">
                                                    Print Request
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4 pagination-container flex w-full">
                            {{ $approvedRequests->appends(['supply_request_page' => request('supply_request_page')])->links() }}
                        </div>
                    @endif
                </div>

                <!-- Invetory Section -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h2 class="text-2xl segoe font-bold text-gray-700">Inventory Report</h2>
                            <p class="text-sm text-gray-500 mt-1">{{ $dateRangeDisplay }}</p>
                        </div>
                        <form method="GET" action="{{ route('reports.print') }}" target="_blank" class="ml-2">
                            <input type="hidden" name="start_date" value="{{ request('start_date', now()->startOfMonth()->toDateString()) }}">
                            <input type="hidden" name="end_date" value="{{ request('end_date', now()->endOfMonth()->toDateString()) }}">
                                <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                    </svg>
                                Print Report
                                </button>
                            </form>
                        </div>

                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('reports.index') }}" class="bg-gray-50 rounded-lg p-6 mb-4 border-2 border-slate-300">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                                <input type="date" name="start_date" id="start_date"
                                    value="{{ request('start_date', now()->startOfMonth()->toDateString()) }}"
                                    class="mt-1 block w-full rounded-md border-2 border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-white px-4 py-2">
                            </div>
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                                <input type="date" name="end_date" id="end_date"
                                    value="{{ request('end_date', now()->endOfMonth()->toDateString()) }}"
                                    class="mt-1 block w-full rounded-md border-2 border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-white px-4 py-2">
                            </div>
                            <div class="flex items-end">
                                <button type="submit"
                                    class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    Apply Filter
                                </button>
                            </div>
                        </div>
                    </form>

                    @if($inventories->isEmpty())
                        <p class="text-center text-gray-500 py-4">No inventory records available.</p>
                    @else
                        <div class="overflow-x-auto border-2 border-slate-300 rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Unique Tag</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Items & Specs</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Unit</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Unit Price</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Supplier</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Purchase Date</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($inventories as $inventory)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4">{{ $inventory->unique_tag }}</td>
                                            <td class="px-6 py-4">{{ $inventory->items_specs }}</td>
                                            <td class="px-6 py-4">{{ $inventory->quantity }}</td>
                                            <td class="px-6 py-4">{{ $inventory->unit->unit }}</td>
                                            <td class="px-6 py-4">{{ $inventory->unit_price }}</td>
                                            <td class="px-6 py-4">{{ $inventory->supplier->supplier }}</td>
                                            <td class="px-6 py-4">{{ date('F j, Y', strtotime($inventory->supplier->created_at)) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                        <div class="mt-4 pagination-container flex w-full">
                            {{ $inventories->appends(['inventory_page' => request('inventory_page')])->links() }}
                        </div>
            @endif
        </div>

                <!-- Assets Section -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h2 class="text-2xl segoe font-bold text-gray-700">Assets Report</h2>
                            <p class="text-sm text-gray-500 mt-1">{{ $assetsDateRangeDisplay }}</p>
                        </div>
                            <form method="GET" action="{{ route('reports.print-assets') }}" target="_blank" class="ml-2">
                            <input type="hidden" name="assets_start_date" value="{{ request('assets_start_date', now()->startOfMonth()->toDateString()) }}">
                            <input type="hidden" name="assets_end_date" value="{{ request('assets_end_date', now()->endOfMonth()->toDateString()) }}">
                                    <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                        </svg>
                                Print Report
                                    </button>
                                </form>
                        </div>

                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('reports.index') }}" class="bg-gray-50 rounded-lg p-6 mb-4 border-2 border-slate-300">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="assets_start_date" class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                                <input type="date" name="assets_start_date" id="assets_start_date"
                                    value="{{ request('assets_start_date', now()->startOfMonth()->toDateString()) }}"
                                    class="mt-1 block w-full rounded-md border-2 border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-white px-4 py-2">
                            </div>
                            <div>
                                <label for="assets_end_date" class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                                <input type="date" name="assets_end_date" id="assets_end_date"
                                    value="{{ request('assets_end_date', now()->endOfMonth()->toDateString()) }}"
                                    class="mt-1 block w-full rounded-md border-2 border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-white px-4 py-2">
                            </div>
                            <div class="flex items-end">
                                <button type="submit"
                                    class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    Apply Filter
                                </button>
                            </div>
                        </div>
                    </form>

                    @if($assets->isEmpty())
                        <p class="text-center text-gray-500 py-4">No assets records available.</p>
                    @else
                        <div class="overflow-x-auto border-2 border-slate-300 rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Assigned To</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Asset Tag ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Brand</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Model</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Serial Number</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cost</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Supplier</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Purchase Date</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($assets as $asset)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4">{{ $asset->assigned_to ?? 'N/A' }}</td>
                                            <td class="px-6 py-4">{{ $asset->asset_tag_id }}</td>
                                            <td class="px-6 py-4">{{ $asset->brand->brand }}</td>
                                            <td class="px-6 py-4">{{ $asset->model }}</td>
                                            <td class="px-6 py-4">{{ $asset->serial_number }}</td>
                                            <td class="px-6 py-4">{{ $asset->cost }}</td>
                                            <td class="px-6 py-4">{{ $asset->supplier->supplier }}</td>
                                            <td class="px-6 py-4">{{ date('F j, Y', strtotime($asset->created_at)) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                        <div class="mt-4 pagination-container flex w-full">
                            {{ $assets->appends(['assets_page' => request('assets_page')])->links() }}
                        </div>
            @endif
                </div>

                
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/chart.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inventory Chart
    const ctxInventory = document.getElementById('inventoryChart').getContext('2d');
    const labels = @json($chartLabels);
    const data = @json($chartData);
    
    const backgroundColors = [
        'rgba(54, 162, 235, 0.8)',
        'rgba(255, 99, 132, 0.8)',
        'rgba(255, 206, 86, 0.8)',
        'rgba(75, 192, 192, 0.8)',
        'rgba(153, 102, 255, 0.8)'
    ];

    new Chart(ctxInventory, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: backgroundColors,
                borderColor: backgroundColors.map(color => color.replace('0.8', '1')),
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        font: {
                            size: 12
                        },
                        padding: 20
                    }
                },
                title: {
                    display: true,
                    text: 'Top 5 Suppliers by Number of Items',
                    font: {
                        size: 16
                    }
                }
            }
        }
    });

    // Department Chart
    const ctxDepartment = document.getElementById('departmentChart').getContext('2d');
    const deptLabels = @json($departmentChartLabels);
    const deptData = @json($departmentChartData);
    
    const deptBackgroundColors = [
        'rgba(255, 99, 132, 0.8)',
        'rgba(54, 162, 235, 0.8)',
        'rgba(255, 206, 86, 0.8)',
        'rgba(75, 192, 192, 0.8)',
        'rgba(153, 102, 255, 0.8)'
    ];

    new Chart(ctxDepartment, {
        type: 'doughnut',
        data: {
            labels: deptLabels,
            datasets: [{
                data: deptData,
                backgroundColor: deptBackgroundColors,
                borderColor: deptBackgroundColors.map(color => color.replace('0.8', '1')),
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        font: {
                            size: 12
                        },
                        padding: 20
                    }
                },
                title: {
                    display: true,
                    text: 'Top 5 Departments by Number of Assets',
                    font: {
                        size: 16
                    }
                }
            }
        }
    });

    // Stock Out Trends Chart
    const ctxTrend = document.getElementById('trendChart').getContext('2d');
    const trendLabels = @json($trendLabels);
    const trendData = @json($trendData);

    new Chart(ctxTrend, {
        type: 'line',
        data: {
            labels: trendLabels,
            datasets: [{
                label: 'Number of Stock-Outs',
                data: trendData,
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.3,
                fill: true,
                pointBackgroundColor: 'rgb(75, 192, 192)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        font: {
                            size: 12
                        },
                        padding: 20
                    }
                },
                title: {
                    display: true,
                    text: 'Monthly Stock-Out Activity',
                    font: {
                        size: 16
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    },
                    grid: {
                        drawBorder: false
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
});
</script>

@endsection
