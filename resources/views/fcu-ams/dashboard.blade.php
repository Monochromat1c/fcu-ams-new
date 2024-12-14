@extends('layouts.layout')
@section('content')
<script>
    function preventBack() {
        window.history.forward()
    };
    setTimeout("preventBack()", 0);
    windows.onunload = function () {
        null;
    }
</script>
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

<div class="grid grid-cols-6">
    @include('layouts.sidebar')
    <div class="bg-slate-200 content min-h-screen col-span-5">
    <nav class="bg-white flex justify-between py-3 px-4 m-3 shadow-md rounded-md">
    <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="invisible flex gap-3 focus:outline-none" style="min-width:100px;">
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
                <div x-show="open" 
                    @click.away="open = false"
                    class="absolute right-0 mt-4 border-2 border-gray-400 w-72 bg-white rounded-lg shadow-lg border border-gray-100 z-50">
                    <div class="p-4 border-b border-gray-100 r rounded-t-lg bg-gray-200">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                @if(auth()->user()->profile_picture)
                                    <img src="{{ asset(auth()->user()->profile_picture) }}" alt="User Profile"
                                        class="w-12 h-12 rounded-full object-cover">
                                @else
                                    <img src="{{ asset('profile/defaultProfile.png') }}" alt="Default Profile"
                                        class="w-12 h-12 rounded-full object-cover">
                                @endif
                            </div>
                            <div class="ml-3 flex-grow">
                                <div class="font-medium text-base">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</div>
                                <div class="text-sm text-gray-500">{{ auth()->user()->email }}</div>
                            </div>
                            <a href="{{ route('profile.index') }}" class="ml-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 hover:text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                    <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="flex items-center border-b-2 border-gray-200 px-4 py-2 text-gray-700 hover:bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
                        </svg>
                        <p class="role">
                            Role
                        </p>
                        <p class="ml-auto">{{ auth()->user()->role->role }}</p>
                    </div>
                    <div class="flex items-center border-b-2 border-gray-200 px-4 py-2 text-gray-700 hover:bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                        <span>Username</span>
                        <span class="ml-auto">{{ auth()->user()->username }}</span>
                    </div>
                    <button onclick="document.getElementById('logout-modal').classList.toggle('hidden')"
                        class="flex items-center px-4 py-2 text-red-500 hover:bg-gray-100 w-full text-left">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" />
                        </svg>
                        <span>Logout</span>
                    </button>
                </div>
            </div>
            <h1 class="my-auto text-3xl">Dashboard</h1>
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
                <div x-show="open" 
                    @click.away="open = false"
                    class="absolute right-0 mt-4 border-2 border-gray-400 w-72 bg-white rounded-lg shadow-lg border border-gray-100 z-50">
                    <div class="p-4 border-b border-gray-100 r rounded-t-lg bg-gray-200">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                @if(auth()->user()->profile_picture)
                                    <img src="{{ asset(auth()->user()->profile_picture) }}" alt="User Profile"
                                        class="w-12 h-12 rounded-full object-cover">
                                @else
                                    <img src="{{ asset('profile/defaultProfile.png') }}" alt="Default Profile"
                                        class="w-12 h-12 rounded-full object-cover">
                                @endif
                            </div>
                            <div class="ml-3 flex-grow">
                                <div class="font-medium text-base">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</div>
                                <div class="text-sm text-gray-500">{{ auth()->user()->email }}</div>
                            </div>
                            <a href="{{ route('profile.index') }}" class="ml-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 hover:text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                    <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="flex items-center border-b-2 border-gray-200 px-4 py-2 text-gray-700 hover:bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
                        </svg>
                        <p class="role">
                            Role
                        </p>
                        <p class="ml-auto">{{ auth()->user()->role->role }}</p>
                    </div>
                    <div class="flex items-center border-b-2 border-gray-200 px-4 py-2 text-gray-700 hover:bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                        <span>Username</span>
                        <span class="ml-auto">{{ auth()->user()->username }}</span>
                    </div>
                    <button onclick="document.getElementById('logout-modal').classList.toggle('hidden')"
                        class="flex items-center px-4 py-2 text-red-500 hover:bg-gray-100 w-full text-left">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" />
                        </svg>
                        <span>Logout</span>
                    </button>
                </div>
            </div>
        </nav>
        <div class="m-3 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
            <a href="{{ route('asset.list') }}" class="dashboard-card">
                <div class="p-6">
                    <div class="flex align-items-center mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mr-3 text-blue-600" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                clip-rule="evenodd" />
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-800">Assets</h3>
                    </div>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalAssets }}</p>
                </div>
            </a>
            <div class="dashboard-card">
                <div class="p-6">
                    <div class="flex align-items-center mb-3">
                        <svg class="h-10 w-10 mr-3 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-800">Asset Value</h3>
                    </div>
                    <p class="text-3xl font-bold text-gray-900">₱{{ number_format($totalAssetValue, 2) }}</p>
                </div>
            </div>
            <a href="{{ route('inventory.list') }}" class="dashboard-card">
                <div class="p-6">
                    <div class="flex items-center mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mr-3 text-purple-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-800">Inventory Supplies</h3>
                    </div>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalInventoryStocks }}</p>
                </div>
            </a>
            <div class="dashboard-card">
                <div class="p-6">
                    <div class="flex align-items-center mb-3">
                        <svg class="h-10 w-10 mr-3 text-orange-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-800">Inventory Value</h3>
                    </div>
                    <p class="text-3xl font-bold text-gray-900">₱{{ number_format($totalInventoryValue, 2) }}</p>
                </div>
            </div>
            <div class="chart-container col-span-2">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Asset Value Distribution</h3>
                <canvas id="assetValueDistributionChart"></canvas>
                <div id="assetValueLegend" class="mt-4"></div>
            </div>
            <div class="chart-container col-span-2">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Inventory Value Distribution</h3>
                <canvas id="inventoryValueDistributionChart"></canvas>
                <div id="inventoryValueLegend" class="mt-4"></div>
            </div>
            <div class="chart-container col-span-4">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Monthly Asset Acquisition</h3>
                    <form method="GET" action="{{ route('dashboard') }}" class="flex items-center">
                        <label for="yearFilter" class="mr-2 text-gray-600">Year:</label>
                        <select name="year" id="yearFilter" 
                            class="form-select border rounded-md px-3 py-1.5 text-gray-700 bg-white hover:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            onchange="this.form.submit()">
                            @foreach($availableYears as $year)
                                <option value="{{ $year }}"
                                    {{ $selectedYear == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
                <canvas id="assetAcquisitionChart" class=""></canvas>
            </div>
            <div class="col-span-2 bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex items-center justify-between">
                    <h3 class="text-xl font-bold text-gray-800 tracking-tight">Recent Actions</h3>
                </div>
                <div class="divide-y divide-gray-100">
                    @foreach($recentActions as $action)
                        <div class="px-6 py-4 hover:bg-gray-50 transition-colors duration-150 group">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center space-x-4">
                                    @if($action['type'] === 'Asset')
                                        @if($action['action'] === 'added')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-6 size text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        @elseif($action['action'] === 'removed')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        @endif
                                    @elseif($action['type'] === 'Inventory')
                                        @if($action['action'] === 'added')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z" />
                                            </svg>
                                        @elseif($action['action'] === 'removed')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                            </svg>
                                        @endif
                                    @endif
                                    
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">
                                            <span class="font-semibold">{{ $action['name'] }}</span> 
                                            <span class="text-gray-600">was {{ $action['action'] }} by</span> 
                                            <span class="font-semibold text-gray-800">{{ $action['user'] }}</span>
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center space-x-3">
                                    <span class="text-xs font-medium px-5 py-[.50rem] rounded-full 
                                        @if($action['type'] === 'Asset') bg-blue-100 text-blue-700
                                        @elseif($action['type'] === 'Inventory') bg-green-100 text-green-700
                                        @endif">
                                        {{ $action['type'] }}
                                    </span>
                                    <span class="text-xs text-gray-500 group-hover:text-gray-700 transition-colors">
                                        {{ $action['date'] }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-span-2 bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex items-center justify-between">
                    <h3 class="text-xl font-bold text-gray-800 tracking-tight">Recent Requests</h3>
                </div>
                <div class="divide-y divide-gray-100">
                    
                </div>
            </div>
        </div>
    </div>
</div>
    </div>
</div>

<script src="{{ asset('js/chart.js') }}"></script>
<script>
    // Monthly asset acquisition 
    const assetAcquisitionChart = document.getElementById('assetAcquisitionChart').getContext('2d');
    const assetAcquisitionData = {!! json_encode($assetAcquisition) !!};
    const selectedYear = {{ $selectedYear }};
    
    // Prepare data for chart
    const assetAcquisitionLabels = assetAcquisitionData.map(data => data.month);
    const assetAcquisitionValues = assetAcquisitionData.map(data => data.count);
    const assetAcquisitionAssetTags = assetAcquisitionData.map(data => data.asset_tags);

    // Color palette for consistent and visually appealing colors
    const colorPalette = [
        'rgba(69, 123, 157, 0.8)',   // Soft Blue
        'rgba(124, 181, 236, 0.8)',  // Light Blue
        'rgba(144, 237, 125, 0.8)',  // Soft Green
        'rgba(247, 163, 92, 0.8)',   // Soft Orange
        'rgba(128, 133, 233, 0.8)',  // Periwinkle
        'rgba(241, 92, 128, 0.8)',   // Soft Red
        'rgba(228, 211, 84, 0.8)',   // Soft Yellow
        'rgba(175, 216, 248, 0.8)',  // Sky Blue
        'rgba(187, 155, 176, 0.8)',  // Soft Purple
        'rgba(153, 198, 142, 0.8)',  // Sage Green
        'rgba(242, 140, 40, 0.8)',   // Tangerine
        'rgba(166, 216, 184, 0.8)'   // Mint Green
    ];

    // Generate dynamic colors for each month
    const backgroundColor = assetAcquisitionLabels.map((label, index) => 
        colorPalette[index % colorPalette.length]
    );

    const borderColor = backgroundColor.map(color => 
        color.replace('0.8)', '1)')
    );

    // Create the chart
    const chart = new Chart(assetAcquisitionChart, {
        type: 'bar',
        data: {
            labels: assetAcquisitionLabels,
            datasets: [{
                label: `Monthly Asset Acquisition (${selectedYear})`,
                data: assetAcquisitionValues,
                backgroundColor: backgroundColor,
                borderColor: borderColor,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            aspectRatio: 3,
            title: {
                display: true,
                text: `Monthly Asset Acquisition (${selectedYear})`
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        precision: 0  // Ensure whole numbers
                    }
                }]
            },
            tooltips: {
                mode: 'index',
                intersect: false,
                callbacks: {
                    label: function(tooltipItem, data) {
                        const index = tooltipItem.index;
                        const count = assetAcquisitionValues[index];
                        const assetTags = assetAcquisitionAssetTags[index];
                        
                        // Customize tooltip to show more information
                        return [
                            `Assets Acquired: ${count}`,
                            `Asset Tags: ${assetTags || 'No specific tags'}`
                        ];
                    },
                    title: function(tooltipItems) {
                        return `${tooltipItems[0].label} ${selectedYear}`;
                    }
                }
            },
            hover: {
                mode: 'nearest',
                intersect: true
            },
            legend: {
                display: false  // Hide legend as it's a single dataset
            },
            plugins: {
                // Optional: Add data labels
                datalabels: {
                    color: 'black',
                    anchor: 'end',
                    align: 'top',
                    formatter: function(value) {
                        return value > 0 ? value : '';
                    }
                }
            }
        }
    });

    // Optional: Responsive resize handler
    window.addEventListener('resize', function() {
        chart.resize();
    });
</script>
<script>
    // Depreciation Trends Chart
    const depreciationTrendsChart = document.getElementById('depreciationTrendsChart').getContext('2d');
    const depreciationTrendsData = {!! json_encode($depreciationTrends) !!};
    const depreciationYears = depreciationTrendsData.map(data => data.year);
    const totalCosts = depreciationTrendsData.map(data => data.total_cost);
    const currentValues = depreciationTrendsData.map(data => data.current_value);
    const depreciationAmounts = depreciationTrendsData.map(data => data.depreciation);

    new Chart(depreciationTrendsChart, {
        type: 'line',
        data: {
            labels: depreciationYears,
            datasets: [
                {
                    label: 'Total Cost',
                    data: totalCosts,
                    borderColor: 'rgba(69, 123, 157, 1)',  // Soft Blue
                    backgroundColor: 'rgba(69, 123, 157, 0.2)',
                    fill: false
                },
                {
                    label: 'Current Value',
                    data: currentValues,
                    borderColor: 'rgba(124, 181, 236, 1)',  // Light Blue
                    backgroundColor: 'rgba(124, 181, 236, 0.2)',
                    fill: false
                },
                {
                    label: 'Depreciation',
                    data: depreciationAmounts,
                    borderColor: 'rgba(247, 163, 92, 1)',  // Soft Orange
                    backgroundColor: 'rgba(247, 163, 92, 0.2)',
                    fill: false
                }
            ]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: 'Asset Depreciation Trends'
            },
            tooltips: {
                mode: 'index',
                intersect: false,
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        callback: function(value) {
                            return '₱' + value.toLocaleString();
                        }
                    }
                }]
            }
        }
    });
