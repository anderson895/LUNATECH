<?php 
include "components/header.php";

$db = new global_class();
$branches = $db->get_all_branches(); // Fetch all branches
?>

<!-- Top bar with user profile -->
<div class="max-w-12xl mx-auto flex justify-between items-center bg-white p-4 mb-6 rounded-md shadow-md">
    <h2 class="text-lg font-semibold text-gray-700">Branch Sales For <span id="branch-label" >All Branches</span> 
    </h2>
    
    <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-lg font-bold text-white">
        <?php echo substr(ucfirst($On_Session[0]['user_username']), 0, 1); ?>
    </div>
</div>

<!-- Display All Branches -->
<div class="bg-white rounded-lg shadow-lg p-4 mb-4">
  
    <div class="flex flex-wrap gap-2">
        <!-- View All Button -->
        <button class="branch-filter bg-gray-500 text-white px-3 py-1 rounded-md text-sm" data-branch-id="">View All</button>

        <?php 
        if ($branches && $branches->num_rows > 0) {
            while ($branch = $branches->fetch_assoc()) {
                echo "<button class='branch-filter bg-blue-500 text-white px-3 py-1 rounded-md text-sm' data-branch-id='" . $branch['branch_id'] . "'>" . htmlspecialchars(ucfirst($branch['branch_name'])) . "</button>";
            }
        } else {
            echo "<p class='text-gray-500'>No branches found.</p>";
        }
        ?>
    </div>

    
</div>






<div class="bg-white rounded-lg shadow-lg p-6 mb-6">
    
    <!-- Top Section (Button & Search) -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-4">
        

        <input type="text" id="searchInput" placeholder="Search item..." 
               class="border border-gray-300 p-2 rounded-md w-full sm:w-64 focus:ring-2 focus:ring-blue-400">
    </div>

    <!-- Table Wrapper for Responsiveness -->
    <div class="overflow-x-auto">
        <table id="historyTable" class="table-auto w-full text-sm text-left text-gray-500">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="p-3 text-center">#</th>
                    <th class="p-3 text-center">Date</th>
                    <th class="p-3 text-center">Branch</th>
                    <th class="p-3 text-center">Invoice #</th>
                    <th class="p-3 text-center">Total Sold</th>
                    <th class="p-3 text-center">Profit</th>
                    <th class="p-3 text-center">Action</th>
                </tr>
            </thead>
            <tbody>
            
            </tbody>
          
        </table>
        <div id="pagination" class="flex justify-center space-x-2 mt-4"></div>
    </div>
</div>




<?php include "components/footer.php"; ?>

<script src="assets/js/table_history.js"></script>