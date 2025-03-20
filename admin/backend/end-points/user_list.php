<?php 

$fetch_all_user = $db->fetch_all_user();
$count = 1; // Initialize count

if ($fetch_all_user->num_rows > 0): ?>
    <?php foreach ($fetch_all_user as $user): ?>
        <tr>
            <td class="p-2"><?php echo $count++; ?></td> <!-- Increment count -->
            <td class="p-2"><?php echo htmlspecialchars($user['user_fullname']); ?></td>
            <td class="p-2"><?php echo htmlspecialchars($user['user_email']); ?></td>
            <td class="p-2"><?php echo htmlspecialchars($user['user_username']); ?></td>
            <td class="p-2"><?php echo htmlspecialchars($user['user_type']); ?></td>
           
        <?php  if($On_Session[0]['user_type']=="Administrator"){?>
            <td class="p-2">
                <button class="bg-blue-500 text-white py-1 px-3 rounded-md togglerUpdateUserAdmin" 
                data-id="<?= htmlspecialchars($user['id']) ?>"
                data-user_username="<?= htmlspecialchars($user['user_username']) ?>"
                data-user_fullname="<?= htmlspecialchars($user['user_fullname']) ?>"
                data-user_email="<?= htmlspecialchars($user['user_email']) ?>"
                data-user_type="<?= htmlspecialchars($user['user_type']) ?>"
                >Update</button>

                <button class="bg-red-500 text-white py-1 px-3 rounded-md togglerDeleteUserAdmin" 
                data-id="<?= htmlspecialchars($user['id']) ?>">Remove</button>
            </td>
        <?php }?>

        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="6" class="p-2 text-center">No record found.</td>
    </tr>
<?php endif; ?>
