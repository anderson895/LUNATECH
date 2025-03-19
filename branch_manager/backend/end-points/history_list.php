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

if (empty($On_Session) || !isset($On_Session[0]['branch_id'])) {
    echo json_encode(["error" => "Invalid session data"]);
    exit;
}

$branch_id = intval($On_Session[0]['branch_id']);
$search = isset($_GET['search']) ? trim($_GET['search']) : "";
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$limit = isset($_GET['limit']) ? max(1, intval($_GET['limit'])) : 10;
$offset = ($page - 1) * $limit;

$search_all_history = $db->search_all_history($branch_id, $search, $limit, $offset);
$totalRecords = $db->count_all_history($branch_id, $search);
$totalPages = max(1, ceil($totalRecords / $limit));

$output = "";
$count = $offset + 1;

if ($search_all_history && $search_all_history->num_rows > 0) {
    while ($history = $search_all_history->fetch_assoc()) {
        $formattedDate = date("Y-m-d", strtotime($history['purchase_date']));
        $invoice = htmlspecialchars($history['purchase_invoice']);
        $totalSold = htmlspecialchars($history['purchase_total_payment']);
        $total_profit = htmlspecialchars($history['total_profit']);
        $id = htmlspecialchars($history['purchase_id']);

        

        $output .= "<tr class='border-b hover:bg-gray-100 transition'>
            <td class='p-3 text-center'>" . $count . "</td>
            <td class='p-3 text-center'>" . $formattedDate . "</td>
            <td class='p-3 text-center'>" . $invoice . "</td>
            <td class='p-3 text-center font-semibold text-green-600'>₱ " . number_format($totalSold, 2) . "</td>
            <td class='p-3 text-center font-semibold text-green-600'>₱ " . number_format($total_profit, 2) . "</td>
            <td class='p-3 text-center flex justify-center gap-2'>
                <a href='branch_receipt?invoice=" . urlencode($invoice) . "&&purchase_id=". urlencode($id) . "'> 
                    <button class='bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded flex items-center gap-1 transition'>
                        <span class='material-icons'>receipt_long</span> <span>Receipt</span>
                    </button>
                </a>

                <a href='view_history?invoice=" . urlencode($invoice) . "&&purchase_id=". urlencode($id) . "'> 
                    <button class='bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded flex items-center gap-1 transition'>
                        <span class='material-icons'>visibility</span> <span>View</span>
                    </button>
                </a>
            </td>
        </tr>";

        $count++;
    }
} else {
    $output .= "<tr><td colspan='5' class='p-4 text-center text-gray-500'>No record found.</td></tr>";
}

echo json_encode(["table" => $output, "totalPages" => $totalPages]);
?>
