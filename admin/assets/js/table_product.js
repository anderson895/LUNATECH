$(document).ready(function () {
    let currentPage = 1;
    const recordsPerPage = 10;

    function fetchProducts() {
    let searchQuery = $("#searchInput").val();
    
    // Store checked product IDs before refresh
    let checkedProducts = [];
    $(".rowCheckbox:checked").each(function () {
        checkedProducts.push($(this).closest("tr").find(".togglerDeleteProduct").data("prod_id"));
    });

    $.ajax({
        url: 'backend/end-points/product_list.php',
        type: 'GET',
        data: { search: searchQuery, page: currentPage, limit: recordsPerPage },
        success: function (response) {
            let data = JSON.parse(response);
            $("#userTable tbody").html(data.table);
            updatePagination(data.totalPages);

            // Restore checked states after refresh
            $(".rowCheckbox").each(function () {
                let prodId = $(this).closest("tr").find(".togglerDeleteProduct").data("prod_id");
                if (checkedProducts.includes(prodId)) {
                    $(this).prop("checked", true);
                }
            });

            // Check 'Check All' if all rows are checked
            $("#checkAll").prop("checked", $(".rowCheckbox").length > 0 && $(".rowCheckbox:checked").length === $(".rowCheckbox").length);
        },
        error: function () {
            console.error("Failed to fetch product list.");
        }
    });
}


    // Search Filtering
    $("#searchInput").on("keyup", function () {
        currentPage = 1;
        fetchProducts();
    });

    // Pagination Controls
    function updatePagination(totalPages) {
        let paginationHtml = "";
        for (let i = 1; i <= totalPages; i++) {
            paginationHtml += `<button class="pagination-btn ${i === currentPage ? 'bg-blue-500 text-white' : 'bg-gray-200'} px-3 py-1 rounded-md" data-page="${i}">${i}</button>`;
        }
        $("#pagination").html(paginationHtml);
    }

    $(document).on("click", ".pagination-btn", function () {
        currentPage = $(this).data("page");
        fetchProducts();
    });

    // Check All Checkbox
    $("#checkAll").on("change", function () {
        $(".rowCheckbox").prop("checked", $(this).prop("checked"));
    });

    // Delete Selected Products
    $("#deleteAllBtn").on("click", function () {
        let selectedProducts = [];
        $(".rowCheckbox:checked").each(function () {
            selectedProducts.push($(this).closest("tr").find(".togglerDeleteProduct").data("prod_id"));
        });

        if (selectedProducts.length === 0) {
            alert("Please select at least one product to delete.");
            return;
        }

        if (!confirm("Are you sure you want to delete the selected products?")) return;

        $.ajax({
            url: 'backend/end-points/delete_products.php',
            type: 'POST',
            data: { productIds: selectedProducts },
            success: function (response) {
                let data = JSON.parse(response);
                alert(data.message);
                if (data.success) fetchProducts();
            },
            error: function () {
                console.error("Failed to delete products.");
            }
        });
    });

    // Auto-refresh every 5 seconds
    setInterval(fetchProducts, 5000);
    
    // Initial fetch
    fetchProducts();
});