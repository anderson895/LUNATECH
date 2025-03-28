<?php 
include('../class.php');

$db = new global_class();

session_start();
$id = intval($_SESSION['id']);
$On_Session = $db->check_account($id);
$branch_id = $On_Session[0]['branch_id'];


$search = isset($_GET['search']) ? $_GET['search'] : "";
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;  
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;  
$offset = ($page - 1) * $limit;  

$fetch_all_inventoryRecord = $db->fetch_all_stockRecord_paginated($search,$branch_id, $limit, $offset);
?>



<?php if ($fetch_all_inventoryRecord->num_rows > 0): ?>
            <?php foreach ($fetch_all_inventoryRecord as $inv): ?>
                <?php $formattedDate = date("d/m/Y", strtotime($inv['stock_in_date'])); ?>
                <tr class="border-b hover:bg-gray-100 transition" data-stock-date="<?= htmlspecialchars($formattedDate) ?>">
                    <td class="p-3 text-center"><?= htmlspecialchars($formattedDate) ?></td>
                    <td class="p-3 text-center"><?= htmlspecialchars($inv['prod_name']) ?></td>
                    <td class="p-3 text-center"><?= htmlspecialchars($inv['stock_in_qty']) ?></td>
                    <td class="p-3 text-center"><?= htmlspecialchars($inv['stock_in_sold']) ?></td>
                    <td class="p-3 text-center"><?= htmlspecialchars($inv['stock_in_backjob']) ?></td>
                    <td class="p-3 flex justify-center space-x-2">
                        <button class="update-stock-inv bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition"
                                data-stock_in_id="<?= htmlspecialchars($inv['stock_in_id']) ?>"
                                data-stock_in_qty="<?= htmlspecialchars($inv['stock_in_qty']) ?>"
                                data-stock_in_sold="<?= htmlspecialchars($inv['stock_in_sold']) ?>"
                                data-stock_in_backjob="<?= htmlspecialchars($inv['stock_in_backjob']) ?>">
                            Update
                        </button>
                        <button class="remove-stock-inv bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded transition"
                                data-id="<?= htmlspecialchars($inv['stock_in_id']) ?>"
                                data-table="stock"
                                data-id_name="stock_in_id">
                            Remove
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7" class="p-3 text-center text-gray-500">No record found.</td>
            </tr>
        <?php endif; ?>


<tr>
    <td colspan="7" class="p-4 text-center">
        <div class="flex flex-wrap gap-2 p-4 bg-white shadow-md rounded-lg">
            <?php if (!empty($fetch_all_inventoryRecord)): ?>
                <?php 
                    $uniqueDates = [];
                    foreach ($fetch_all_inventoryRecord as $inv) {
                        $formattedDate = date("d/m/Y", strtotime($inv['stock_in_date']));
                        $uniqueDates[$formattedDate] = true; // Store unique dates
                    }
                ?>
                <button class="filter-btn px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg transition" data-date="all">
                    Show All
                </button>
                <?php foreach (array_keys($uniqueDates) as $date): ?>
                    <button class="filter-btn px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg transition"
                            data-date="<?= htmlspecialchars($date) ?>">
                        <?= htmlspecialchars($date) ?>
                    </button>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-gray-500">No record found.</p>
            <?php endif; ?>
        </div>
    </td>
</tr>







<script>



    $(document).ready(function() {
        $('.update-stock-inv').click(function (e) { 
    e.preventDefault();
    
    let stock_in_id = $(this).data('stock_in_id');
    let stock_in_qty = $(this).data('stock_in_qty');
    let stock_in_sold = $(this).data('stock_in_sold');
    let stock_in_backjob= $(this).data('stock_in_backjob');


    console.log(stock_in_sold);

    $("#update_stock_in_id").val(stock_in_id);
    $("#update_stock_in_qty").val(stock_in_qty);
    $("#update_stock_in_sold").val(stock_in_sold);
    $("#update_stock_in_backjob").val(stock_in_backjob);
    $('#updateStocks_modal').fadeIn();
  });  

  $('#closeUpdateStocks_modal').click(function (e) { 
    e.preventDefault();
    $('#updateStocks_modal').fadeOut();
  });  

   // Close Modal when clicking outside the modal content
   $("#updateStocks_modal").click(function(event) {
        if ($(event.target).is("#updateStocks_modal")) {
            $("#updateStocks_modal").fadeOut();
        }
    });
    });
</script>
