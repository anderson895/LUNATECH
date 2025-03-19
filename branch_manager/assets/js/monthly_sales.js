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

            // Prepare the data from the response
            var months = [];
            var sales = [];

            // Assuming the response is in the format: [{month: "January", sales: 1200}, ...]
            response.forEach(function(item) {
                months.push(item.month);
                sales.push(parseInt(item.sales)); // Ensure sales data is numeric
            });

            // Define chart options
            var options = {
                chart: {
                    type: 'area',
                    height: 300
                },
                series: [{
                    name: 'Sales',
                    data: sales
                }],
                xaxis: {
                    categories: months
                }
            };

            // Create and render the chart
            var chart = new ApexCharts(document.querySelector("#monthly_sales_chart"), options);
            chart.render();
        },
        error: function(xhr, status, error) {
            console.error("Error fetching sales data: ", status, error);
        }
    });
});
