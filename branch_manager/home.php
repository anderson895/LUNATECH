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



        <!-- <div class="bg-white p-4 rounded-lg shadow-md">
           <div class="row d-flex-wrap">
                <div class="col-7">
                    <h5 id="greeting" class="mt-3 color_red">greet</h5>
                    <h1 id="time" class="fw-bolder color_red" style="font-size: 3rem; margin-top: -10px; margin-bottom: -10px"></h1>
                    <h5 id="date" class="m-0 color_red">July 30, 2024</h5>
                </div>
                <div class="col-5" id="weatherAnimation">
                    <i id="gmorning" style="font-size: 5rem;" class="bi color_red bi-cloud-sun" hidden></i>
                    <i id="gafternoon" style="font-size: 5rem;" class="bi color_red bi-sun" hidden></i>
                    <i id="gdawn" style="font-size: 5rem;" class="bi color_red bi-sunset" hidden></i>
                    <i id="gevening" style="font-size: 5rem;" class="bi color_red bi-cloud-moon" hidden></i>
                </div>
            </div>
        </div> -->
        
        <!-- <div class="bg-white p-4 rounded-lg shadow-md">
            <h3 class="text-gray-600 text-sm">Total Purchase</h3>
            <p class="text-2xl font-bold text-gray-800 purchase_record_count">0</p>
        </div> -->


        <div class="bg-white p-4 rounded-lg shadow-md">
            <h3 class="text-gray-600 text-sm">Total Inventory Stocks</h3>
            <p class="text-2xl font-bold text-gray-800 stockCount">0</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-md">
            <h3 class="text-gray-600 text-sm">Daily Sales</h3>
            <p class="text-2xl font-bold text-gray-800 DailySales">0</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-md">
            <h3 class="text-gray-600 text-sm">Best Seller</h3>
            <p class="text-2xl font-bold text-gray-800 most_purchased_item" >Wireless Headphones</p>
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

<!-- Include ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>


<?php include "components/footer.php"; ?>
<script src="assets/js/daily_sales.js"></script>
<script src="assets/js/weekly_sales.js"></script>
<script src="assets/js/monthly_sales.js"></script>
<script src="assets/js/analytics.js"></script>
<!-- <script src="assets/js/date_today.js"></script> -->
