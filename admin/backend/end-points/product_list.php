<?php 

$fetch_all_product = $db->fetch_all_product();



if ($fetch_all_product->num_rows>0): ?>
    <?php foreach ($fetch_all_product as $product):
        ?>
        <tr>
           
            <td class="p-2"><?php echo htmlspecialchars($product['prod_code']); ?></td>
            <td class="p-2"><?php echo htmlspecialchars($product['prod_name']); ?></td>
            <td class="p-2"><?php echo htmlspecialchars(ucfirst($product['user_fullname'])); ?></td>
            <td class="p-2">
                <?php 
                    echo htmlspecialchars(date("F d, Y h:i A", strtotime($product['prod_date_added']))); 
                ?>
            </td>


           
            <td class="p-2">
                <button class="bg-blue-500 text-white py-1 px-3 rounded-md togglerUpdateProduct" 
                data-prod_id="<?=$product['prod_id']?>"
                data-prod_name="<?=$product['prod_name']?>"
                >Update</button>
                <button class="bg-red-500 text-white py-1 px-3 rounded-md togglerDeleteProduct" data-prod_id=<?=$product['prod_id']?>>Delete</button>
            </td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="5" class="p-2">No record found.</td>
    </tr>
<?php endif; ?>





