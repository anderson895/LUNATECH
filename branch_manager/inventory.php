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
                    <?php include "backend/end-points/inventory_list.php";?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Record Form (Wider) -->
    <div class="md:w-1/4 w-full bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-xl font-bold mb-4 text-gray-700">Add New Record</h2>
        <form id="product-form" class="flex flex-col gap-3">
            <select id="stock_in_prod_code" name="stock_in_prod_code" class="border border-gray-300 p-3 rounded-md w-full focus:ring-2 focus:ring-blue-400">
                <option value="">Search Product Code</option>
            </select>



            <input hidden type="text" readonly id="stock_in_prod_id" name="stock_in_prod_id"  class="border border-gray-300 p-3 rounded-md w-full focus:ring-2 focus:ring-blue-400">
            <input type="text" readonly id="stock_in_prod_name" name="stock_in_prod_name" placeholder="Product Name" class="border border-gray-300 p-3 rounded-md w-full focus:ring-2 focus:ring-blue-400">
            
            <input type="number" placeholder="Qty" name="stock_in_qty"  class="border border-gray-300 p-3 rounded-md w-full focus:ring-2 focus:ring-blue-400">
            <input type="number" placeholder="Sold" name="stock_in_sold" class="border border-gray-300 p-3 rounded-md w-full focus:ring-2 focus:ring-blue-400">
            <input type="number" placeholder="Backjob" name="stock_in_backjob" class="border border-gray-300 p-3 rounded-md w-full focus:ring-2 focus:ring-blue-400">
            <button type="submit" id="BtnaddInventory" class="bg-blue-500 text-white p-3 rounded-md hover:bg-blue-600 transition-all">Add Record</button>
        </form>

    </div>

</div>


<script>
    $(document).ready(function() {
        $("#stock_in_prod_code").select2({
        placeholder: "Search Product Code",
        allowClear: true,
        ajax: {
            url: "backend/end-points/fetch_products.php",
            type: "POST",
            dataType: "json",
            delay: 250,
            data: function (params) {
                return { query: params.term };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            id: item.prod_id, 
                            prod_code: item.prod_code,
                            text: item.prod_code + " - " + item.prod_name 
                        };
                    })
                };
            }
        }
    });

    // When a product is selected
    $("#stock_in_prod_code").on("select2:select", function(e) {
        let selectedData = e.params.data;
        

        $("#stock_in_prod_code").val(selectedData.prod_code);  // Product Code
        $("#stock_in_prod_name").val(selectedData.text.split(" - ")[1]);  // Extract Product Name
        $("#stock_in_prod_id").val(selectedData.id);  // Extract prod_id
    });

    // Form submission with AJAX
    $("#product-form").submit(function (e) { 
        e.preventDefault();
        $('#BtnaddInventory').prop('disabled', true);
        var stock_in_prod_code = $("#stock_in_prod_code").val();
        var branch_id = $("#branch_id").val();
        console.log(stock_in_prod_code);

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
                console.log(response); // Debugging

                if (response.status === 200) {
                    alertify.success(response.message);
                    setTimeout(function () { location.reload(); }, 1000);
                    
                    // Reset form after success
                    $("#product-form")[0].reset();  
                    $("#stock_in_prod_code").val(null).trigger("change"); // Reset Select2
                } else {
                    $('#BtnaddInventory').prop('disabled', false);
                    alertify.error(response.message);
                }
            },
            complete: function () {
                $("#BtnaddInventory").prop("disabled", false).text("Submit");
            }
        });
    });
});

</script>




<?php include "components/footer.php"; ?>
