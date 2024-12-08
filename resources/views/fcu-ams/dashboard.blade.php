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
                        <h3 class="text-md font-semibold my-auto">Assets <span class="invisible">Value aaa</span></h3>
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
                    <h3 class="text-md font-semibold my-auto">Asset Value <span class="invisible">aaa</span></h3>
                </div>
                <p class="text-3xl font-bold">₱{{ number_format($totalAssetValue, 2) }}</p>
            </div>
            <a href="{{ route('inventory.list') }}">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-10 w-10 mr-2" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path
                                d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z" />
                        </svg>
                        <h3 class="text-md inline-block font-semibold my-auto">Inventory Supplies</h3>
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
                    <h3 class="text-md font-semibold my-auto">Inventory Value</h3>
                </div>
                <p class="text-3xl font-bold">₱{{ number_format($totalInventoryValue, 2) }}</p>
            </div>
        </div>
        <div class="m-3 grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-3">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold mb-4">Asset Value Distribution</h3>
                <canvas id="assetValueDistributionChart"></canvas>
                <div id="assetValueLegend" class="mt-4"></div>
            </div>
            <!-- <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold">Asset Category Distribution</h3>
                <canvas id="assetDistributionChart"></canvas>
            </div> -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold mb-4">Inventory Value Distribution</h3>
                <canvas id="inventoryValueDistributionChart"></canvas>
                <div id="inventoryValueLegend" class="mt-4"></div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6 s col-span-2">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Monthly Asset Acquisition</h3>

                    <!-- Year Filter Dropdown -->
                    <form method="GET" action="{{ route('dashboard') }}" class="flex items-center">
                        <label for="yearFilter" class="mr-2">Year:</label>
                        <select name="year" id="yearFilter" class="form-select border rounded px-2 py-1"
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
                <canvas id="assetAcquisitionChart" class="mb-2"></canvas>
            </div>
            <!-- <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold">Asset Depreciation Trends</h3>
                <canvas id="depreciationTrendsChart"></canvas>
            </div> -->
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