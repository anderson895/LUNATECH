


<?php include "components/header.php";?>


<!-- Top bar with user profile -->
<div class="flex justify-between items-center bg-white p-4 mb-6 rounded-md shadow-md">
    <h2 class="text-lg font-semibold text-gray-700">Manage Branches</h2>
    <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-lg font-bold text-white">
        <?php
        echo substr(ucfirst($On_Session[0]['user_username']), 0, 1);
        ?>
    </div>
</div>





<!-- User Table Card -->
<div class="bg-white rounded-lg shadow-lg p-6 mb-6">

    <!-- <button id="addBranchButton" class="bg-blue-500 text-white py-2 px-4 text-sm rounded-lg flex items-center hover:bg-blue-600 transition duration-300 mb-4">
        <span class="material-icons mr-2 text-base">storefront</span>
        New Branch
    </button> -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-4">
        <div class="flex gap-2 w-full sm:w-auto">
            <button id="addBranchButton" class="bg-blue-500 text-white py-2 px-4 text-sm rounded-md flex items-center justify-center hover:bg-blue-600 transition duration-300 w-full sm:w-auto">
                <span class="material-icons mr-1 text-base">storefront</span>
                New Branch
            </button>

            <button id="deleteAllBtn" class="bg-red-500 text-white py-2 px-4 rounded-md hover:bg-red-600 transition duration-300 w-full sm:w-auto">
                Delete All
            </button>
        </div>

        <input type="text" id="searchInput" placeholder="Search item..." 
               class="border border-gray-300 p-2 rounded-md w-full sm:w-64 focus:ring-2 focus:ring-blue-400">
    </div>

    <!-- Table Wrapper for Responsiveness -->
    <div class="overflow-x-auto">
        <table id="userTable" class="table-auto w-full text-sm text-left text-gray-500">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="p-3 text-center">
                        <input type="checkbox" id="checkAll">
                    </th>
                    <th class="p-3">Branch Code</th>
                    <th class="p-3">Branch Name</th>
                    <th class="p-3">Branch Address</th>
                    <th class="p-3">Branch Manager</th>
                    
                    
                    <th class="p-3 text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                 
                 </tbody>
               
             </table>
             <div id="pagination" class="flex justify-center space-x-2 mt-4"></div>
         </div>
     </div>






</div>



<!-- Modal for Adding Promo -->
<div id="updateUserModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center" style="display:none;">
    <div class="bg-white rounded-lg shadow-lg w-96 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Update Information</h3>
        <form id="updatebranchForm">
            <!-- Spinner -->
            <div class="spinner" id="spinner" style="display:none;">
                <div class="absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center">
                    <div class="w-10 h-10 border-4 border-indigo-500 border-t-transparent rounded-full animate-spin"></div>
                </div>
            </div>

            <div class="mb-4" hidden>
                <label for="branch_id" class="block text-sm font-medium text-gray-700">User ID</label>
                <input type="text" id="branch_id" name="branch_id" class="w-full p-2 border rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="update_branch_code" class="block text-sm font-medium text-gray-700">Branch Code</label>
                <input type="text" id="update_branch_code" name="branch_code" class="w-full p-2 border rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="update_branch_name" class="block text-sm font-medium text-gray-700">Store Name</label>
                <input type="text" id="update_branch_name" name="branch_name" class="w-full p-2 border rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="update_branch_address" class="block text-sm font-medium text-gray-700">Branch Address</label>
                <input type="text" id="update_branch_address" name="branch_address" class="w-full p-2 border rounded-md" required>
            </div>

          


            <div class="mb-4">
                <label for="update_branch_manager" class="block text-sm font-medium text-gray-700">Branch Manager</label>
                <select id="update_branch_manager" name="branch_manager" class="w-full p-2 border rounded-md" required>
                    <option id="currentValue" value="">Current Value</option>
                    <?php include "backend/end-points/branch_manager_list.php";?>
                </select>
            </div>


            <div class="flex justify-end gap-2">
                <button type="button" class="UpdateBranchModalClose bg-gray-500 hover:bg-gray-600 text-white py-1 px-3 rounded-md">Cancel</button>
                <button id="btnUpdateBranches" type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded-md">Update Branch</button>
            </div>
        </form>
    </div>
</div>




<!-- Modal for Adding Promo -->
<div id="addBranchModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center" style="display:none;">
    <div class="bg-white rounded-lg shadow-lg w-96 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Add New Branch</h3>
        <form id="addbranchForm">
            
            <!-- Spinner -->
            <div class="spinner" id="spinner" style="display:none;">
                <div class="absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center">
                    <div class="w-10 h-10 border-4 border-indigo-500 border-t-transparent rounded-full animate-spin"></div>
                </div>
            </div>

            <div class="mb-4">
                <label for="new_branch_code" class="block text-sm font-medium text-gray-700">Branch Code</label>
                <input type="text" id="new_branch_code" name="branch_code" class="w-full p-2 border rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="new_branch_name" class="block text-sm font-medium text-gray-700">Store Name</label>
                <input type="text" id="new_branch_name" name="branch_name" class="w-full p-2 border rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="new_branch_address" class="block text-sm font-medium text-gray-700">Branch Address</label>
                <input type="text" id="new_branch_address" name="branch_address" class="w-full p-2 border rounded-md" required>
            </div>





            <div class="mb-4">
                <label for="new_branch_manager" class="block text-sm font-medium text-gray-700">Branch Manager</label>
                <select id="new_branch_manager" name="branch_manager" class="w-full p-2 border rounded-md" required>
                    <option value="">Select Manager</option>
                    <?php include "backend/end-points/branch_manager_list.php";?>
                </select>
            </div>


            <div class="flex justify-end gap-2">
                <button type="button" class="addBranchModalClose bg-gray-500 hover:bg-gray-600 text-white py-1 px-3 rounded-md">Cancel</button>
                <button id="btnAddBranches" type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded-md">Add Branch</button>
            </div>
        </form>
    </div>
</div>







<?php include "components/footer.php";?>
<script src="assets/js/table_branches.js"></script>
