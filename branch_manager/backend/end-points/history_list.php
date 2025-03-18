<?php
include('../class.php');

session_start();

if (!isset($_SESSION['id'])) {
    echo json_encode(["error" => "Unauthorized access"]);
    exit;
}

$db = new global_class();
$id = intval($_SESSION['id']);
$On_Session = $db->check_account($id);

// Ensure session data exists
if (empty($On_Session) || !isset($On_Session[0]['branch_id'])) {
    echo json_encode(["error" => "Invalid session data"]);
    exit;
}

$branch_id = intval($On_Session[0]['branch_id']);

$search = isset($_GET['search']) ? trim($_GET['search']) : "";
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$limit = isset($_GET['limit']) ? max(1, intval($_GET['limit'])) : 10;
$offset = ($page - 1) * $limit;

// Fetch data
$search_all_history = $db->search_all_history($branch_id, $search, $limit, $offset);
$totalRecords = $db->count_all_history($branch_id, $search);
$totalPages = max(1, ceil($totalRecords / $limit));

$output = "";
$count = $offset + 1;

if ($search_all_history && $search_all_history->num_rows > 0) {
    while ($history = $search_all_history->fetch_assoc()) {
        // Format Date as "YYYY-MM-DD"
        $formattedDate = date("Y-m-d", strtotime($history['purchase_date']));
        $invoice = htmlspecialchars($history['purchase_invoice']);
        $totalSold = htmlspecialchars($history['purchase_total_payment']);
        $id = htmlspecialchars($history['purchase_id']);

        $output .= "<tr class='border-b'>
            <td class='p-2'>" . $count . "</td>
            <td class='p-2'>" . $formattedDate . "</td>
            <td class='p-2'>" . $invoice . "</td>
            <td class='p-2'>₱ " . number_format($totalSold,2) . "</td>
            <td class='p-2'> 
                <a href='branch_receipt?invoice=" . urlencode($invoice) . "&&purchase_id=". urlencode($id) . "'> 
                    <button class='view-btn bg-blue-500 text-white px-3 py-1 rounded flex items-center'>
                        <span class='material-icons'>visibility</span>
                    </button>
                </a>
            </td>
        </tr>";

        $count++;
    }
} else {
    $output .= "<tr><td colspan='4' class='p-2 text-center'>No record found.</td></tr>";
}

echo json_encode(["table" => $output, "totalPages" => $totalPages]);
?>
