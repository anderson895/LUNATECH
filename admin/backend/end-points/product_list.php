<?php
include('../class.php');

$db = new global_class();

$search = isset($_GET['search']) ? $_GET['search'] : "";
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
$offset = ($page - 1) * $limit;

// Fetch products with search & pagination
$fetch_all_product = $db->search_all_product($search, $limit, $offset);
$totalRecords = $db->count_all_product($search);
$totalPages = ceil($totalRecords / $limit);

// Generate table rows
$output = "";
if ($fetch_all_product->num_rows > 0) {
    foreach ($fetch_all_product as $product) {
        $output .= "<tr class='border-b'>
        <td class='p-2 text-center'><input type='checkbox' class='rowCheckbox' name='rowCheckbox[]'></td>
        
        <td class='p-2'>" . htmlspecialchars($product['prod_name']) . "</td>
        <td class='p-2'>₱ " . htmlspecialchars(number_format($product['prod_capital'], 2, '.', ',')) . "</td>
        <td class='p-2'>₱ " . htmlspecialchars(number_format($product['prod_current_price'], 2, '.', ',')) . "</td>
        <td class='p-2'>" . htmlspecialchars(ucfirst($product['user_fullname'])) . "</td>
        <td class='p-2'>" . htmlspecialchars(date("F d, Y h:i A", strtotime($product['prod_date_added']))) . "</td>
        <td class='p-2 flex flex-col sm:flex-row gap-2 items-center justify-center'>
            <button class='bg-blue-500 text-white py-1 px-3 rounded-md text-xs sm:text-sm togglerUpdateProduct w-full sm:w-auto'
                data-prod_id='" . htmlspecialchars($product['prod_id']) . "'
                data-prod_name='" . htmlspecialchars($product['prod_name']) . "'
                data-prod_capital='" . htmlspecialchars($product['prod_capital']) . "'
                data-prod_current_price='" . htmlspecialchars($product['prod_current_price']) . "'
                
                >
                Update
            </button>
            <button class='bg-red-500 text-white py-1 px-3 rounded-md text-xs sm:text-sm togglerDeleteProduct w-full sm:w-auto'
                data-prod_id='" . htmlspecialchars($product['prod_id']) . "'>
                Delete
            </button>
        </td>
    </tr>";

    }
} else {
    $output .= "<tr><td colspan='6' class='p-2 text-center'>No record found.</td></tr>";
}

// Return JSON response
echo json_encode([
    "table" => $output, 
    "totalPages" => $totalPages, 
    "totalProducts" => $totalRecords // Include total product count
]);
?>
