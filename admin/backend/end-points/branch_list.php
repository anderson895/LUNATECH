<?php 

$fetch_all_branch = $db->fetch_all_branch();

if ($fetch_all_branch): ?>
    <?php foreach ($fetch_all_branch as $branch):
        ?>
        <tr>
            <td class="p-2"></td>
            <td class="p-2"><?php echo htmlspecialchars($branch['branch_code']); ?></td>
            <td class="p-2"><?php echo htmlspecialchars($branch['branch_name']); ?></td>
            <td class="p-2"><?php echo htmlspecialchars($branch['branch_address']); ?></td>
            <td class="p-2"><?php echo htmlspecialchars($branch['branch_started']); ?></td>
            <td class="p-2"><?php echo htmlspecialchars($branch['user_fullname']); ?></td>
           
            <td class="p-2">
                <button class="bg-blue-500 text-white py-1 px-3 rounded-md togglerUpdateUserAdmin" 
                data-branch_id="<?=$branch['branch_id']?>"
                data-branch_code="<?=$branch['branch_code']?>"
                data-branch_name="<?=$branch['branch_name']?>"
                data-branch_address="<?=$branch['branch_address']?>"
                data-branch_started="<?=$branch['branch_started']?>"
                data-branch_manager_id="<?=$branch['branch_manager_id']?>"
                >Update</button>
                <button class="bg-red-500 text-white py-1 px-3 rounded-md togglerDeleteUserAdmin" data-branch_id=<?=$branch['branch_id']?>>Delete</button>
            </td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="5" class="p-2">No record found.</td>
    </tr>
<?php endif; ?>