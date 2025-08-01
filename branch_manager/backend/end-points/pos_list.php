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

$fetch_all_inventoryRecord = $db->fetch_all_inventoryRecord_paginated($search,$branch_id, $limit, $offset);
$total_records = $db->count_all_inventoryRecord($branch_id,$search);
$total_pages = ceil($total_records / $limit);


if ($fetch_all_inventoryRecord->num_rows > 0): ?>
    <?php foreach ($fetch_all_inventoryRecord as $inv): ?>
    <tr class="cursor-pointer border-b bg-white hover:bg-gray-50 hover:shadow-md hover:-translate-y-[2px] transition duration-200 ease-in-out" 
        data-prod_id="<?=$inv['prod_id']?>" 
        data-prod_code="<?=$inv['prod_code']?>" 
        data-prod_name="<?=$inv['prod_name']?>" 
        data-prod_current_price="<?=$inv['prod_current_price']?>">
        <td class="p-4"><?=$inv['prod_name']?></td>
        <td class="p-4"><?=$inv['remaining_qty']?></td>
        <td class="p-4"><?=$inv['total_sold']?></td>
        <td class="p-4">₱ <?=htmlspecialchars(number_format($inv['prod_current_price'], 2, '.', ','))?></td>    
    </tr>

    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="5" class="p-2">No record found.</td>
    </tr>
<?php endif; ?>

<!-- Pagination Buttons -->
<tr>
    <td colspan="5" class="p-4 text-center">
        <div class="pagination flex justify-center space-x-2">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <button class="pagination-btn bg-gray-300 text-black px-3 py-1 rounded <?= ($i == $page) ? 'bg-blue-500 text-white' : '' ?>"
                        data-page="<?= $i ?>">
                    <?= $i ?>
                </button>
            <?php endfor; ?>
        </div>
    </td>
</tr>
