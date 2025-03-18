<?php
include('../class.php');

$db = new global_class();

$search = isset($_GET['search']) ? $_GET['search'] : "";
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
$offset = ($page - 1) * $limit;

// Fetch branches with search & pagination
$fetch_all_branch = $db->search_all_branch($search, $limit, $offset);
$totalRecords = $db->count_all_branch($search);
$totalPages = ceil($totalRecords / $limit);

// Generate table rows
$output = "";
if ($fetch_all_branch->num_rows > 0) {
    foreach ($fetch_all_branch as $branch) {
        $output .= "<tr class='border-b'>
            <td class='p-2 text-center'><input type='checkbox' class='rowCheckbox' name='rowCheckbox[]'></td>
            <td class='p-2'>" . htmlspecialchars($branch['branch_code']) . "</td>
            <td class='p-2'>" . htmlspecialchars($branch['branch_name']) . "</td>
            <td class='p-2 hidden md:table-cell'>" . htmlspecialchars($branch['branch_address']) . "</td>
            <td class='p-2 hidden md:table-cell'>" . htmlspecialchars($branch['branch_tel']) . "</td>
            <td class='p-2 hidden md:table-cell'>" . htmlspecialchars($branch['branch_started']) . "</td>
            <td class='p-2 hidden md:table-cell'>" . htmlspecialchars($branch['user_fullname']) . "</td>
            <td class='p-2 flex flex-col sm:flex-row gap-2 items-center justify-center'>
                <button class='bg-blue-500 text-white py-1 px-3 rounded-md text-xs sm:text-sm togglerUpdateBranch w-full sm:w-auto'
                    data-branch_id='" . htmlspecialchars($branch['branch_id']) . "'
                    data-branch_code='" . htmlspecialchars($branch['branch_code']) . "'
                    data-branch_name='" . htmlspecialchars($branch['branch_name']) . "'
                    data-branch_address='" . htmlspecialchars($branch['branch_address']) . "'
                    data-branch_started='" . htmlspecialchars($branch['branch_started']) . "'
                    data-branch_manager_id='" . htmlspecialchars($branch['branch_manager_id']) . "'
                    data-user_fullname='" . htmlspecialchars($branch['user_fullname']) . "'
                    data-branch_tel='" . htmlspecialchars($branch['branch_tel']) . "'>
                    Update
                </button>
                <button class='bg-red-500 text-white py-1 px-3 rounded-md text-xs sm:text-sm togglerDeleteBranch w-full sm:w-auto'
                    data-branch_id='" . htmlspecialchars($branch['branch_id']) . "'>
                    Delete
                </button>
            </td>
        </tr>";
    }
} else {
    $output .= "<tr><td colspan='7' class='p-2 text-center'>No record found.</td></tr>";
}

// Return JSON response
echo json_encode(["table" => $output, "totalPages" => $totalPages]);
?>
