<?php 
include "components/header.php";

$invoice = $_GET['invoice'];
$purchase_id = $_GET['purchase_id'];
$purchase_record = $db->purchase_record($invoice, $purchase_id);
?>

<!-- Top bar with user profile -->
<div class="max-w-12xl mx-auto flex justify-between items-center bg-white p-4 mb-6 rounded-md shadow-md">
    <h2 class="text-lg font-semibold text-gray-700">History</h2>
    <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-lg font-bold text-white">
        <?php echo substr(ucfirst($On_Session[0]['user_username']), 0, 1); ?>
    </div>
</div>

<!-- Export Button -->
<div class="text-center mb-4">
    <button id="exportExcel" class="px-4 py-2 bg-green-600 text-white font-bold rounded-md shadow-md hover:bg-green-700">
        Export to Excel
    </button>
</div>

<!-- Content to Export -->
<div id="export-content">
    <!-- Header Section -->
    <div class="text-center mb-4">
        <img class="h-12 mx-auto mb-2 rounded-full" src="../assets/images/logo/business_logo.jpeg" alt="Logo" />
        <div class="font-bold">NDG COMPANY</div>
        <div class="text-gray-700"><?= ucfirst($purchase_record[0]['branch_address']) ?></div>
    </div>

    <!-- Invoice Details -->
    <table class="w-full border-collapse border border-gray-400">
        <tr>
            <td class="border border-gray-400 p-2 font-bold">Invoice #:</td>
            <td class="border border-gray-400 p-2"><?= $invoice ?></td>
        </tr>
        <tr>
            <td class="border border-gray-400 p-2 font-bold">Date:</td>
            <td class="border border-gray-400 p-2"><?= $purchase_record[0]['purchase_date'] ?></td>
        </tr>
        <tr>
            <td class="border border-gray-400 p-2 font-bold">Branch Manager:</td>
            <td class="border border-gray-400 p-2"><?= ucfirst($purchase_record[0]['user_fullname']) ?></td>
        </tr>
    </table>

    <br>

    <!-- Items Table -->
    <table id="data-table" class="w-full border-collapse border border-gray-400">
        <thead>
            <tr class="bg-gray-200">
                <th class="border border-gray-400 p-2">Model</th>
                <th class="border border-gray-400 p-2">Price Sold</th>
                <th class="border border-gray-400 p-2">Payment</th>
                <th class="border border-gray-400 p-2">Remarks</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($purchase_record as $item):
                $total_sold = $item['item_price_sold'] * $item['item_qty'];
                $total_capital = $item['item_price_capital'] * $item['item_qty'];
                $total_profit = $total_sold - $total_capital;
            ?>
            <tr>
                <td class="border border-gray-400 p-2"><?= $item['prod_name'] ?> x<?= $item['item_qty'] ?></td>
                <td class="border border-gray-400 p-2">₱<?= number_format($total_sold, 2) ?></td>
                <td class="border border-gray-400 p-2"><?= ucfirst($item['purchase_mode_of_payment']) ?></td>
                <td class="border border-gray-400 p-2"><?= ucfirst($item['purchase_remarks']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Include jQuery & SheetJS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<script>
$(document).ready(function () {
    $("#exportExcel").click(function () {
        let wb = XLSX.utils.book_new();

        // Create data array (Header + Invoice Details + Table)
        let ws_data = [
            ["NDG COMPANY"], // Title
            ["<?= $purchase_record[0]['branch_address'] ?>"],
            [""], // Empty row
            ["Invoice #: ", "<?= $invoice ?>"],
            ["Date: ", "<?= $purchase_record[0]['purchase_date'] ?>"],
            ["Branch Manager: ", "<?= ucfirst($purchase_record[0]['user_fullname']) ?>"],
            [""], // Empty row before table
            ["Product", "Price Sold", "Payment", "Remarks"]
        ];

        // Append table data
        $("#data-table tbody tr").each(function () {
            let row = [];
            $(this).find("td").each(function () {
                row.push($(this).text().trim());
            });
            ws_data.push(row);
        });

        // Create worksheet
        let ws = XLSX.utils.aoa_to_sheet(ws_data);

        // Apply styling
        let range = XLSX.utils.decode_range(ws['!ref']);
        for (let R = range.s.r; R <= range.e.r; ++R) {
            for (let C = range.s.c; C <= range.e.c; ++C) {
                let cell_address = XLSX.utils.encode_cell({ r: R, c: C });
                if (!ws[cell_address]) continue;
                
                if (R === 0) { // Title row
                    ws[cell_address].s = {
                        font: { bold: true, sz: 16 },
                        alignment: { horizontal: "center" }
                    };
                } else if (R === 8) { // Table header
                    ws[cell_address].s = {
                        font: { bold: true, color: { rgb: "FFFFFF" } },
                        fill: { fgColor: { rgb: "4CAF50" } }, // Green background
                        alignment: { horizontal: "center" }
                    };
                } else { // Data rows
                    ws[cell_address].s = {
                        border: {
                            top: { style: "thin" },
                            bottom: { style: "thin" },
                            left: { style: "thin" },
                            right: { style: "thin" }
                        }
                    };
                }
            }
        }

        // Set column widths
        ws["!cols"] = [
            { wch: 20 }, // Product
            { wch: 15 }, // Price Sold
            { wch: 15 }, // Payment
            { wch: 15 }  // Remarks
        ];

        // Append sheet to workbook
        XLSX.utils.book_append_sheet(wb, ws, "Purchase History");

        // Save file
        XLSX.writeFile(wb, "Purchase_History.xlsx");
    });
});
</script>

<?php include "components/footer.php"; ?>
