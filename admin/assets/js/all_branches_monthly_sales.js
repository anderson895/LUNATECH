$(document).ready(function () {
    $.ajax({
        url: 'backend/end-points/getMonthlySalesAllBranches.php',
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.error) {
                console.error(response.error);
                return;
            }

            let monthsList = [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ];

            let salesData = {}; 

            // Organize sales per branch and ensure all months are included
            Object.keys(response).forEach(branchName => {
                salesData[branchName] = {};

                // Initialize all months to 0
                monthsList.forEach(month => {
                    salesData[branchName][month] = 0;
                });

                // Fill in actual sales data
                Object.keys(response[branchName]).forEach(month => {
                    salesData[branchName][month] = response[branchName][month] || 0;
                });
            });

            let seriesData = [];
            Object.keys(salesData).forEach(branch => {
                let salesArray = monthsList.map(month => salesData[branch][month]);
                seriesData.push({
                    name: branch, 
                    data: salesArray
                });
            });

            var options = {
                chart: {
                    type: 'area',
                    height: 500 // Increase height here
                },
                series: seriesData,
                xaxis: {
                    categories: monthsList
                }
            };
            

            var chart = new ApexCharts(document.querySelector("#monthly_sales_chart"), options);
            chart.render();
        },
        error: function (xhr, status, error) {
            console.error("Error fetching sales data: ", status, error);
        }
    });
});
