<?php 

$fetch_all_branch_manager = $db->fetch_all_branch_manager();

if ($fetch_all_branch_manager): ?>
    <?php foreach ($fetch_all_branch_manager as $branch):
        ?>
        <option value="<?=$branch['id']?>"><?=$branch['user_fullname']?></option>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="5" class="p-2">No record found.</td>
    </tr>
<?php endif; ?>