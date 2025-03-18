<?php 

include('../class.php');

$db = new global_class();

session_start();
$id = intval($_SESSION['id']);
$On_Session = $db->check_account($id);
$branch_id = $On_Session[0]['branch_id'];
$fetch_all_inventoryRecord = $db->fetch_all_inventoryRecord($branch_id);

if ($fetch_all_inventoryRecord->num_rows > 0): ?>
    <?php foreach ($fetch_all_inventoryRecord as $inv): ?>
        <tr class="border-b hover:bg-gray-50 transition">
            <td class='p-2'><img src='../barcodes/<?= htmlspecialchars($inv['prod_code']) ?>.png'></td>
            <td class="p-4"><?= htmlspecialchars($inv['prod_code']) ?></td>
            <td class="p-4"><?= htmlspecialchars($inv['prod_name']) ?></td>
            <td class="p-4"><?= htmlspecialchars($inv['total_qty']) ?></td>
            <td class="p-4"><?= htmlspecialchars($inv['total_sold']) ?></td>
            <td class="p-4"><?= htmlspecialchars($inv['total_backjob']) ?></td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="6" class="p-2">No record found.</td>
    </tr>
<?php endif; ?>
