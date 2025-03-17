<?php 
include "components/header.php";
?>

<!-- Top bar with user profile -->
<div class="max-w-12xl mx-auto flex justify-between items-center bg-white p-4 mb-6 rounded-md shadow-md">
    <h2 class="text-lg font-semibold text-gray-700">Inventory</h2>
    <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-lg font-bold text-white">
        <?php echo substr(ucfirst($On_Session[0]['user_username']), 0, 1); ?>
    </div>
</div>

<!-- Main Content -->
<div class="max-w-12xl mx-auto flex flex-col md:flex-row gap-8 items-start">

    <!-- Inventory Table (Wider) -->
    <div class="md:w-3/4 w-full bg-white shadow-lg rounded-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-700">Inventory List</h2>
            <!-- Search Bar -->
            <input type="text" id="searchInput" placeholder="Search item..." 
                   class="border border-gray-300 p-2 rounded-md w-64 focus:ring-2 focus:ring-blue-400">
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse shadow-sm rounded-lg" id="inventoryTable">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 border-b">
                        <th class="p-3 w-1/4 font-medium">Item</th>
                        <th class="p-3 w-1/4 font-medium">Current Stocks</th>
                        <th class="p-3 w-1/4 font-medium">Sold</th>
                        <th class="p-3 w-1/4 font-medium">Backjob</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600">
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="p-4">7p 128</td>
                        <td class="p-4">-</td>
                        <td class="p-4">-</td>
                        <td class="p-4">-</td>
                    </tr>
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="p-4">x 64</td>
                        <td class="p-4">-</td>
                        <td class="p-4">-</td>
                        <td class="p-4">-</td>
                    </tr>
                    <!-- Add more rows dynamically -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Record Form (Wider) -->
    <div class="md:w-1/4 w-full bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-xl font-bold mb-4 text-gray-700">Add New Record</h2>
        <form id="" class="flex flex-col gap-3">
            <input type="text" placeholder="Item Name" class="border border-gray-300 p-3 rounded-md w-full focus:ring-2 focus:ring-blue-400">
            <input type="number" placeholder="Current Stocks" class="border border-gray-300 p-3 rounded-md w-full focus:ring-2 focus:ring-blue-400">
            <input type="number" placeholder="Sold" class="border border-gray-300 p-3 rounded-md w-full focus:ring-2 focus:ring-blue-400">
            <input type="number" placeholder="Backjob" class="border border-gray-300 p-3 rounded-md w-full focus:ring-2 focus:ring-blue-400">
            <button type="submit" class="bg-blue-500 text-white p-3 rounded-md hover:bg-blue-600 transition-all">Add Record</button>
        </form>
    </div>

</div>



<?php include "components/footer.php"; ?>
