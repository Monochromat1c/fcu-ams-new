document.addEventListener("DOMContentLoaded", function () {
    const assetValueDistributionChart = document
        .getElementById("assetValueDistributionChart")
        .getContext("2d");
    const assetValueDistributionData = JSON.parse(
        document.getElementById("assetValueDistributionData").textContent
    );

    function processAssetData(data, thresholdPercentage = 3) {
        if (!data || data.length === 0) {
            console.error("No asset data available");
            return [];
        }

        const sortedData = data.sort((a, b) => b.total_value - a.total_value);

        const majorCategories = sortedData.filter(
            (item) => item.percentage >= thresholdPercentage
        );
        const minorCategories = sortedData.filter(
            (item) => item.percentage < thresholdPercentage
        );

        const combinedMinorCategories = {
            category: "Other Categories",
            total_value: minorCategories.reduce(
                (sum, item) => sum + item.total_value,
                0
            ),
            asset_count: minorCategories.reduce(
                (sum, item) => sum + item.asset_count,
                0
            ),
            percentage: minorCategories
                .reduce((sum, item) => sum + item.percentage, 0)
                .toFixed(2),
        };

        return [...majorCategories, combinedMinorCategories];
    }

    function generateUniqueColors(count) {
        return Array.from({ length: count }, (_, i) => {
            const hue = ((i * 360) / count) % 360;
            return `hsla(${hue}, 70%, 50%, 0.8)`;
        });
    }

    const processedAssetData = processAssetData(assetValueDistributionData);

    if (processedAssetData.length === 0) {
        document.getElementById("assetValueDistributionChart").innerHTML =
            "No Asset Data Available";
        return;
    }

    const backgroundColors = generateUniqueColors(processedAssetData.length);
    const categories = processedAssetData.map((item) => item.category);
    const totalValues = processedAssetData.map((item) => item.total_value);

    const chart = new Chart(assetValueDistributionChart, {
        type: "doughnut",
        data: {
            labels: categories,
            datasets: [
                {
                    data: totalValues,
                    backgroundColor: backgroundColors,
                    borderColor: backgroundColors.map((color) =>
                        color.replace("0.8)", "1)")
                    ),
                    borderWidth: 1,
                },
            ],
        },
        options: {
            responsive: true,
            aspectRatio: 2.5,
            title: {
                display: true,
                text: "Asset Value Distribution by Category",
            },
            tooltips: {
                callbacks: {
                    label: function (tooltipItem, data) {
                        const dataset = data.datasets[tooltipItem.datasetIndex];
                        const total = dataset.data.reduce((a, b) => a + b, 0);
                        const currentValue = dataset.data[tooltipItem.index];
                        const percentage = (
                            (currentValue / total) *
                            100
                        ).toFixed(2);
                        return `₱${currentValue.toLocaleString()} (${percentage}%)`;
                    },
                },
            },
        },
    });

    function createAssetExpandableLegend() {
        const container = document.getElementById("assetValueLegend");
        container.innerHTML = "";

        processedAssetData.forEach((item, index) => {
            const legendItem = document.createElement("div");
            legendItem.className = "flex items-center mb-2";
            legendItem.innerHTML = `
                <span class="inline-block w-4 h-4 mr-2" style="background-color: ${
                    backgroundColors[index]
                }"></span>
                <span class="mr-2">${item.category}:</span>
                <span class="font-bold">₱${item.total_value.toLocaleString()} (${
                item.percentage
            }%)</span>
                <span class="ml-2 text-gray-500">(${
                    item.asset_count
                } assets)</span>
            `;
            container.appendChild(legendItem);
        });
    }

    createAssetExpandableLegend();
});
