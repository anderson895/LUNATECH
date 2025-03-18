


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
                    <th class="p-3">Barcode</th>
                    <th class="p-3">Code</th>
                    <th class="p-3">Product</th>
                    <th class="p-3">Price</th>
                    <th class="p-3 hidden md:table-cell">Added By</th>
                    <th class="p-3 hidden md:table-cell">Date Added</th>
                    <th class="p-3 text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                 
            </tbody>
          
        </table>
        <div id="pagination" class="flex justify-center space-x-2 mt-4"></div>
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
                        <label for="update_prod_name" class="block text-sm font-medium text-gray-700">Product Name</label>
                        <input type="text" id="update_prod_name" name="prod_name" 
                            class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                            required>
                    </div>

                    <div>
                        <label for="update_prod_price" class="block text-sm font-medium text-gray-700">Product Price</label>
                        <input type="text" id="update_prod_price" name="product_price" 
                            class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                            >
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



<!-- Modal for Adding Promo -->
<div id="addProductModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center" style="display:none;">
    <div class="bg-white shadow-md rounded-lg p-6 max-w-md mx-auto">

                <h3 class="text-xl font-semibold text-gray-900 mb-4">Add New Product</h3>
                
                <form id="addproductForm" class="space-y-4">
                    <!-- Spinner -->
                    <div id="spinner" class="hidden absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center">
                        <div class="w-10 h-10 border-4 border-indigo-500 border-t-transparent rounded-full animate-spin"></div>
                    </div>

                    <!-- Product Name -->
                    <div>
                        <label for="new_product_name" class="block text-sm font-medium text-gray-700">Product Name</label>
                        <input type="text" id="new_product_name" name="new_product_name" 
                            class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                            >
                    </div>


                     <!-- Product Price -->
                    <div>
                        <label for="new_product_capital" class="block text-sm font-medium text-gray-700">Capital Price</label>
                        <input type="text" id="new_product_capital" name="new_product_capital" 
                            class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                            >
                    </div>

                     <!-- Product Price -->
                     <div>
                        <label for="new_product_price" class="block text-sm font-medium text-gray-700">Current Price</label>
                        <input type="text" id="new_product_price" name="new_product_price" 
                            class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                            >
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
