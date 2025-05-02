<?php 
include "components/header.php";



?>
<input type="text" id="branch_id" value="<?=$On_Session[0]['branch_id']?>">
<!-- Top bar with user profile -->
<div class="max-w-12xl mx-auto flex justify-between items-center bg-white p-4 mb-6 rounded-md shadow-md">
    <h2 class="text-lg font-semibold text-gray-700">History</h2>
    <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-lg font-bold text-white">
        <?php echo substr(ucfirst($On_Session[0]['user_username']), 0, 1); ?>
    </div>
</div>






<div class="bg-white rounded-lg shadow-lg p-6 mb-6">
    <!-- Top Section (Button & Search) -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-4">
    

    <input type="text" id="searchInput" placeholder="Search item..." 
           class="border border-gray-300 p-2 rounded-md w-full sm:w-64 focus:ring-2 focus:ring-blue-400">


    <div class="flex gap-2">
        <button id="btnViewSummary" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md shadow flex items-center gap-2">
            <span class="material-icons">bar_chart</span>
            Sales Summary
        </button>
    </div>


</div>

    <!-- Table Wrapper for Responsiveness -->
    <div class="overflow-x-auto">
        <table id="historyTable" class="table-auto w-full text-sm text-left text-gray-500">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="p-3 text-center">#</th>
                    <th class="p-3 text-center">Date</th>
                    <th class="p-3 text-center">Invoice #</th>
                    <th class="p-3 text-center">Total Sold</th>
                    <th class="p-3 text-center">Unit Sold</th>
                    <th class="p-3 text-center">Action</th>
                </tr>
            </thead>
            <tbody>
            
            </tbody>
          
        </table>
        <div id="pagination" class="flex justify-center space-x-2 mt-4"></div>
    </div>
</div>






<!-- Modal Overlay -->
<div id="salesSummaryModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;">
    <div class="bg-white w-full max-w-md rounded-lg shadow-lg p-6 relative">
        <!-- Close Button -->
        <button id="closeModal" class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 text-2xl font-bold">
            &times;
        </button>

        <!-- Modal Content -->
        <h2 class="text-xl font-semibold mb-4 text-gray-700">Sales Summary</h2>

        <!-- Date Inputs -->
        <div class="mb-4">
            <label for="fromDate" class="block text-sm font-medium text-gray-600">From:</label>
            <input type="date" id="fromDate" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-blue-400 focus:border-blue-400">
        </div>

        <div class="mb-4">
            <label for="toDate" class="block text-sm font-medium text-gray-600">To:</label>
            <input type="date" id="toDate" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-blue-400 focus:border-blue-400">
        </div>

        <!-- View Button -->
        <button id="viewSummaryBtn" class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-md">
            View
        </button>
    </div>
</div>






<script>
$(document).ready(function() {
    $('#btnViewSummary').click(function() {
        $('#salesSummaryModal').fadeIn(200);
    });

    $('#closeModal').click(function() {
        $('#salesSummaryModal').fadeOut(200);
    });

    // Optional: Close when clicking outside the modal content
    $('#salesSummaryModal').click(function(e) {
        if (e.target.id === 'salesSummaryModal') {
            $(this).fadeOut(200);
        }
    });

    $('#viewSummaryBtn').click(function() {
        const branch_id= $("#branch_id").val();
        const from = $('#fromDate').val();
        const to = $('#toDate').val();

        // Check if both 'from' and 'to' dates are selected
        if (!from) {
            alertify.error("Please select date from.");
            return;
        }

        if (!to) {
            alertify.error("Please select date to.");
            return;
        }

        // Redirect with query parameters if both dates are selected
        window.location.href = `View_summary?branch_id=${branch_id}&from=${encodeURIComponent(from)}&to=${encodeURIComponent(to)}`;

    });



});
</script>




<?php include "components/footer.php"; ?>

<script src="assets/js/table_history.js"></script>