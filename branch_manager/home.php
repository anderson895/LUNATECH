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
    <?php 
    if(isset($On_Session[0]['branch_id'])){ 
    ?>
    <!-- Dashboard Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        <div class="bg-white p-4 rounded-lg shadow-md">
            <h3 class="text-gray-600 text-sm">Total Inventory Stocks</h3>
            <p class="text-2xl font-bold text-gray-800 stockCount">0</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-md">
            <h3 class="text-gray-600 text-sm">Today Sales</h3>
            <p class="text-2xl font-bold text-gray-800 TodaySales">0</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-md">
            <h3 class="text-gray-600 text-sm">Best Seller</h3>
            <p class="text-2xl font-bold text-gray-800 most_purchased_item" ></p>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="bg-white mt-6 p-6 rounded-lg shadow-md">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Sales Overview</h3>
        <div id="monthly_sales_chart"></div>
    </div>






    <!-- Sales Performance Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6 mt-8">
    <!-- Daily Sales Performance Card -->
    <div class="bg-white p-6 rounded-lg shadow-lg w-full">
        <h3 class="text-gray-700 font-semibold text-lg mb-4">Sales Performance (Daily)</h3>
        <!-- Placeholder for Daily Chart -->
        <div class="w-full h-90 bg-gray-100 rounded-lg flex justify-center items-center" style="position: relative; overflow: hidden;">
            <div id="daily_sales_chart" style="width: 100%; height: 100%;"></div>
        </div>
    </div>

    <!-- Weekly Sales Performance Card -->
    <div class="bg-white p-6 rounded-lg shadow-lg w-full">
        <h3 class="text-gray-700 font-semibold text-lg mb-4">Sales Performance (Weekly)</h3>
        <!-- Placeholder for Weekly Chart -->
        <div class="w-full h-90 bg-gray-100 rounded-lg flex justify-center items-center" style="position: relative; overflow: hidden;">
            <div id="weekly_sales_chart" style="width: 100%; height: 100%;"></div>
        </div>
    </div>

</div>
<?php 
}else{
?>
<div class="w-full p-6 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 rounded-lg text-lg">
    <p class="font-bold">No Branches Assigned</p>
</div>
<?php 
}
?>

<!-- Include ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>


<?php include "components/footer.php"; ?>
<script src="assets/js/daily_sales.js"></script>
<script src="assets/js/weekly_sales.js"></script>
<script src="assets/js/monthly_sales.js"></script>
<script src="assets/js/analytics.js"></script>
<script src="assets/js/getTodaySalesData.js"></script>