</script>
<script>
    // Asset Value Distribution Chart
    const assetValueDistributionChart = document.getElementById('assetValueDistributionChart').getContext('2d');
    const assetValueDistributionData = {!! json_encode($assetValueDistribution) !!};
    
    // Function to process asset data
    function processAssetData(data, thresholdPercentage = 3) {
        // Validate input data
        if (!data || data.length === 0) {
            console.error('No asset data available');
            return [];
        }

        // Sort data by total value in descending order
        const sortedData = data.sort((a, b) => b.total_value - a.total_value);
        
        // Separate major and minor categories
        const majorCategories = sortedData.filter(item => item.percentage >= thresholdPercentage);
        const minorCategories = sortedData.filter(item => item.percentage < thresholdPercentage);
        
        // Combine minor categories
        const combinedMinorCategories = {
            category: 'Other Categories',
            total_value: minorCategories.reduce((sum, item) => sum + item.total_value, 0),
            asset_count: minorCategories.reduce((sum, item) => sum + item.asset_count, 0),
            percentage: minorCategories.reduce((sum, item) => sum + item.percentage, 0).toFixed(2)
        };

        // Combine results
        const processedData = [...majorCategories, combinedMinorCategories];
        
        return processedData;
    }

    // Function to generate unique colors
    function generateUniqueColors(count) {
        const baseColors = [
            'hsla(210, 50%, 45%, 0.8)',  // Muted Blue
            'hsla(150, 50%, 45%, 0.8)',  // Muted Green
            'hsla(20, 50%, 45%, 0.8)',   // Muted Orange
            'hsla(270, 50%, 45%, 0.8)',  // Muted Purple
            'hsla(180, 50%, 45%, 0.8)',  // Muted Teal
            'hsla(0, 50%, 45%, 0.8)',    // Muted Red
            'hsla(45, 50%, 45%, 0.8)',   // Muted Gold
            'hsla(330, 50%, 45%, 0.8)',  // Muted Pink
        ];

        if (count <= baseColors.length) {
            return baseColors.slice(0, count);
        }

        const colors = [...baseColors];
        for (let i = baseColors.length; i < count; i++) {
            const hue = (i * 360 / count) % 360;
            const color = `hsla(${hue}, 50%, 45%, 0.8)`;
            colors.push(color);
        }
        return colors;
    }

    // Process the asset data
    const processedAssetData = processAssetData(assetValueDistributionData);
    
    // Safety check
    if (processedAssetData.length === 0) {
        console.error('No processed asset data to display');
        document.getElementById('assetValueDistributionChart').innerHTML = 'No Asset Data Available';
    } else {
        // Generate colors for processed data
        const backgroundColors = generateUniqueColors(processedAssetData.length);

        // Prepare data for chart
        const categories = processedAssetData.map(item => item.category);
        const totalValues = processedAssetData.map(item => item.total_value);

        // Create the chart
        const chart = new Chart(assetValueDistributionChart, {
            type: 'doughnut',
            data: {
                labels: categories,
                datasets: [{
                    data: totalValues,
                    backgroundColor: backgroundColors,
                    borderColor: backgroundColors.map(color => color.replace('0.8)', '1)')),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                aspectRatio: 2.5,
                title: {
                    display: true,
                    text: 'Asset Value Distribution by Category'
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            const dataset = data.datasets[tooltipItem.datasetIndex];
                            const total = dataset.data.reduce((a, b) => a + b, 0);
                            const currentValue = dataset.data[tooltipItem.index];
                            const percentage = ((currentValue/total)*100).toFixed(2);
                            return `₱${currentValue.toLocaleString()} (${percentage}%)`;
                        }
                    }
                }
            }
        });

        // Expandable Legend 
        function createAssetExpandableLegend() {
            const container = document.getElementById('assetValueLegend');
            container.innerHTML = ''; // Clear previous content
            
            if (processedAssetData.length === 0) {
                container.innerHTML = 'No legend data available';
                return;
            }

            // Create legend container wrapper
            const legendWrapper = document.createElement('div');
            legendWrapper.className = 'relative';
            
            // Create scrollable legend content
            const legendContent = document.createElement('div');
            legendContent.id = 'assetLegendContent';
            legendContent.className = 'max-h-32 overflow-hidden transition-all duration-300 relative';
            
            // Append legend items
            processedAssetData.forEach((item, index) => {
                const legendItem = document.createElement('div');
                legendItem.className = 'flex items-center mb-2';
                legendItem.innerHTML = `
                    <span class="inline-block w-4 h-4 mr-2" style="background-color: ${backgroundColors[index]}"></span>
                    <span class="mr-2">${item.category}:</span>
                    <span class="font-bold">₱${item.total_value.toLocaleString()} (${item.percentage}%)</span>
                    <span class="ml-2 text-gray-500">(${item.asset_count} assets)</span>
                `;
                legendContent.appendChild(legendItem);
            });
            
            // Create toggle button
            const toggleBtn = document.createElement('button');
            toggleBtn.textContent = 'Show More';
            toggleBtn.className = 'mt-2 text-blue-500 hover:underline focus:outline-none';
            
            // Toggle functionality
            toggleBtn.addEventListener('click', () => {
                const content = document.getElementById('assetLegendContent');
                if (content.classList.contains('max-h-32')) {
                    content.classList.remove('max-h-32', 'relative');
                    content.classList.add('max-h-96');
                    toggleBtn.textContent = 'Show Less';
                } else {
                    content.classList.remove('max-h-96');
                    content.classList.add('max-h-32', 'relative');
                    toggleBtn.textContent = 'Show More';
                }
            });
            
            // Append to container only if there are more than 3 items
            if (processedAssetData.length > 3) {
                legendWrapper.appendChild(legendContent);
                legendWrapper.appendChild(toggleBtn);
                container.appendChild(legendWrapper);
            } else {
                // If 3 or fewer items, just append directly
                processedAssetData.forEach((item, index) => {
                    const legendItem = document.createElement('div');
                    legendItem.className = 'flex items-center mb-2';
                    legendItem.innerHTML = `
                        <span class="inline-block w-4 h-4 mr-2" style="background-color: ${backgroundColors[index]}"></span>
                        <span class="mr-2">${item.category}:</span>
                        <span class="font-bold">₱${item.total_value.toLocaleString()} (${item.percentage}%)</span>
                        <span class="ml-2 text-gray-500">(${item.asset_count} assets)</span>
                    `;
                    container.appendChild(legendItem);
                });
            }
        }

        // Create the expandable legend
        createAssetExpandableLegend();
    }
