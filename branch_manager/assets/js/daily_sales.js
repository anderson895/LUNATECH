function renderSalesChart(dailySales, categories) {
    var options = {
        chart: {
            type: 'line',
            height: 400,
            zoom: {
                enabled: true
            },
            toolbar: {
                show: true
            }
        },
        series: [{
            name: 'Sales',
            data: dailySales
        }],
        xaxis: {
            categories: categories,
            labels: {
                rotate: -45,
                style: {
                    colors: '#333',
                    fontSize: '12px',
                    fontWeight: 'bold'
                }
            }
        },
        stroke: {
            curve: 'smooth',
            width: 2
        },
        markers: {
            size: 5,
            colors: ['#FF5733'],
            strokeColor: '#fff',
            strokeWidth: 2
        },
        grid: {
            borderColor: '#ddd'
        },
        tooltip: {
            shared: true,
            intersect: false,
            y: {
                formatter: function (value) {
                    return '₱' + value.toLocaleString(); // Format value with Peso symbol
                }
            }
        },
        colors: ['#28a745']
    };

    var chart = new ApexCharts(document.querySelector("#daily_sales_chart"), options);
    chart.render();
}

$.ajax({
    url: 'backend/end-points/getDailySales.php', 
    type: 'GET',
    dataType: 'json',
    success: function(data) {
        

        $(".DailySales").text(Number(data[0]['sales']).toLocaleString('en-PH', { style: 'currency', currency: 'PHP' }));

        // DailySales
        let dailySalesData = [];
        let days = [];

        data.forEach(function(item) {
            dailySalesData.push(item.sales);
            days.push(item.date);
        });
        renderSalesChart(dailySalesData, days);
    },
    error: function(xhr, status, error) {
        console.error('Error fetching daily sales data:', error);
    }
});