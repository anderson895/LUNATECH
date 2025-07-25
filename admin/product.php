


<?php include "components/header.php";?>


<!-- Top bar with user profile -->
<div class="flex justify-between items-center bg-white p-4 mb-6 rounded-md shadow-md">
    <h2 class="text-lg font-semibold text-gray-700">Manage Products</h2>
    <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-lg font-bold text-white">
        <?php
        echo substr(ucfirst($On_Session[0]['user_username']), 0, 1);
        ?>
    </div>
</div>


<div class="bg-white rounded-lg shadow-lg p-6 mb-6">
    <!-- Top Section (Button & Search) -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-4">
        <div class="flex gap-2 w-full sm:w-auto">
            <button id="adduproductButton" class="bg-blue-500 text-white py-2 px-4 text-sm rounded-md flex items-center justify-center hover:bg-blue-600 transition duration-300 w-full sm:w-auto">
                <span class="material-icons mr-1 text-base">add</span>
                Add New
            </button>

            <button id="deleteAllBtn" class="bg-red-500 text-white py-2 px-4 text-sm rounded-md flex items-center justify-center hover:bg-red-600 transition duration-300 w-full sm:w-auto">
                Delete All
            </button>
        </div>

        <input type="text" id="searchInput" placeholder="Search item..." 
               class="border border-gray-300 p-2 rounded-md w-full sm:w-64 focus:ring-2 focus:ring-blue-400 focus:outline-none transition duration-300">
    </div>

    <!-- Table Wrapper for Responsiveness -->
    <div class="overflow-x-auto">
        <table id="userTable" class="table-auto w-full text-sm text-left text-gray-500 border-collapse">
            <thead class="bg-gray-100 text-gray-700 border-b">
                <tr>
                    <th class="p-3 text-center w-12">
                        <input type="checkbox" id="checkAll">
                    </th>
                 
                    <th class="p-3">Model</th>
                    <th class="p-3">Capital </th>
                    <th class="p-3">Current Price </th>
                    <th class="p-3">Added By</th>
                    <th class="p-3">Date Added</th>
                    <th class="p-3 text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Table rows will be populated dynamically -->
            </tbody>
        </table>
    </div>

    <!-- Bottom Section (Pagination & Total Count) -->
    <div class="flex flex-col sm:flex-row sm:justify-between items-center mt-4">
        <p id="totalProducts" class="text-xs text-gray-500"></p>
        <div id="pagination" class="flex space-x-2 mt-2 sm:mt-0"></div>
    </div>
</div>







<!-- Modal for Adding Promo -->
<div id="updateProductModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center" style="display:none;">
    <div class="bg-white shadow-md rounded-lg p-6 max-w-md mx-auto">

                <h3 class="text-xl font-semibold text-gray-900 mb-4">Update Product</h3>
                
                <form id="updateProductForm" class="space-y-4">
                    <!-- Spinner -->
                    <div id="spinner" class="hidden absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center">
                        <div class="w-10 h-10 border-4 border-indigo-500 border-t-transparent rounded-full animate-spin"></div>
                    </div>

                    <div hidden class="mb-4">
                        <label for="update_prod_id" class="block text-sm font-medium text-gray-700">ID</label>
                        <input type="text" id="update_prod_id" name="prod_id" class="w-full p-2 border rounded-md" required>
                    </div>

                    <!-- Product Name -->
                    <div>
                        <label for="update_prod_name" class="block text-sm font-medium text-gray-700">Model</label>
                        <input type="text" id="update_prod_name" name="prod_name" 
                            class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                            required>
                    </div>


                    

                      <!-- Product Price -->
                    <div>
                        <label for="update_product_capital" class="block text-sm font-medium text-gray-700">Capital Price</label>
                        <input type="text" id="update_product_capital" name="update_product_capital" 
                            class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                            >
                    </div>


                      <!-- Product Current Price -->
                      <div>
                        <label for="update_product_current" class="block text-sm font-medium text-gray-700">Current Price</label>
                        <input type="text" id="update_product_current" name="update_product_current" 
                            class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>


                    <!-- Buttons -->
                    <div class="flex justify-end space-x-2">
                        <button id="btnUpdateroduct" type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md transition">Update</button>
                        <button type="button" class="updateProductModalClose bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-md transition">Cancel</button>
                    </div>
                </form>
            </div>
           
           
    </div>
    
</div>


<!-- Modal for Adding Product -->
<div id="addProductModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center" style="display:none;">
    <div class="bg-white shadow-md rounded-lg p-6 mx-auto" style="width: 350px;">

                <h3 class="text-xl font-semibold text-gray-900 mb-4">Add New Product</h3>
                
                <form id="addproductForm" class="space-y-4">
                    <!-- Spinner -->
                    <div id="spinner" class="hidden absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center">
                        <div class="w-10 h-10 border-4 border-indigo-500 border-t-transparent rounded-full animate-spin"></div>
                    </div>

                    <!-- Product Name -->
                    <div>
                        <label for="new_product_name" class="block text-sm font-medium text-gray-700">Model</label>
                        <input type="text" id="new_product_name" name="new_product_name" 
                            class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                            >
                    </div>

                     <!-- Product Capital Price -->
                    <div>
                        <label for="new_product_capital" class="block text-sm font-medium text-gray-700">Capital Price</label>
                        <input type="text" id="new_product_capital" name="new_product_capital" 
                            class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Product Current Price -->
                    <div>
                        <label for="new_product_current" class="block text-sm font-medium text-gray-700">Current Price</label>
                        <input type="text" id="new_product_current" name="new_product_current" 
                            class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-end space-x-2">
                        <button id="btnAddProduct" type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md transition">Add New</button>
                        <button type="button" class="addProductModalClose bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-md transition">Cancel</button>
                    </div>
                </form>
            </div>

    </div>
</div>






<?php include "components/footer.php";?>
<script src="assets/js/table_product.js"></script>