</script>
<script>
    // Inventory Value Distribution Chart
    const inventoryValueDistributionChart = document.getElementById('inventoryValueDistributionChart').getContext('2d');
    const inventoryValueDistributionData = {!! json_encode($inventoryValueDistribution) !!};
    
    // Function to process inventory data
    function processInventoryData(data, thresholdPercentage = 3) {
        // Sort data by total value in descending order
        const sortedData = data.sort((a, b) => b.total_value - a.total_value);
        
        // Separate major and minor brands
        const majorBrands = sortedData.filter(item => item.percentage >= thresholdPercentage);
        const minorBrands = sortedData.filter(item => item.percentage < thresholdPercentage);
        
        // Combine minor brands
        const combinedMinorBrands = {
            brand: 'Other Brands',
            total_value: minorBrands.reduce((sum, item) => sum + item.total_value, 0),
            inventory_count: minorBrands.reduce((sum, item) => sum + item.inventory_count, 0),
            percentage: minorBrands.reduce((sum, item) => sum + item.percentage, 0).toFixed(2)
        };

        // Combine results
        return [...majorBrands, combinedMinorBrands];
    }

    // Function to generate unique colors
    function generateUniqueColors(count) {
        const baseColors = [
            'hsla(210, 50%, 45%, 0.8)',  // Muted Blue
            'hsla(150, 50%, 45%, 0.8)',  // Muted Green
            'hsla(20, 50%, 45%, 0.8)',   // Muted Orange
            'hsla(270, 50%, 45%, 0.8)',  // Muted Purple
            'hsla(180, 50%, 45%, 0.8)',  // Muted Teal
            'hsla(0, 50%, 45%, 0.8)',    // Muted Red
            'hsla(45, 50%, 45%, 0.8)',   // Muted Gold
            'hsla(330, 50%, 45%, 0.8)',  // Muted Pink
        ];

        if (count <= baseColors.length) {
            return baseColors.slice(0, count);
        }

        const colors = [...baseColors];
        for (let i = baseColors.length; i < count; i++) {
            const hue = (i * 360 / count) % 360;
            const color = `hsla(${hue}, 50%, 45%, 0.8)`;
            colors.push(color);
        }
        return colors;
    }

    // Process the inventory data
    const processedInventoryData = processInventoryData(inventoryValueDistributionData);
    
    // Generate colors for processed data
    const inventoryBackgroundColors = generateUniqueColors(processedInventoryData.length);

    // Prepare data for chart
    const inventoryBrands = processedInventoryData.map(item => item.brand);
    const inventoryTotalValues = processedInventoryData.map(item => item.total_value);

    // Create expandable legend functionality
    function createExpandableLegend() {
        const container = document.getElementById('inventoryValueLegend');
        container.innerHTML = ''; // Clear previous content
        
        // Create legend container wrapper
        const legendWrapper = document.createElement('div');
        legendWrapper.className = 'relative';
        
        // Create scrollable legend content
        const legendContent = document.createElement('div');
        legendContent.id = 'inventoryLegendContent';
        legendContent.className = 'max-h-32 overflow-hidden transition-all duration-300 relative';
        
        // Append legend items
        processedInventoryData.forEach((item, index) => {
            const legendItem = document.createElement('div');
            legendItem.className = 'flex items-center mb-2';
            legendItem.innerHTML = `
                <span class="inline-block w-4 h-4 mr-2" style="background-color: ${inventoryBackgroundColors[index]}"></span>
                <span class="mr-2">${item.brand}:</span>
                <span class="font-bold">₱${item.total_value.toLocaleString()} (${item.percentage}%)</span>
                <span class="ml-2 text-gray-500">(${item.inventory_count} items)</span>
            `;
            legendContent.appendChild(legendItem);
        });
        
        // Create toggle button
        const toggleBtn = document.createElement('button');
        toggleBtn.textContent = 'Show More';
        toggleBtn.className = 'mt-2 text-blue-500 hover:underline focus:outline-none';
        
        // Toggle functionality
        toggleBtn.addEventListener('click', () => {
            const content = document.getElementById('inventoryLegendContent');
            if (content.classList.contains('max-h-32')) {
                content.classList.remove('max-h-32', 'relative');
                content.classList.add('max-h-96');
                toggleBtn.textContent = 'Show Less';
            } else {
                content.classList.remove('max-h-96');
                content.classList.add('max-h-32', 'relative');
                toggleBtn.textContent = 'Show More';
            }
        });
        
        // Append to container only if there are more than 3 items
        if (processedInventoryData.length > 3) {
            legendWrapper.appendChild(legendContent);
            legendWrapper.appendChild(toggleBtn);
            container.appendChild(legendWrapper);
        } else {
            // If 3 or fewer items, just append directly
            processedInventoryData.forEach((item, index) => {
                const legendItem = document.createElement('div');
                legendItem.className = 'flex items-center mb-2';
                legendItem.innerHTML = `
                    <span class="inline-block w-4 h-4 mr-2" style="background-color: ${inventoryBackgroundColors[index]}"></span>
                    <span class="mr-2">${item.brand}:</span>
                    <span class="font-bold">₱${item.total_value.toLocaleString()} (${item.percentage}%)</span>
                    <span class="ml-2 text-gray-500">(${item.inventory_count} items)</span>
                `;
                container.appendChild(legendItem);
            });
        }
    }

    // Create the chart
    const inventoryChart = new Chart(inventoryValueDistributionChart, {
        type: 'doughnut',
        data: {
            labels: inventoryBrands,
            datasets: [{
                data: inventoryTotalValues,
                backgroundColor: inventoryBackgroundColors,
                borderColor: inventoryBackgroundColors.map(color => color.replace('0.8)', '1)')),
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            aspectRatio: 2.5,
            title: {
                display: true,
                text: 'Inventory Value Distribution by Brand'
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        const dataset = data.datasets[tooltipItem.datasetIndex];
                        const total = dataset.data.reduce((a, b) => a + b, 0);
                        const currentValue = dataset.data[tooltipItem.index];
                        const percentage = ((currentValue/total)*100).toFixed(2);
                        return `₱${currentValue.toLocaleString()} (${percentage}%)`;
                    }
                }
            }
        }
    });

    // Create the expandable legend
    createExpandableLegend();
</script>
@endsection