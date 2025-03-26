$(document).ready(function () {
    function fetchSalesData(filterType = "monthly") {
        let chartElement = document.getElementById("sales_chart");

        // ✅ Ensure the chart container exists
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
                if (!response || Object.keys(response).length === 0) {
                    console.warn("⚠ No sales data found.");
                    $("#sales_chart").html("<p class='text-center text-gray-500'>No sales data available.</p>");
                    return;
                }

                let categories = filterType === "monthly"
                    ? ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']
                    : Array.from({ length: 31 }, (_, i) => i + 1); // Days 1-31

                let seriesData = [];

                Object.keys(response).forEach(branchName => {
                    let salesArray = categories.map(period => response[branchName]?.[period]?.total_sales || 0);
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
                            // ✅ Check if seriesData exists before accessing its properties
                            if (!seriesData[seriesIndex]) {
                                console.warn("⚠ Invalid seriesIndex:", seriesIndex);
                                return "";
                            }
                    
                            let branchName = seriesData[seriesIndex].name;
                            
                            // ✅ Ensure dataPointIndex is within range
                            if (!categories[dataPointIndex]) {
                                console.warn("⚠ Invalid dataPointIndex:", dataPointIndex);
                                return "";
                            }
                    
                            let period = categories[dataPointIndex];
                            let totalSales = response[branchName]?.[period]?.total_sales || 0;
                            let productList = response[branchName]?.[period]?.products || {};
                    
                            if (totalSales === 0) return ""; // ✅ Return empty string instead of `null`
                    
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

                // ✅ Destroy previous chart properly
                if (window.salesChart && typeof window.salesChart.destroy === "function") {
                    window.salesChart.destroy();
                }

                // ✅ Ensure chartElement exists before rendering
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

        // ✅ Fetch initial sales data immediately (no delay needed)
        fetchSalesData($("#salesFilter").val());
    } else {
        console.warn("⚠ Filter dropdown #salesFilter not found!");
    }
});
