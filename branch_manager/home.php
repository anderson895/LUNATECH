<?php 
include "components/header.php";
?>


    <!-- Top bar with user profile -->
    <div class="max-w-12xl mx-auto flex justify-between items-center bg-white p-4 mb-6 rounded-md shadow-md">
        <h2 class="text-lg font-semibold text-gray-700">Welcome, <?= ucfirst($On_Session[0]['user_fullname']) ?></h2>
        <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-lg font-bold text-white">
            <?php echo substr(ucfirst($On_Session[0]['user_username']), 0, 1); ?>
        </div>
    </div>

    <!-- Dashboard Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white p-4 rounded-lg shadow-md">
            <h3 class="text-gray-600 text-sm">Daily Sales</h3>
            <p class="text-2xl font-bold text-gray-800">$540</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-md">
            <h3 class="text-gray-600 text-sm">Weekly Sales</h3>
            <p class="text-2xl font-bold text-gray-800">$3,780</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-md">
            <h3 class="text-gray-600 text-sm">Monthly Sales</h3>
            <p class="text-2xl font-bold text-gray-800">$15,640</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-md">
            <h3 class="text-gray-600 text-sm">Total Stocks</h3>
            <p class="text-2xl font-bold text-gray-800">1,245</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-md col-span-2">
            <h3 class="text-gray-600 text-sm">Best Seller</h3>
            <p class="text-2xl font-bold text-gray-800">Wireless Headphones</p>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="bg-white mt-6 p-6 rounded-lg shadow-md">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Sales Overview</h3>
        <div id="chart"></div>
    </div>


<!-- Include ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    var options = {
        chart: {
            type: 'area',
            height: 300
        },
        series: [{
            name: 'Sales',
            data: [400, 700, 1000, 1200, 1500, 1800, 2100, 2500, 3000, 3400, 3900, 4200]
        }],
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        }
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
</script>

<?php include "components/footer.php"; ?>
