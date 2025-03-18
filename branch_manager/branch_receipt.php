<?php 
include "components/header.php";

$invoice=$_GET['invoice'];
$purchase_record = $db->purchase_record($invoice);


echo "<pre>";
print_r($purchase_record);
echo "</pre>";
?>

<div class="bg-white rounded-lg shadow-lg px-8 py-10 max-w-xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center">
            <img class="h-32 w-32 rounder-full" src="../assets/images/logo/business_logo.jpeg"
                alt="Logo" />
            <div class="text-gray-700 font-semibold text-lg">NDG Company</div>
        </div>
        <div class="text-gray-700">
            <div class="font-bold text-xl mb-2">INVOICE</div>
            <div class="text-sm">Date: <?=$purchase_record[0]['pruchase_date']?></div>
            <div class="text-sm">Invoice #: <?=$invoice?></div>
        </div>
    </div>
    <div class="border-b-2 border-gray-300 pb-8 mb-8">
        <h2 class="text-2xl font-bold mb-4"></h2>
        <div class="text-gray-700 mb-2"><strong>Branch Manager:</strong> <?=ucfirst($purchase_record[0]['user_fullname'])?></div>
        <div class="text-gray-700 mb-2"><?=ucfirst($purchase_record[0]['branch_name'])?></div>
        <div class="text-gray-700 mb-2"><?=ucfirst($purchase_record[0]['branch_address'])?></div>
        <div class="text-gray-700 mb-2"><?=ucfirst($purchase_record[0]['user_email'])?></div>
    </div>
    <table class="w-full text-left mb-8">
        <thead>
            <tr>
                <th class="text-gray-700 font-bold uppercase py-2">Description</th>
                <th class="text-gray-700 font-bold uppercase py-2">Quantity</th>
                <th class="text-gray-700 font-bold uppercase py-2">Price</th>
                <th class="text-gray-700 font-bold uppercase py-2">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($purchase_record as $item):?>
                <tr>
                    <td class="py-4 text-gray-700"><?=$item['prod_name']?></td>
                    <td class="py-4 text-gray-700"><?=$item['item_qty']?></td>
                    <td class="py-4 text-gray-700"><?=number_format($item['prod_price'],2)?></td>
                    <td class="py-4 text-gray-700"><?=number_format($item['prod_price']*$item['item_qty'])?></td>
                </tr>
            <?php endforeach; ?>
           
          
        </tbody>
    </table>
    <div class="flex justify-end mb-8">
        <div class="text-gray-700 mr-2">Subtotal:</div>
        <div class="text-gray-700">$425.00</div>
    </div>
    <div class="text-right mb-8">
        <div class="text-gray-700 mr-2">Tax:</div>
        <div class="text-gray-700">$25.50</div>

    </div>
    <div class="flex justify-end mb-8">
        <div class="text-gray-700 mr-2">Total:</div>
        <div class="text-gray-700 font-bold text-xl">$450.50</div>
    </div>
    <div class="border-t-2 border-gray-300 pt-8 mb-8">
        <div class="text-gray-700 mb-2">Payment is due within 30 days. Late payments are subject to fees.</div>
        <div class="text-gray-700 mb-2">Please make checks payable to Your Company Name and mail to:</div>
        <div class="text-gray-700">123 Main St., Anytown, USA 12345</div>
    </div>
</div>

<?php include "components/footer.php"; ?>
