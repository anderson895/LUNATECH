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
                        <th class="p-3 w-1/4 font-medium">Product</th>
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
            <h2 class="text-xl font-bold text-gray-700"> Cart</h2>
        </div>
        <div class="w-full p-4 rounded-lg mb-4">
            <form id="product-form" class="flex flex-col gap-4">
                <input type="hidden" id="sale_prod_code" name="sale_prod_code" placeholder="Search Product Code" class="border border-gray-300 p-3 rounded-md w-full focus:ring-2 focus:ring-blue-400">
                <input type="hidden" id="sale_prod_id" name="sale_prod_id" class="border border-gray-300 p-3 rounded-md w-full focus:ring-2 focus:ring-blue-400">
                <input type="text" id="sale_prod_name" name="sale_prod_name" placeholder="Product Name" class="border border-gray-300 p-3 rounded-md w-full focus:ring-2 focus:ring-blue-400">
                <input type="number" placeholder="Qty" id="sale_qty" name="sale_qty" class="border border-gray-300 p-3 rounded-md w-full focus:ring-2 focus:ring-blue-400">
                
                <button type="submit" id="BtnaddInventory" class="bg-gray-500 text-white p-3 rounded-md hover:bg-gray-600 transition-all mt-4 w-full">
                    <span class="material-icons mr-2">add_shopping_cart</span> Add to Cart
                </button>
            </form>
        </div>

           <!-- Cart Summary (for visual appeal) -->
            <div class="w-full bg-gray-50 p-4 rounded-lg mt-4">
                <h3 class="font-bold text-gray-700 mb-2">Cart Summary</h3>
                <div id="cartItemsList" class="text-sm text-gray-600 mb-2 overflow-x-auto max-h-40 md:max-h-60"> <!-- Allow scrolling for item list -->
                    <!-- Cart item list will go here -->
                </div>
                <div class="overflow-x-auto">
                    <p class="text-sm text-gray-600">Total Items: <span id="cartItemCount">0</span></p>
                    <p class="text-sm text-gray-600">Grand Total: ₱ <span id="cartTotalPrice">0.00</span></p>
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

<script>
$(document).ready(function () {
    let cartItems = [];

    function fetchInventory() {
        let searchValue = $('#searchInput').val().toLowerCase(); 

        $.ajax({
            url: 'backend/end-points/pos_list.php',
            type: 'GET',
            success: function (data) {
                $('#inventoryTable tbody').html(data);

                $("#inventoryTable tbody tr").each(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(searchValue) > -1);
                });
            }
        });
    }

    setInterval(fetchInventory, 3000);
    fetchInventory(); 

    $('#searchInput').on('keyup', function () {
        let value = $(this).val().toLowerCase();
        $("#inventoryTable tbody tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    let selectedProduct = null;

    $('#inventoryTable').on('click', 'tr', function () {
        let productCode = $(this).find('td').eq(0).text().trim(); 
        let productName = $(this).find('td').eq(1).text().trim(); 
        let productPrice = $(this).find('td').eq(3).text().trim(); 
        let productId = $(this).attr('data-prod_id');

        // Populate the form fields
        $('#sale_prod_code').val(productCode);
        $('#sale_prod_name').val(productName); 
        $('#sale_prod_id').val(productId); 

        selectedProduct = {
            id: productId,
            name: productName,
            price: parseFloat(productPrice.replace('₱', '').trim()), 
            quantity: 0 
        };
    });

    $('#BtnaddInventory').on('click', function (e) {
        e.preventDefault();

        let qty = $('#sale_qty').val();
        if (qty > 0 && selectedProduct) {
            selectedProduct.quantity = parseInt(qty);

            let existingItemIndex = cartItems.findIndex(item => item.id === selectedProduct.id);
            if (existingItemIndex >= 0) {
                cartItems[existingItemIndex].quantity += selectedProduct.quantity;
            } else {
                cartItems.push({...selectedProduct}); 
            }

            let totalPrice = 0;
            let cartItemsHtml = '';
            cartItems.forEach(item => {
                let subtotal = item.price * item.quantity;
                totalPrice += subtotal;
                cartItemsHtml += `
                    <p>${item.name} (Code: ${item.id}) - ₱${item.price.toFixed(2)} x ${item.quantity} = ₱${subtotal.toFixed(2)}</p>
                `;
            });

            $('#cartItemsList').html(cartItemsHtml); 
            $('#cartItemCount').text(cartItems.length);
            $('#cartTotalPrice').text(totalPrice.toFixed(2));
        }
    });









    $('#btnPurchase').on('click', function () {
    if (cartItems.length > 0) {
        // Proceed to purchase logic, e.g., send data to backend or process payment
        alert("Purchase successful! Total: ₱" + $('#cartTotalPrice').text());
        // Optionally, clear the cart after purchase
        cartItems = [];
        $('#cartItemsList').html('');
        $('#cartItemCount').text(0);
        $('#cartTotalPrice').text('0.00');
    } else {
        alert("Your cart is empty. Please add items before purchasing.");
    }
});


});
</script>

<?php include "components/footer.php"; ?>
