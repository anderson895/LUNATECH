<?php
include('../class.php');

$db = new global_class();

// echo "<pre>";
// print_r($_POST);
// echo "</pre>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['requestType'])) {
        if ($_POST['requestType'] == 'addInventoryRecord') {
            $branch_id = htmlspecialchars(trim($_POST['branch_id']));
            $stock_in_prod_id = htmlspecialchars(trim($_POST['stock_in_prod_id']));
            $stock_in_qty = htmlspecialchars(trim($_POST['stock_in_qty']));
            $stock_in_sold = htmlspecialchars(trim($_POST['stock_in_sold']));
            $stock_in_backjob = htmlspecialchars(trim($_POST['stock_in_backjob']));
            
           
            
            $result = $db->addInventoryRecord($branch_id,$stock_in_prod_id, $stock_in_qty, $stock_in_sold, $stock_in_backjob);
            
            if ($result == "success") {
                echo json_encode(["status" => 200, "message" => "Inventory record successfully added"]);
            } else {
                echo json_encode(["status" => 400, "message" => $result]);
            }
        }
    }
}
?>