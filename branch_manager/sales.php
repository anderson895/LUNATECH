<?php 
include "components/header.php";
?>

<!-- Top bar with user profile -->
<div class="max-w-12xl mx-auto flex justify-between items-center bg-white p-4 mb-6 rounded-md shadow-md">
    <h2 class="text-lg font-semibold text-gray-700">Sales</h2>
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
            <h2 class="text-xl font-bold text-gray-700">Point Of Sale</h2>
            <!-- Search Bar with Icon -->
            <div class="flex items-center border border-gray-300 p-2 rounded-md w-64 focus:ring-2 focus:ring-blue-400">
                <span class="material-icons mr-2">search</span>
                <input type="text" id="searchInput" placeholder="Search item..." class="w-full focus:outline-none">
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse shadow-sm rounded-lg" id="inventoryTable">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 border-b">
                        <th class="p-3 w-1/4 font-medium">Code</th>
                        <th class="p-3 w-1/4 font-medium">Model</th>
                        <th class="p-3 w-1/4 font-medium">Current Stocks</th>
                        <th class="p-3 w-1/4 font-medium">Price</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600">
                    <!-- Dynamic inventory rows will be inserted here -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Record Form (Card Style) -->
    <div class="md:w-1/4 w-full bg-white shadow-lg rounded-lg p-6 relative flex flex-col items-center">
        <div class="w-full flex justify-between items-center mb-4">
            <!-- <h2 class="text-xl font-bold text-gray-700"> ....</h2> -->
        </div>
        <div class="w-full rounded-lg mb-4">
        <form id="addCartFrm" class="flex flex-col gap-6">
    <!-- Product Code -->
    <div class="relative" hidden>
        <input type="text" id="sale_prod_code" name="sale_prod_code" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent border border-gray-300 rounded-lg appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
        <label for="sale_prod_code" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 left-2 z-10 bg-white px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 peer-focus:text-blue-600">
            Product Code
        </label>
    </div>

    <!-- Product ID -->
    <div class="relative" hidden>
        <input type="text" id="sale_prod_id" name="sale_prod_id" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent border border-gray-300 rounded-lg appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
        <label for="sale_prod_id" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 left-2 z-10 bg-white px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 peer-focus:text-blue-600">
            Product ID
        </label>
    </div>

    <!-- Model -->
    <div class="relative">
        <input type="text" readonly id="sale_prod_name" name="sale_prod_name" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent border border-gray-300 rounded-lg appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
        <label for="sale_prod_name" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 left-2 z-10 bg-white px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 peer-focus:text-blue-600">
            Model
        </label>
    </div>

    <!-- Quantity -->
    <div class="relative">
        <input type="number" id="sale_qty" name="sale_qty" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent border border-gray-300 rounded-lg appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
        <label for="sale_qty" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 left-2 z-10 bg-white px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 peer-focus:text-blue-600">
            Qty
        </label>
    </div>

    <!-- Price -->
    <div class="relative">
        <input type="text" id="sale_price" name="sale_price" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent border border-gray-300 rounded-lg appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
        <label for="sale_price" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 left-2 z-10 bg-white px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 peer-focus:text-blue-600">
            Price
        </label>
    </div>

    <!-- Submit Button -->
    <button type="submit" id="BtnaddInventory" class="bg-gray-500 text-white p-3 rounded-md hover:bg-gray-600 transition-all mt-4 w-full flex items-center justify-center gap-2">
        <span class="material-icons">add_shopping_cart</span> Add to Cart
    </button>
</form>

        </div>

           <!-- Cart Summary (for visual appeal) -->
            <div class="w-full bg-gray-50 p-4 rounded-lg mt-4">
                <h3 class="font-bold text-gray-700 mb-2">Cart Summary</h3>
                <div id="cartItemsList" class="text-sm text-gray-600 mb-2 overflow-x-auto max-h-40 md:max-h-60"> 
                    <!-- Cart item list will go here -->
                </div>
                <div class="overflow-x-auto">
                    <b class="text-sm text-gray-600">Total: <span id="cartTotalPrice"> 0.00</span></b>
                </div>

                <!-- Purchase Button -->
                <div class="w-full mt-4">
                    <button id="btnPurchase" class="bg-green-500 text-white p-3 rounded-md hover:bg-green-600 transition-all w-full">
                        <span class="material-icons mr-2">shopping_cart</span> Purchase
                    </button>
                </div>
            </div>
    </div>
</div>








