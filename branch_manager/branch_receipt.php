<?php 
include "components/header.php";

$invoice = $_GET['invoice'];
$purchase_id = $_GET['purchase_id'];
$purchase_record = $db->purchase_record($invoice,$purchase_id);

// echo "<pre>";
// print_r($purchase_record);
// echo "</pre>";
?>

<div class="bg-white p-6 max-w-sm mx-auto border border-dashed border-gray-400 text-sm font-mono" id="receipt">
    <!-- Header Section -->
    <div class="text-center mb-4">
        <img class="h-12 mx-auto mb-2" src="../assets/images/logo/business_logo.jpeg" alt="Logo" />
        <div class="font-bold">NDG COMPANY</div>
        <div class="text-gray-700"><?= $purchase_record[0]['branch_address'] ?></div>
        <div class="text-gray-700">Tel: <?=$purchase_record[0]['branch_tel']?></div>
    </div>

    <!-- Invoice Details -->
    <div class="border-t border-dashed border-gray-400 py-2">
        <div class="flex justify-between">
            <span>Invoice #:</span>
            <span><?= $invoice ?></span>
        </div>
        <div class="flex justify-between">
            <span>Date:</span>
            <span><?= $purchase_record[0]['purchase_date'] ?></span>
        </div>
        <div class="flex justify-between">
            <span>Branch Manager:</span>
            <span><?= ucfirst($purchase_record[0]['user_fullname']) ?></span>
        </div>
    </div>

    <!-- Items Table -->
    <div class="border-t border-dashed border-gray-400 mt-2 pt-2">
        <?php foreach ($purchase_record as $item): ?>
            <div class="flex justify-between">
                <span><?= $item['prod_name'] ?> x<?= $item['item_qty'] ?></span>
                <span>₱<?= number_format($item['item_price_sold'] * $item['item_qty'], 2) ?></span>
                <!-- <span>₱<?= number_format($item['item_price_capital'] * $item['item_qty'], 2) ?></span> -->
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Total Amount -->
    <div class="border-t border-dashed border-gray-400 mt-2 pt-2 text-lg font-bold flex justify-between">
        <span>Total:</span>
        <span>₱<?= number_format($purchase_record[0]['purchase_total_payment'], 2) ?></span>
    </div>

    <!-- Payment Details -->
    <div class="border-t border-dashed border-gray-400 mt-2 pt-2 text-md">
        <div class="flex justify-between">
            <span>Mode of Payment:</span>
            <span><?= ucfirst($purchase_record[0]['purchase_mode_of_payment']) ?></span>
        </div>
        <div class="flex justify-between">
            <span>Payment Received :</span>
            <span>₱<?= number_format($purchase_record[0]['purchase_payment'], 2) ?></span>
        </div>
        <div class="flex justify-between font-bold">
            <span>Change:</span>
            <span>₱<?= number_format($purchase_record[0]['purchased_change'], 2) ?></span>
        </div>
    </div>

    <!-- Footer -->
    <div class="text-center text-gray-700 mt-4">
        <div>Thank you for your purchase!</div>
        <!-- <div class="text-xs">No refunds after 7 days.</div> -->
    </div>
</div>


<!-- Print Button -->
<div class="text-center mt-4">
    <button id="printReceipt" class="bg-blue-500 text-white px-4 py-2 rounded">Print Receipt</button>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#printReceipt').click(function() {
            var printContent = document.getElementById('receipt').outerHTML;
            var originalContent = document.body.innerHTML;
            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = originalContent;
        });
    });
</script>

<?php include "components/footer.php"; ?>
