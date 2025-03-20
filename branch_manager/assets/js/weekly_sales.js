
$.ajax({
    url: 'backend/end-points/getWeeklySales.php',  
    type: 'GET',
    dataType: 'json',
    success: function(data) {
        
        let weeklySalesData = [];
        let weeks = [];

      
        data.forEach(function(item) {
            weeklySalesData.push(item.sales);  
            weeks.push(item.week); 
        });

        var options = {
            chart: {
                type: 'bar',
                height: 400,
                toolbar: {
                    show: true
                }
            },
            series: [{
                name: 'Weekly Sales',
                data: weeklySalesData 
            }],
            xaxis: {
                categories: weeks,  
                labels: {
                    style: {
                        colors: '#333',
                        fontSize: '14px',
                        fontWeight: 'bold'
                    }
                }
            },
            colors: ['#2e93f9'],  // Blue color for bars
            grid: {
                show: true,
                borderColor: '#ccc',
                strokeDashArray: 4,
                xaxis: {
                    lines: { show: true }
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '60%',
                    endingShape: 'rounded'
                }
            },
            dataLabels: {
                enabled: false
            },
            tooltip: {
                y: {
                    formatter: function (value) {
                        return '₱' + value.toLocaleString();  
                    }
                }
            }
        };

        // Render the chart
        var chart = new ApexCharts(document.querySelector("#weekly_sales_chart"), options);
        chart.render();
    },
    error: function(xhr, status, error) {
        console.error('Error fetching weekly sales data:', error);
    }
});