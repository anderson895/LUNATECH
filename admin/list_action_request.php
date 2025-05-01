


<?php include "components/header.php";?>

<!-- Top bar with user profile -->
<div class="flex justify-between items-center bg-white p-4 mb-6 rounded-md shadow-md">
    <h2 class="text-lg font-semibold text-gray-700">List Of Request</h2>
    <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-lg font-bold text-white">
        <?php
        echo substr(ucfirst($On_Session[0]['user_username']), 0, 1);
        ?>
    </div>
</div>






<!-- User Table Card -->
<div class="bg-white rounded-lg shadow-lg p-6 mb-6">

 
    <!-- Table Wrapper for Responsiveness -->
    <div class="overflow-x-auto">
        <table id="requestListTable" class="table-auto w-full text-sm text-left text-gray-500">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="p-3">Date</th>
                    <th class="p-3">Branch Manager</th>
                    <th class="p-3">Branch Name</th>
                    <th class="p-3">Model</th>
                    
                    
                    <th class="p-3 text-center">Action</th>
                </tr>
            </thead>
                
            <tbody>
            <?php 
$fetch_all_request = $db->listRequest();
if (!empty($fetch_all_request)) {
    foreach ($fetch_all_request as $request):
        $stock_in_request_changes = json_decode($request['stock_in_request_changes'], true);

        // Clean key names in case of extra spaces
        $stock_in_request_changes = array_combine(
            array_map('trim', array_keys($stock_in_request_changes)),
            $stock_in_request_changes
        );

        $request_user = $db->check_branch($stock_in_request_changes['user_id'] ?? null); 

        // Loop through all the requests for product check
        foreach ($fetch_all_request as $product) {
            $check_product = $db->check_product($product['stock_in_prod_id'] ?? null);
        }
        ?>
        <tr>
            <td class="p-2">
                <?php echo htmlspecialchars($stock_in_request_changes['date_request'] ?? 'N/A'); ?>
            </td>
            <td class="p-2">
                <?php 
                echo !empty($request_user) ? htmlspecialchars($request_user[0]['user_fullname']) : 'Not found';
                ?>
            </td>
            <td class="p-2">
                <?php 
                echo !empty($request_user) ? htmlspecialchars($request_user[0]['branch_name']) : 'Not found';
                ?>
            </td>
            <td class="p-2">
                <?php 
                echo !empty($check_product) ? htmlspecialchars($check_product[0]['prod_name']) : 'Not found';
                ?>
            </td>
            <td class="p-2 text-center">
                <button 
                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-1 px-3 rounded shadow-md transition duration-200 view-btn" 
                    data-stock_in_id='<?= $stock_in_request_changes['stock_in_id'] ?>'
                    data-stock_in_action_approval='<?= $request['stock_in_action_approval'] ?>'
                    data-request='<?php echo json_encode($request); ?>'>
                    View 
                </button>
            </td>
        </tr>
        <?php 
    endforeach;
} else { ?>
    <tr>
        <td colspan="6" class="p-2 text-center">No Record found.</td>
    </tr>
<?php } ?>






            </tbody>
               
             </table>
         </div>
     </div>






</div>







</div>



<div id="viewModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
    <div class="bg-white p-8 rounded-lg shadow-xl max-w-md w-full space-y-6 transform transition-all duration-300 ease-in-out">
        <h2 class="text-2xl font-semibold text-center text-gray-800">Request Details</h2>
        <hr>
        <div class="space-y-3">
            <p><strong class="text-gray-600">Stock In ID:</strong> <span id="modalStockInId" class="text-gray-800"></span></p>
            <p><strong class="text-gray-600">Approval:</strong> <span id="modalApproval" class="text-gray-800"></span></p>
        </div>
        <div>
            <strong class="text-gray-600">Request Details:</strong>
            <pre id="modalRequest" class="mt-2 text-sm bg-gray-100 p-3 rounded-lg overflow-auto whitespace-pre-wrap text-gray-700"></pre>
        </div>
        <div class="flex space-x-4 mt-6">
            <button type="submit" id="btnApprove" class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 w-full sm:w-auto transition duration-200 ease-in-out">Approve</button>
            <button id="closeModal" class="px-6 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 w-full sm:w-auto transition duration-200 ease-in-out">Close</button>
        </div>
    </div>
