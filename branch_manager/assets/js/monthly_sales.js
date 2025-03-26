$(document).ready(function() {
    // AJAX request to fetch the monthly sales data
    $.ajax({
        url: 'backend/end-points/getMonthlySales.php',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.error) {
                console.error(response.error);
                return;
            }

            // Extract months and total monthly sales
            var months = Object.keys(response.total_monthly_sales);
            var totalSales = Object.values(response.total_monthly_sales).map(Number); // Convert to numbers

            // Initialize product-wise sales for tooltip
            var productSales = {};

            // Process product sales breakdown
            Object.entries(response.sales_by_product).forEach(([month, products]) => {
                var productInfo = products.map(product => `${product.product}: ${product.sales}`).join("<br>");
                productSales[month] = productInfo;
            });

            // Define ApexCharts options
            var options = {
                chart: {
                    type: 'area',
                    height: 300
                },
                series: [{
                    name: 'Total Sales',
                    data: totalSales
                }],
                xaxis: {
                    categories: months
                },
                tooltip: {
                    shared: true,
                    custom: function({ series, seriesIndex, dataPointIndex, w }) {
                        var month = w.globals.categoryLabels[dataPointIndex];
                        var total = series[seriesIndex][dataPointIndex];
                        var productBreakdown = productSales[month] || "No product sales";
                        return `
                            <div class="bg-white p-2 shadow-md rounded-md">
                                <strong>${month}</strong><br>
                                Total Sales: ₱${total.toLocaleString()}<br>
                                <hr>
                                ${productBreakdown}
                            </div>
                        `;
                    }
                }
            };

            // Create and render the chart
            var chart = new ApexCharts(document.querySelector("#monthly_sales_chart"), options);
            chart.render();
        },
        error: function(xhr, status, error) {
            console.error("Error fetching sales data:", status, error);
        }
    });
});
