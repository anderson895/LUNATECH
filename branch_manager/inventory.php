<?php 
include "components/header.php";
?>

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
             <div id="pagination" class="flex justify-center space-x-2 mt-4"></div>
        </div>
    </div>

    <!-- Add Record Form (Wider) -->
    <div class="md:w-1/4 w-full bg-white shadow-lg rounded-lg p-6 relative">
        <h2 class="text-xl font-bold mb-4 text-gray-700">Add New Record</h2>
        <form id="product-form" class="flex flex-col gap-3">
            <input type="text" id="stock_in_prod_code" name="stock_in_prod_code" placeholder="Search Product" class="border border-gray-300 p-3 rounded-md w-full focus:ring-2 focus:ring-blue-400">
            <div id="productSuggestions" class="absolute bg-white border border-gray-300 rounded-md shadow-md w-full hidden mt-12"></div>
            <input hidden type="text" readonly id="stock_in_prod_id" name="stock_in_prod_id" class="border border-gray-300 p-3 rounded-md w-full focus:ring-2 focus:ring-blue-400">
            <input type="text" readonly id="stock_in_prod_name" name="stock_in_prod_name" placeholder="Product Name" class="border border-gray-300 p-3 rounded-md w-full focus:ring-2 focus:ring-blue-400">
            
            <input type="number" placeholder="Qty" id="stock_in_qty" name="stock_in_qty" class="border border-gray-300 p-3 rounded-md w-full focus:ring-2 focus:ring-blue-400">
            <input type="number" placeholder="Sold" id="stock_in_sold" name="stock_in_sold" class="border border-gray-300 p-3 rounded-md w-full focus:ring-2 focus:ring-blue-400">
            <input type="number" placeholder="Backjob" id="stock_in_backjob" name="stock_in_backjob" class="border border-gray-300 p-3 rounded-md w-full focus:ring-2 focus:ring-blue-400">
            <button type="submit" id="BtnaddInventory" class="bg-green-500 text-white p-3 rounded-md hover:bg-green-600 transition-all">Add Record</button>
        </form>
    </div>

</div>


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

    
        let currentPage = 1;
        let limit = 5;  

        function fetchInventory(page = 1) {
            let searchValue = $('#searchInput').val().toLowerCase();

            $.ajax({
                url: 'backend/end-points/inventory_list.php',
                type: 'GET',
                data: { search: searchValue, page: page, limit: limit },
                success: function (data) {
                    $('#inventoryTable tbody').html(data);

                    // Filter after AJAX update
                    $("#inventoryTable tbody tr").each(function () {
                        $(this).toggle($(this).text().toLowerCase().indexOf(searchValue) > -1);
                    });

                    // Update current page
                    currentPage = page;
                }
            });
        }

        // Load first page on startup
        fetchInventory();

        // Pagination Click Event
        $(document).on("click", ".pagination-btn", function () {
            let page = $(this).data("page");
            fetchInventory(page);
        });

        // Live search function
        $('#searchInput').on('keyup', function () {
            let value = $(this).val().toLowerCase();
            $("#inventoryTable tbody tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });

            fetchInventory();
        });

        // Auto-refresh inventory every 5 seconds
        setInterval(function () {
            fetchInventory(currentPage);
        }, 5000);
  




    
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
                    $("#product-form")[0].reset();  
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

});

</script>

<?php include "components/footer.php"; ?>