<!-- MODAL SECION -->
<div id="purchaseModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg p-6 shadow-lg w-96">
        <h2 class="text-xl font-bold text-gray-700 mb-4">Payment Details</h2>

        <div class="mb-3">
            <label class="block text-gray-600 text-sm font-medium">Total Bill:</label>
            <input type="text" id="totalBill" class="border border-gray-300 p-2 w-full rounded-md bg-gray-100" readonly>
        </div>

        <div class="mb-3">
            <label class="block text-gray-600 text-sm font-medium">Mode of Payment:</label>
            <select id="paymentMethod" name="paymentMethod" class="border border-gray-300 p-2 w-full rounded-md">
                <option value="cash">Cash</option>
                <option value="credit_card">Credit Card</option>
                <option value="gcash">GCash</option>
                <option value="bank_transfer">Bank Transfer</option>
            </select>
        </div>
        

        <div class="mb-3">
            <label class="block text-gray-600 text-sm font-medium">Payment:</label>
            <input type="number" id="paymentAmount" class="border border-gray-300 p-2 w-full rounded-md">
        </div>

        <div class="mb-3">
            <label class="block text-gray-600 text-sm font-medium">Change (Sukli):</label>
            <input type="text" id="changeAmount" class="border border-gray-300 p-2 w-full rounded-md bg-gray-100" readonly>
        </div>

        <div class="flex justify-end space-x-2">
            <button id="confirmPurchase" class="bg-green-500 text-white p-2 rounded-md">Confirm</button>
            <button id="closeModal" class="bg-gray-500 text-white p-2 rounded-md">Cancel</button>
        </div>
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
    let cartItems = [];

  
        let currentPage = 1;
        let limit = 5;  

        function fetchInventory(page = 1) {
            let searchValue = $('#searchInput').val().toLowerCase();

            $.ajax({
                url: 'backend/end-points/pos_list.php',
                type: 'GET',
                data: { search: searchValue, page: page, limit: limit },
                success: function (data) {
                    $('#inventoryTable tbody').html(data);
                    $("#inventoryTable tbody tr").each(function () {
                        $(this).toggle($(this).text().toLowerCase().indexOf(searchValue) > -1);
                    });
                    currentPage = page;
                }
            });
        }

        fetchInventory();

        $(document).on("click", ".pagination-btn", function () {
            let page = $(this).data("page");
            fetchInventory(page);
        });
        $('#searchInput').on('keyup', function () {
            let value = $(this).val().toLowerCase();
            $("#inventoryTable tbody tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
            fetchInventory();
        });

        setInterval(function () {
            fetchInventory(currentPage);
        }, 5000);
 

        let selectedProduct = null;

    $('#inventoryTable').on('click', 'tr', function (event) {
        event.stopPropagation(); // Prevent the click from propagating to document

        let productCode = $(this).data('prod_code'); 
        let productName = $(this).data('prod_name'); 
        let productPrice =$(this).data('prod_current_price'); 
        let productId = $(this).attr('data-prod_id');

      
        $('#sale_prod_code').val(productCode);
        $('#sale_prod_name').val(productName); 
        $('#sale_prod_id').val(productId);
        $('#sale_qty').val(1);
        $('#sale_price').val(productPrice); // Use the cleaned number


        console.log(productPrice);

        selectedProduct = {
            id: productId,
            code: productCode,
            name: productName,
            price: productPrice, // Already a number
            quantity: 0 
        };
    });

  


    
    $('#addCartFrm').on('submit', function (e) {
        e.preventDefault();
        
        var prod_id = $("#sale_prod_id").val().trim();
        var sale_qty = $("#sale_qty").val().trim();


        console.log(sale_qty);

        if (prod_id === "") {
            alertify.error("Please select a product first.");
            return;
        }

        if (sale_qty === "" || isNaN(sale_qty) || sale_qty < 1) {
            alertify.error("Please enter a valid quantity.");
            return;
        }

        var branch_id = $("#branch_id").val();
        var formData = new FormData(this);
        formData.append('requestType', 'AddToCart'); 
        formData.append('branch_id', branch_id); 
        $.ajax({
                type: "POST",
                url: "backend/end-points/controller.php",
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json", 
                success: function (response) {
                    console.log(response);
                    if (response.status === 400) {
                        alertify.error(response.message);
                    } 
                    fetch_cart();
                    fetchInventory();
                },
            });
    });

    

    function fetch_cart() {
    $.ajax({
        url: 'backend/end-points/fetch_cart.php',
        type: 'GET',
        success: function (data) {
            let cartItems = JSON.parse(data); 
            let cartItemsHtml = "";
            let totalItems = 0;
            let totalPrice = 0;
            

           

            cartItems.forEach(item => {
                let subtotal = item.cart_sale_price * item.cart_qty;
                totalItems += item.cart_qty;
                totalPrice += subtotal;


                console.log(item);

                cartItemsHtml += `
                    <div class="cart-item flex justify-between items-center border-b py-2" data-prod_capital="${item.prod_capital}" data-cart_sale_price="${item.cart_sale_price}" data-cart_id="${item.cart_id}" data-cart_prod_id="${item.cart_prod_id}">
                        <p>${item.prod_name} - ₱${parseFloat(item.cart_sale_price).toFixed(2)} x ${item.cart_qty} = <strong>₱${subtotal.toFixed(2)}</strong></p>
                        <button class="removeItem text-red-500 hover:text-red-700" data-cart_id="${item.cart_id}" data-cart_prod_id="${item.cart_prod_id}">X</button>
                    </div>
                `;
            });

            $("#cartItemsList").html(cartItemsHtml);
            $("#cartItemCount").text(totalItems);
            $("#cartTotalPrice").text(totalPrice.toLocaleString('en-PH', { style: 'currency', currency: 'PHP' }));

        },
        error: function (xhr, status, error) {
            console.error("Error fetching cart:", error);
        }
    });
}

$(document).on('click', '.removeItem', function () {
    let cart_id = $(this).data('cart_id');
    let cart_prod_id = $(this).data('cart_prod_id');
    let branch_id = $("#branch_id").val();
    $.ajax({
        url: "backend/end-points/controller.php",
        type: 'POST',
        data: { cart_id:cart_id,cart_prod_id: cart_prod_id,branch_id: branch_id, requestType: 'RemoveCartItem' },
        success: function (response) {
            console.log(response);
            fetch_cart(); 
            fetchInventory();
        },
        error: function (xhr, status, error) {
            console.error("Error removing item:", error);
        }
    });
});

$(document).ready(function () {
    setInterval(fetch_cart, 3000);
    fetch_cart();
});

});



