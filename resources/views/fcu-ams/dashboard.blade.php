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
    <div class="content min-h-screen bg-slate-100 col-span-5">
        <nav class="bg-white flex justify-between py-3 px-4 m-3 shadow-md rounded-md">
            <div></div>
            <h1 class="my-auto text-3xl">Dashboard</h1>
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
        <div class="m-3 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <a href="{{ route('asset.list') }}">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex align-items-center mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mr-2" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                clip-rule="evenodd" />
                        </svg>
                        <h3 class="text-lg font-semibold my-auto">Total Assets</h3>
                    </div>
                    <p class="text-3xl font-bold">{{ $totalAssets }}</p>
                </div>
            </a>
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex align-items-center mb-2">
                    <svg class="h-10 w-10 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <h3 class="text-lg font-semibold my-auto">Total Asset Value</h3>
                </div>
                <p class="text-3xl font-bold">₱{{ number_format($totalAssetValue, 2) }}</p>
            </div>
            <a href="{{ route('inventory.list') }}">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex align-items-center mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mr-2" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path
                                d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z" />
                        </svg>
                        <h3 class="text-lg font-semibold my-auto">Total Inventory Supplies</h3>
                    </div>
                    <p class="text-3xl font-bold">{{ $totalInventoryStocks }}</p>
                </div>
            </a>
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex align-items-center mb-2">
                    <svg class="h-10 w-10 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <h3 class="text-lg font-semibold my-auto">Total Inventory Value</h3>
                </div>
                <p class="text-3xl font-bold">₱{{ number_format($totalInventoryValue, 2) }}</p>
            </div>
        </div>
        <div class="m-3 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold mb-4">Asset Category Distribution</h3>
                <canvas id="assetDistributionChart"></canvas>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold mb-4">Monthly Asset Acquisition</h3>
                <canvas id="assetAcquisitionChart" class="mb-2"></canvas>
                {{ $assetAcquisition->links() }}
            </div>
        </div>
        <div class="m-3 grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold mb-4">Analytics</h3>
                <canvas id="analyticsChart"></canvas>
            </div> -->
            <!-- <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold mb-4">Inventory and Supplier Distribution</h3>
                <div></div>
                <canvas id="distributionChart" class="mb-4"></canvas>
                <p class="mb-1">
                    Most Valued Inventory Supplier:
                    @if($mostValuedInventorySupplierName)
                        <span
                            class="">{{ $mostValuedInventorySupplierName }}</span>
                    @else
                        <span class="">No Data Available</span>
                    @endif
                </p>
                <p class="mb-1">
                    Most Acquired Inventory Supplier:
                    @if($mostAcquiredInventorySupplierName)
                        <span
                            class="">{{ $mostAcquiredInventorySupplierName }}</span>
                    @else
                        <span class="">No Data Available</span>
                    @endif
                </p>
            </div> -->
            <div class="bg-white rounded-lg shadow-md p-6 col-span-2">
                <h3 class="text-lg font-semibold mb-4">Recent Actions</h3>
                <ul class="divide-y divide-gray-200">
                    @foreach($recentActions as $action)
                        <li class="py-3 flex justify-between items-center">
                            <div>
                                <span class="font-medium">{{ $action['type'] }}:</span>
                                {{ $action['name'] }} was
                                {{ $action['action'] }}
                            </div>
                            <span class="text-sm text-gray-500">{{ $action['date'] }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="m-3">
            
        </div>
    </div>
</div>

<script src="{{ asset('js/chart.js') }}"></script>
<script>
    const assetAcquisitionChart = document.getElementById('assetAcquisitionChart').getContext('2d');
    const assetAcquisitionData = {!! json_encode($assetAcquisition->items()) !!}; // get the items of the paginated collection
    const assetAcquisitionLabels = assetAcquisitionData.map(data => data.month);
    const assetAcquisitionValues = assetAcquisitionData.map(data => data.count);
    const assetAcquisitionAssetTags = assetAcquisitionData.map(data => data.asset_tags);

    new Chart(assetAcquisitionChart, {
        type: 'bar',
        data: {
            labels: assetAcquisitionLabels,
            datasets: [{
                label: 'Monthly Asset Acquisition',
                data: assetAcquisitionValues,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(255, 206, 86, 0.8)',
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(153, 102, 255, 0.8)',
                    'rgba(255, 159, 64, 0.8)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            title: {
                display: true,
                text: 'Monthly Asset Acquisition'
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        const index = tooltipItem.index;
                        const count = assetAcquisitionValues[index];
                        const assetTags = assetAcquisitionAssetTags[index];
                        return `Assets: ${count} (${assetTags})`;
                    }
                }
            }
        }
    });
</script>
 
<script>
    // Asset Distribution Chart
    const assetDistributionChart = document.getElementById('assetDistributionChart').getContext('2d');
    const assetDistributionData = {!! json_encode($assetDistribution) !!};
    const assetDistributionLabels = assetDistributionData.map(data => data.label);
    const assetDistributionValues = assetDistributionData.map(data => data.value);

    new Chart(assetDistributionChart, {
        type: 'pie',
        data: {
            labels: assetDistributionLabels,
            datasets: [{
                label: 'Asset Distribution',
                data: assetDistributionValues,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(255, 206, 86, 0.8)',
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(153, 102, 255, 0.8)',
                    'rgba(255, 159, 64, 0.8)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            title: {
                display: true,
                text: 'Asset Distribution'
            },
            responsive: true,
            aspectRatio: 1.5
        }
    });
</script>
<script>
    // Analytics Chart
    const analyticsChart = document.getElementById('analyticsChart').getContext('2d');
    const analyticsData = {!! json_encode($analyticsData) !!};
    const analyticsLabels = analyticsData.map(data => data.label);
    const analyticsValues = analyticsData.map(data => data.value);

    new Chart(analyticsChart, {
        type: 'line',
        data: {
            labels: analyticsLabels,
            datasets: [{
                label: 'Analytics',
                data: analyticsValues,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(255, 206, 86, 0.8)',
                    'rgba(75, 192, 192, 0.8)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            title: {
                display: true,
                text: 'Analytics'
            }
        }
    });
</script>
<script>
    // Distribution Chart
    const distributionChart = document.getElementById('distributionChart').getContext('2d');
    const distributionData = {!! json_encode($distributionData) !!};
    const distributionLabels = distributionData.map(data => data.value);
    const distributionValues = [1, 1];

    new Chart(distributionChart, {
        type: 'doughnut',
        data: {
            labels: distributionLabels,
            datasets: [{
                label: 'Inventory and Supplier Distribution',
                data: distributionValues,
                backgroundColor: [
                    'rgba(0, 48, 73, 0.8)',
                    'rgba(184, 97, 37, 0.8)'
                ],
                borderColor: [
                    'rgba(0, 48, 73, 1)',
                    'rgba(184, 97, 37, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            title: {
                display: true,
                text: 'Inventory and Supplier Distribution'
            },
            responsive: true,
            aspectRatio: 1.5
        }
    });
</script>
@endsection