</div>



<script>
let selectedStockInId = null;
let selectedApproval = null;
let selectedRequest = null; // Store request globally

$(document).on('click', '.view-btn', function () {
    selectedStockInId = $(this).data('stock_in_id');
    selectedApproval = $(this).data('stock_in_action_approval');
    selectedRequest = $(this).data('request'); // Store globally

    $('#modalStockInId').text(selectedStockInId);
    $('#modalApproval').text(selectedApproval);

    // Format the selectedRequest for proper display with meaningful labels
    let formattedRequest = '';
    for (let key in selectedRequest) {
        if (selectedRequest.hasOwnProperty(key)) {
            // Assign user-friendly labels for each key
            let label = '';
            switch (key) {
                case 'stock_in_id':
                    label = 'Stock In ID';
                    break;
                case 'stock_in_branch_id':
                    label = 'Branch ID';
                    break;
                case 'stock_in_prod_id':
                    label = 'Product ID';
                    break;
                case 'stock_in_qty':
                    label = 'Quantity';
                    break;
                case 'stock_in_sold':
                    label = 'Sold Quantity';
                    break;
                case 'stock_in_backjob':
                    label = 'Backjob Quantity';
                    break;
                case 'stock_in_date':
                    label = 'Stock In Date';
                    break;
                case 'stock_in_action_approval':
                    label = 'Approval Action';
                    break;
                case 'stock_in_request_changes':
                    label = 'Request Changes';
                    break;
                case 'stock_in_status':
                    label = 'Status';
                    break;
                default:
                    label = key.replace(/_/g, ' ').toUpperCase(); // Default format
            }

            // Check if the value is a JSON string (like stock_in_request_changes)
            if (typeof selectedRequest[key] === 'string' && selectedRequest[key].startsWith('{') && selectedRequest[key].endsWith('}')) {
                try {
                    // Try to parse it into an object if it's a valid JSON string
                    let nestedObj = JSON.parse(selectedRequest[key]);
                    formattedRequest += `<strong>${label}:</strong><br>`;
                    for (let nestedKey in nestedObj) {
                        if (nestedObj.hasOwnProperty(nestedKey)) {
                            formattedRequest += `&nbsp;&nbsp;&nbsp;&nbsp;<strong>${nestedKey}:</strong> ${nestedObj[nestedKey]}<br>`;
                        }
                    }
                } catch (e) {
                    // If it's not a valid JSON string, display it as is
                    formattedRequest += `<strong>${label}:</strong> ${selectedRequest[key]}<br>`;
                }
            } else {
                formattedRequest += `<strong>${label}:</strong> ${selectedRequest[key]}<br>`;
            }
        }
    }

    $('#modalRequest').html(formattedRequest); // Use .html() to render HTML
    $('#viewModal').removeClass('hidden').addClass('flex');
});



$('#closeModal').on('click', function () {
    $('#viewModal').addClass('hidden').removeClass('flex');
});

$('#btnApprove').on('click', function () {
    if (!selectedStockInId || !selectedApproval || !selectedRequest) {
        alert('Missing data.');
        return;
    }

    $.ajax({
        url: "backend/end-points/controller.php",
        type: 'POST',
        dataType: 'json', 
        data:{
            requestType: 'StockChangeApproval',
            stock_in_id: selectedStockInId,
            approval_type: selectedApproval,
            request: selectedRequest
        },
        success: function (response) {
            alertify.success('Approved successfully!');
            $('#viewModal').addClass('hidden').removeClass('flex');
            setTimeout(function () { location.reload(); }, 1000);
        },
        error: function () {
            alert('Failed to approve the request.');
        }
    });
});
</script>




<?php include "components/footer.php";?>