$(document).ready(function () {
    $("#btnPurchase").click(function () {
        let totalBill = parseFloat($("#cartTotalPrice").text().replace(/[^\d.]/g, '')) || 0;

        if (totalBill === 0) {
            alertify.error("Your cart is empty!");
            return;
        }

        $("#totalBill").val(`₱${totalBill.toLocaleString('en-PH', { minimumFractionDigits: 2 })}`);
        $("#paymentAmount").val('');
        $("#changeAmount").val('');
        $("#purchaseModal").removeClass("hidden");
    });

    $("#closeModal").click(function () {
        $("#purchaseModal").addClass("hidden");
    });

    $("#paymentAmount").on("input", function () {
        let totalBill = parseFloat($("#totalBill").val().replace(/[^\d.]/g, '')) || 0;
        let payment = parseFloat($(this).val()) || 0;
        
        let change = payment - totalBill;

        $("#changeAmount").val(
            change >= 0 
                ? `₱${change.toLocaleString('en-PH', { minimumFractionDigits: 2 })}` 
                : "Insufficient Payment"
        );
    });

    $("#confirmPurchase").click(function () {
        let totalBill = parseFloat($("#totalBill").val().replace(/[^\d.]/g, ''));
        let branch_id = $("#branch_id").val();
        let payment = parseFloat($("#paymentAmount").val());
        let changeAmount = parseFloat($("#changeAmount").val().replace(/[^\d.]/g, ''));
        let paymentMethod = $("#paymentMethod").val();
      
        if (isNaN(payment) || payment < totalBill) {
            alert("Insufficient payment!");
            return;
        }

        // Collect cart items
        let cartItems = [];
        $("#cartItemsList .cart-item").each(function () {
            let item = {
                cart_id: $(this).data("cart_id"),
                cart_prod_id: $(this).data("cart_prod_id"),
                cart_sale_price: $(this).data("cart_sale_price"),
                prod_capital: $(this).data("prod_capital"),
                quantity: parseInt($(this).find("p").text().split(" x ")[1]),
            };
            cartItems.push(item);
        });

        if (cartItems.length === 0) {
            alert("No items in cart.");
            return;
        }

        // Send data to the backend
        $.ajax({
            url: "backend/end-points/controller.php",
            type: "POST",
            data: {
                requestType: "CompletePurchase",
                total: totalBill,
                payment: payment,
                branch_id: branch_id,
                changeAmount: changeAmount,
                paymentMethod: paymentMethod,
                cartItems: cartItems
            },
            dataType: "json", 
            success: function (response) {
                console.log(response);
                alertify.success("Purchase successful!");
                $("#purchaseModal").addClass("hidden");
                setTimeout(function () {
                    window.location.href = "branch_receipt?invoice=" + response.invoice+"&&purchase_id="+response.purchase_id;
                }, 1500);
            },
            error: function (xhr, status, error) {
                console.error("Error processing purchase:", error);
            }
        });
    });
});

</script>


<?php include "components/footer.php"; ?>
