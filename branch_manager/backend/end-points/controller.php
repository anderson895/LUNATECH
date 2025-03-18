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
        }else if ($_POST['requestType'] == 'AddToCart') {
            $branch_id = htmlspecialchars(trim($_POST['branch_id']));
            $qty = htmlspecialchars(trim($_POST['sale_qty']));
            $prod_id = htmlspecialchars(trim($_POST['sale_prod_id']));
            
            $result = $db->AddToCart($branch_id,$qty, $prod_id);
            
            if ($result == "success") {
                echo json_encode(["status" => 200, "message" => "Cart record successfully added"]);
            } else {
                echo json_encode(["status" => 400, "message" => $result]);
            }
        }else if($_POST['requestType'] == 'RemoveCartItem'){
            echo "<pre>";
            print_r($_POST);
            echo "</pre>";
            $cart_id = htmlspecialchars(trim($_POST['cart_id']));
            
            $result = $db->RemoveCartItem( $cart_id);
            
            if ($result == "success") {
                echo json_encode(["status" => 200, "message" => "Cart record successfully removed"]);
            } else {
                echo json_encode(["status" => 400, "message" => $result]);
            }
        }
    }
}
?>