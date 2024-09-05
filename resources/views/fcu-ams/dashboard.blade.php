@extends('layouts.layout')
@section('content')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

<div class="grid grid-cols-6">
    @include('layouts.sidebar')
    <div class="content min-h-screen bg-slate-100 col-span-5">
        <nav class="bg-white flex justify-between py-3 px-4 m-3 shadow-md rounded-md">
            <div></div>
            <h1 class="my-auto text-3xl">Dashboard</h1>
            <a href="" class="flex space-x-1" style="min-width:100px;">
                <svg class="h-10 w-10 my-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
                <p class="my-auto">Lighttt</p>
            </a>
        </nav>
        <div class="m-3 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
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
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex align-items-center mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mr-2" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path
                            d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z" />
                    </svg>
                    <h3 class="text-lg font-semibold my-auto">Total Inventory Stocks</h3>
                </div>
                <p class="text-3xl font-bold">{{ $totalInventoryStocks }}</p>
            </div>
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
                <canvas id="assetAcquisitionChart"></canvas>
            </div>
        </div>
        <div class="m-3 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold mb-4">Analytics</h3>
                <canvas id="analyticsChart"></canvas>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold mb-4">Asset and Supplier Distribution</h3>
                <div></div>
                <canvas id="distributionChart"></canvas>
                <p class="text-sm mb-4">
                    Most Acquired Asset Category:
                    <span
                        class="p-1 border-red-300 border bg-red-100 w">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                </p>
                <p class="text-sm mb-4">
                    Most Valued Asset Category:
                    <span
                        class="p-1 border-blue-300 border bg-blue-100 w">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                </p>
                <p class="text-sm mb-4">
                    Most Acquired Asset Supplier:
                    <span
                        class="p-1 border-yellow-300 border bg-yellow-100 w">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                </p>
                <p class="text-sm mb-4">
                    Most Valued Asset Supplier:
                    <span
                        class="p-1 border-green-500 border bg-green-100 w">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                </p>
            </div>
        </div>
        <div class="m-3">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold mb-4">Recent Item Actions</h3>
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
    </div>
</div>

<script src="{{ asset('js/chart.js') }}"></script>
<script>
    function confirmLogout() {
        if (confirm('Are you sure you want to logout?')) {
            document.getElementById('logout-form').submit();
        }
    }
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
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
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

    // Monthly Asset Acquisition Chart
    const assetAcquisitionChart = document.getElementById('assetAcquisitionChart').getContext('2d');
    const assetAcquisitionData = {!! json_encode($assetAcquisition) !!};
    const assetAcquisitionLabels = assetAcquisitionData.map(data => data.label);
    const assetAcquisitionValues = assetAcquisitionData.map(data => data.value);

    new Chart(assetAcquisitionChart, {
        type: 'bar',
        data: {
            labels: assetAcquisitionLabels,
            datasets: [{
                label: 'Monthly Asset Acquisition',
                data: assetAcquisitionValues,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
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
            }
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
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
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

    // Distribution Chart
const distributionChart = document.getElementById('distributionChart').getContext('2d');
const distributionData = {!! json_encode($distributionData) !!};
const distributionLabels = distributionData.map(data => data.value);
const distributionValues = [1, 1, 1, 1];

new Chart(distributionChart, {
    type: 'doughnut',
    data: {
        labels: distributionLabels,
        datasets: [{
            label: 'Asset and Supplier Distribution',
            data: distributionValues,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
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
            text: 'Asset and Supplier Distribution'
        },
        responsive: true,
        aspectRatio: 1.5
    }
});
</script>

@endsection