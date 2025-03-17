<?php 
$branch_id=$On_Session [0]['branch_id'];
$fetch_all_inventoryRecord = $db->fetch_all_inventoryRecord($branch_id);



if ($fetch_all_inventoryRecord->num_rows>0): ?>
    <?php foreach ($fetch_all_inventoryRecord as $inv):
        ?>
       <tr class="border-b hover:bg-gray-50 transition">
                        <td class="p-4"><?=$inv['prod_name']?></td>
                        <td class="p-4"><?=$inv['total_qty']?></td>
                        <td class="p-4"><?=$inv['total_sold']?></td>
                        <td class="p-4"><?=$inv['total_backjob']?></td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="5" class="p-2">No record found.</td>
    </tr>
<?php endif; ?>





