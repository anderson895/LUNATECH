<?php 
include "components/header.php";
?>

<div class="max-w-12xl mx-auto flex justify-between items-center bg-white p-4 mb-6 rounded-md shadow-md">
    <h2 class="text-lg font-semibold text-gray-700">Inventory</h2>
    <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-lg font-bold text-white">
        <?php echo substr(ucfirst($On_Session[0]['user_username']), 0, 1); ?>
    </div>
</div>

<?php 
if(isset($On_Session[0]['branch_id'])){ 
?>
<!-- Main Content -->
<div class="max-w-12xl mx-auto flex flex-col md:flex-row gap-8 items-start">

    <!-- Inventory Table (Wider) -->
    <div class="md:w-3/4 w-full bg-white shadow-lg rounded-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-700">Inventory List</h2>
            <!-- Search Bar -->
            <input type="text" id="searchInputInv" placeholder="Search item..." 
                   class="border border-gray-300 p-2 rounded-md w-64 focus:ring-2 focus:ring-blue-400">
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse shadow-sm rounded-lg" id="inventoryTable">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 border-b">
                        <th class="p-3 w-1/4 font-medium">Barcode</th>
                        <th class="p-3 w-1/4 font-medium">Code</th>
                        <th class="p-3 w-1/4 font-medium">Item</th>
                        <th class="p-3 w-1/4 font-medium">Current Stocks</th>
                        <th class="p-3 w-1/4 font-medium">Sold</th>
                        <th class="p-3 w-1/4 font-medium">Backjob</th>
                        <th class="p-3 w-1/4 font-medium">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600">
                    
                </tbody>
            </table>
             <!-- <div id="pagination" class="flex justify-center space-x-2 mt-4"></div> -->
        </div>
    </div>
    

    <!-- Add Record Form (Wider) -->
    <div class="md:w-1/4 w-full bg-white shadow-lg rounded-lg p-6 relative">
        <h2 class="text-xl font-bold mb-4 text-gray-700">Add New Record</h2>
        <form id="product-form" class="flex flex-col gap-3 relative w-full max-w-lg mx-auto">
    <!-- Search Product Input -->
    <div class="relative w-full">
        <input type="text" id="stock_in_prod_code" name="stock_in_prod_code" placeholder="Search Product"
            class="border border-gray-300 p-3 rounded-md w-full focus:ring-2 focus:ring-blue-400">
        <!-- Suggestions Box -->
        <div id="productSuggestions"
            class="absolute bg-white border border-gray-300 rounded-md shadow-md w-full hidden z-10 mt-1 overflow-auto max-h-60">
            <!-- Suggestions will appear here -->
        </div>
    </div>

    <!-- Hidden Product ID -->
    <input hidden type="text" readonly id="stock_in_prod_id" name="stock_in_prod_id"
        class="border border-gray-300 p-3 rounded-md w-full focus:ring-2 focus:ring-blue-400">

    <!-- Product Name -->
    <input type="text" readonly id="stock_in_prod_name" name="stock_in_prod_name" placeholder="Product Name"
        class="border border-gray-300 p-3 rounded-md w-full focus:ring-2 focus:ring-blue-400">

    <!-- Quantity Input -->
    <input type="number" placeholder="Qty" id="stock_in_qty" name="stock_in_qty"
        class="border border-gray-300 p-3 rounded-md w-full focus:ring-2 focus:ring-blue-400">

    <!-- Sold Input -->
    <input type="number" placeholder="Sold" id="stock_in_sold" name="stock_in_sold"
        class="border border-gray-300 p-3 rounded-md w-full focus:ring-2 focus:ring-blue-400">

    <!-- Backjob Input -->
    <input type="number" placeholder="Backjob" id="stock_in_backjob" name="stock_in_backjob"
        class="border border-gray-300 p-3 rounded-md w-full focus:ring-2 focus:ring-blue-400">

    <!-- Add Button -->
    <button type="submit" id="BtnaddInventory"
        class="bg-green-500 text-white p-3 rounded-md hover:bg-green-600 transition-all">
        Add Record
    </button>
</form>

    </div>

    

</div>

<!-- Stock List Table -->
<div class="max-w-12xl mx-auto mt-8 bg-white shadow-lg rounded-lg p-6">
    <h2 class="text-xl font-bold text-gray-700 mb-4">Stock List</h2>
    <input type="text" id="searchInputStocks" placeholder="Search item..." 
    class="border border-gray-300 p-2 rounded-md w-64 mb-3 focus:ring-2 focus:ring-blue-400">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse shadow-sm rounded-lg" id="stockTable">
            <thead>
                <tr class="bg-gray-100 text-gray-700 border-b">
                    <th class="p-3 w-1/4 font-medium text-center">Stock ID</th>
                    <th class="p-3 w-1/4 font-medium text-center">Date Added</th>
                    <th class="p-3 w-1/4 font-medium text-center">Product Name</th>
                    <th class="p-3 w-1/4 font-medium text-center">Current Stocks</th>
                    <th class="p-3 w-1/4 font-medium text-center">Sold</th>
                    <th class="p-3 w-1/4 font-medium text-center">Backjob</th>
                    <th class="p-3 w-1/4 font-medium text-center">Action</th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                
            </tbody>
        </table>
    </div>
</div>


<!-- Modal -->
<div id="updateStocks_modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center" style="display:none;">
    <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-md relative">
        <h2 class="text-xl font-bold mb-4 text-gray-700">Update Stocks</h2>
        <button id="closeUpdateStocks_modal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">&times;</button>
        
        <form id="frmUpdate_stocks" class="flex flex-col gap-3">
            
            <input hidden type="text" readonly id="update_stock_in_id" name="stock_in_id" 
                class="border border-gray-300 p-3 rounded-md w-full focus:ring-2 focus:ring-blue-400">

            <label for="update_stock_in_qty" class="text-gray-700 font-medium">Quantity</label>
            <input type="number" id="update_stock_in_qty" placeholder="Qty" name="stock_in_qty" 
                class="border border-gray-300 p-3 rounded-md w-full focus:ring-2 focus:ring-blue-400">

            <label for="update_stock_in_sold" class="text-gray-700 font-medium">Sold</label>
            <input type="number" placeholder="Sold" id="update_stock_in_sold" name="stock_in_sold" 
                class="border border-gray-300 p-3 rounded-md w-full focus:ring-2 focus:ring-blue-400">

            <label for="update_stock_in_backjob" class="text-gray-700 font-medium">Backjob</label>
            <input type="number" placeholder="Backjob" id="update_stock_in_backjob" name="stock_in_backjob" 
                class="border border-gray-300 p-3 rounded-md w-full focus:ring-2 focus:ring-blue-400">
            
            <button type="submit" id="BtnUpdateStocks" 
                class="bg-green-500 text-white p-3 rounded-md hover:bg-green-600 transition-all">
                Update Record
            </button>
        </form>
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




<script>
   $(document).ready(function () {

    let selectedProduct = null;

    $('#inventoryTable').on('click', 'tr', function () {
        let productCode = $(this).find('td').eq(1).text().trim(); 

        $('#stock_in_prod_code').val(productCode);
        selectedProduct = { code: productCode };

        console.log(selectedProduct);

        fetchProductSuggestions(productCode);
    });

    function fetchProductSuggestions(query) {
        if (query.length >= 1) { 
            $.ajax({
                url: "backend/end-points/fetch_products.php",
                type: "POST",
                dataType: "json",
                data: { query: query },
                success: function(data) {
                    let suggestions = "";
                    data.forEach(item => {
                        suggestions += `<div class='suggestion-item p-2 hover:bg-gray-200 cursor-pointer' 
                                        data-id='${item.prod_id}' 
                                        data-code='${item.prod_code}' 
                                        data-name='${item.prod_name}'>
                                        ${item.prod_code} - ${item.prod_name}
                                      </div>`;
                    });
                    $("#productSuggestions").html(suggestions).show();
                }
            });
        } else {
            $("#productSuggestions").hide();
        }
    }

    $("#stock_in_prod_code").on("input", function() {
        let query = $(this).val();
        fetchProductSuggestions(query);
    });

    $(document).on("click", ".suggestion-item", function() {
        let selectedCode = $(this).data("code");
        let selectedName = $(this).data("name");
        let selectedId = $(this).data("id");

        $("#stock_in_prod_code").val(selectedCode);
        $("#stock_in_prod_name").val(selectedName);
        $("#stock_in_prod_id").val(selectedId);
        $("#productSuggestions").hide();
    });

   
    $(document).click(function(e) {
        if (!$(e.target).closest("#stock_in_prod_code, #productSuggestions").length) {
            $("#productSuggestions").hide();
        }
    });


// START CODE FOR FETCHING INVENTORY
var currentPageInv = 1;
var limit = 5;

function fetchInventory(page = 1) {
    var searchValue = $('#searchInputInv').val().toLowerCase();

    $.ajax({
        url: 'backend/end-points/inventory_list.php',
        type: 'GET',
        data: { search: searchValue, page: page, limit: limit },
        success: function (data) {
            $('#inventoryTable tbody').html(data);
            currentPageInv = page;
            updatePagination('inventoryPagination', page);
        }
    });
}

fetchInventory();

// Pagination Click Event
$(document).on("click", ".pagination-btnInv", function () {
    let page = $(this).data("page");
    fetchInventory(page);
});

// Live Search
$('#searchInputInv').on('keyup', function () {
    fetchInventory(1); // Reset sa Page 1 kapag may search
});

// Auto-refresh
setInterval(function () {
    fetchInventory(currentPageInv);
}, 5000);

// START CODE FOR FETCHING STOCKS
var currentPageStocks = 1;

function fetchStocks(page = 1) {
    var searchValue = $('#searchInputStocks').val().toLowerCase();

    $.ajax({
        url: 'backend/end-points/stock_list.php',
        type: 'GET',
        data: { search: searchValue, page: page, limit: limit },
        success: function (data) {
            $('#stockTable tbody').html(data);
            currentPageStocks = page;
            updatePagination('stockPagination', page);
        }
    });
}

fetchStocks();

// Pagination Click Event
$(document).on("click", ".pagination-btnStocks", function () {
    let page = $(this).data("page");
    fetchStocks(page);
});

// Live Search
$('#searchInputStocks').on('keyup', function () {
    fetchStocks(1);
});

// Auto-refresh
setInterval(function () {
    fetchStocks(currentPageStocks);
}, 5000);

// Function to update pagination buttons dynamically
function updatePagination(containerId, currentPage) {
    $("#" + containerId + " .pagination-btn").removeClass("active");
    $("#" + containerId + " .pagination-btn[data-page='" + currentPage + "']").addClass("active");
}


    
    $("#product-form").submit(function (e) { 
        e.preventDefault();
        $('#BtnaddInventory').prop('disabled', true);

        var branch_id = $("#branch_id").val();
        var stock_in_prod_id = $("#stock_in_prod_id").val().trim();
        var stock_in_qty = $("#stock_in_qty").val().trim();
        var stock_in_sold = $("#stock_in_sold").val().trim();
        var stock_in_backjob = $("#stock_in_backjob").val().trim();

        if (stock_in_prod_id == "") {
            alertify.error("Please select a product");
            $('#BtnaddInventory').prop('disabled', false);
            return;
        }

        if (stock_in_qty == "" && stock_in_sold == 0 && stock_in_backjob == 0) {
            alertify.error("Please Select Qty, Sold Or Backjob");
            $('#BtnaddInventory').prop('disabled', false);
            return;
        }

        var formData = new FormData(this); 
        formData.append('requestType', 'addInventoryRecord');
        formData.append('branch_id', branch_id);

        $.ajax({
            type: "POST",
            url: "backend/end-points/controller.php",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            beforeSend: function () {
                $("#BtnaddInventory").prop("disabled", true).text("Processing...");
            },
            success: function (response) {
                if (response.status === 200) {
                    alertify.success(response.message);
                    $('#updateStocks_modal').fadeOut();
                    fetchStocks();
                    fetchInventory();
                } else {
                    $('#BtnaddInventory').prop('disabled', false);
                    alertify.error(response.message);
                }
            },
            complete: function () {
                $("#BtnaddInventory").prop("disabled", false).text("Add Record");
            }
        });
    });











    $("#frmUpdate_stocks").submit(function (e) { 
        e.preventDefault();
        $('#BtnUpdateStocks').prop('disabled', true);

        var branch_id = $("#branch_id").val();
        var stock_in_qty = $("#update_stock_in_qty").val().trim();
        var stock_in_sold = $("#update_stock_in_sold").val().trim();
        var stock_in_backjob = $("#update_stock_in_backjob").val().trim();

        if (stock_in_prod_id == "") {
            alertify.error("Please select a product");
            $('#BtnUpdateStocks').prop('disabled', false);
            return;
        }

        if (stock_in_qty == "" && stock_in_sold == 0 && stock_in_backjob == 0) {
            alertify.error("Please Select Qty, Sold Or Backjob");
            $('#BtnUpdateStocks').prop('disabled', false);
            return;
        }

        var formData = new FormData(this); 
        formData.append('requestType', 'updateInventoryRecord');
        formData.append('branch_id', branch_id);

        $.ajax({
            type: "POST",
            url: "backend/end-points/controller.php",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            beforeSend: function () {
                $("#BtnUpdateStocks").prop("disabled", true).text("Processing...");
            },
            success: function (response) {
                if (response.status === 200) {
                    alertify.success(response.message);
                    $("#product-form")[0].reset();  
                    fetchStocks();
                    fetchInventory();
                } else {
                    $('#BtnUpdateStocks').prop('disabled', false);
                    alertify.error(response.message);
                }
            },
            complete: function () {
                $("#BtnUpdateStocks").prop("disabled", false).text("Add Record");
            }
        });
    });


});

</script>

<?php include "components/footer.php"; ?>