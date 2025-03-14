<?php 

$fetch_all_user = $db->fetch_all_user();

if ($fetch_all_user): ?>
    <?php foreach ($fetch_all_user as $user):
        ?>
        <tr>
            <td class="p-2"><?php echo htmlspecialchars($user['id']); ?></td>
            <td class="p-2"><?php echo htmlspecialchars($user['user_fullname']); ?></td>
            <td class="p-2"><?php echo htmlspecialchars($user['user_email']); ?></td>
            <td class="p-2"><?php echo htmlspecialchars($user['user_username']); ?></td>
            <td class="p-2"><?php echo htmlspecialchars($user['user_type']); ?></td>
           
            <td class="p-2">
                <button class="bg-blue-500 text-white py-1 px-3 rounded-md togglerUpdateUserAdmin" 
                data-id="<?=$user['id']?>"
                data-user_username="<?=$user['user_username']?>"
                data-user_fullname="<?=$user['user_fullname']?>"
                >Update</button>
                <button class="bg-red-500 text-white py-1 px-3 rounded-md togglerDeleteUserAdmin" data-id=<?=$user['id']?>>Delete</button>
            </td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="5" class="p-2">No record found.</td>
    </tr>
<?php endif; ?>