


<?php include "components/header.php";?>

<!-- Top bar with user profile -->
<div class="flex justify-between items-center bg-white p-4 mb-6 rounded-md shadow-md">
    <h2 class="text-lg font-semibold text-gray-700">Dashboard</h2>
    <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-lg font-bold text-white">
        <?php
        echo substr(ucfirst($On_Session[0]['user_username']), 0, 1);
        ?>
    </div>
</div>

<!-- Dashboard Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Card for Total Customer -->
    <div class="bg-white p-6 rounded-lg shadow-lg flex flex-col items-center">
        <img src="assets/image/management.png" alt="students icon" class="mb-4 w-12 max-w-full" />
        <h3 class="text-gray-700 font-semibold text-lg">No of user</h3>
        <p class="text-blue-500 text-2xl font-bold totalUser">0</p>
    </div>

    <!-- Card for Total Sales -->
    <div class="bg-white p-6 rounded-lg shadow-lg flex flex-col items-center">
        <img src="assets/image/business.png" alt="students icon" class="mb-4 w-12 max-w-full" />
        <h3 class="text-gray-700 font-semibold text-lg">Total Branch</h3>
        <p class="text-blue-500 text-2xl font-bold totalBranches">0</p>
    </div>

    <!-- Card for No of Orders -->
    <div class="bg-white p-6 rounded-lg shadow-lg flex flex-col items-center">
        <img src="assets/image/cost.png" alt="students icon" class="mb-4 w-12 max-w-full" />
        <h3 class="text-gray-700 font-semibold text-lg">Total Products</h3>
        <p class="text-blue-500 text-2xl font-bold numOrders totalProduct">0</p>
    </div>
</div>




<div class="bg-white mt-6 p-6 rounded-lg shadow-md">
    <h3 class="text-lg font-semibold text-gray-700 mb-4">Sales Overview</h3>

    <!-- Sales Filter -->
    <div class="mb-4 flex space-x-4">
        <select id="salesFilter" class="p-2 border rounded">
            <option value="monthly">Monthly Sales</option>
            <option value="daily">Daily Sales</option>
        </select>
    </div>

    <!-- Sales Chart -->
    <div id="sales_chart"></div> <!-- ✅ Ensure this exists -->
</div>










</div>


<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<?php include "components/footer.php";?>
<script src="assets/js/analytics.js"></script>
<script src="assets/js/all_branches_sales.js"></script>
