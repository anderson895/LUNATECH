$(document).ready(function () {
    function fetchSalesData(filterType = "monthly") {
        let chartElement = document.getElementById("sales_chart");

        if (!chartElement) {
            console.error("❌ Chart container #sales_chart not found!");
            return;
        }

        $.ajax({
            url: 'backend/end-points/getSalesAllBranches.php',
            method: 'GET',
            data: { filterType: filterType },
            dataType: 'json',
            success: function (response) {
                if (!response || !response.salesData || Object.keys(response.salesData).length === 0) {
                    console.warn("⚠ No sales data found.");
                    $("#sales_chart").html("<p class='text-center text-gray-500'>No sales data available.</p>");
                    return;
                }

                let filterType = response.filterType; // ✅ Read filterType from response
                let salesData = response.salesData;

                let categories = filterType === "monthly"
                    ? ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']
                    : Array.from({ length: 31 }, (_, i) => i + 1);

                let seriesData = [];

                Object.keys(salesData).forEach(branchName => {
                    let salesArray = categories.map(period => salesData[branchName]?.[period]?.total_sales || 0);
                    if (salesArray.some(sales => sales > 0)) {
                        seriesData.push({ name: branchName, data: salesArray });
                    }
                });

                if (seriesData.length === 0) {
                    console.warn("⚠ All branches have zero sales.");
                    $("#sales_chart").html("<p class='text-center text-gray-500'>No sales data available.</p>");
                    return;
                }

                let options = {
                    chart: { type: 'area', height: 500, toolbar: { show: true } },
                    series: seriesData,
                    xaxis: { categories: categories },
                    tooltip: {
                        custom: function ({ series, seriesIndex, dataPointIndex }) {
                            if (!seriesData[seriesIndex]) return "";
                            let branchName = seriesData[seriesIndex].name;
                            if (!categories[dataPointIndex]) return "";
                            let period = categories[dataPointIndex];
                            let totalSales = salesData[branchName]?.[period]?.total_sales || 0;
                            let productList = salesData[branchName]?.[period]?.products || {};

                            if (totalSales === 0) return "";

                            let productHTML = Object.entries(productList).length > 0
                                ? Object.entries(productList).map(([prodName, price]) => `<div>${prodName}: ₱${price.toLocaleString()}</div>`).join('')
                                : "<div class='text-gray-500'>No products sold</div>";

                            return `
                                <div style="padding:10px; border-radius: 5px; background: white; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);">
                                    <strong>${branchName} - ${period}</strong>
                                    <hr>
                                    <div><strong>Total Sales:</strong> ₱${totalSales.toLocaleString()}</div>
                                    ${productHTML}
                                </div>
                            `;
                        }
                    }
                };

                if (window.salesChart && typeof window.salesChart.destroy === "function") {
                    window.salesChart.destroy();
                }

                if (document.getElementById("sales_chart")) {
                    window.salesChart = new ApexCharts(chartElement, options);
                    window.salesChart.render();
                } else {
                    console.error("❌ Chart container missing before rendering!");
                }
            },
            error: function (xhr, status, error) {
                console.error("❌ Error fetching sales data:", status, error);
                $("#sales_chart").html("<p class='text-center text-red-500'>Failed to load sales data.</p>");
            }
        });
    }

    if ($("#salesFilter").length > 0) {
        $("#salesFilter").on("change", function () {
            fetchSalesData($(this).val());
        });

        fetchSalesData($("#salesFilter").val());
    } else {
        console.warn("⚠ Filter dropdown #salesFilter not found!");
    }
});
