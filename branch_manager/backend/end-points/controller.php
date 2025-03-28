<?php
include('../class.php');

$db = new global_class();



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
        }else if ($_POST['requestType'] == 'updateInventoryRecord') {
            $stock_in_id = htmlspecialchars(trim($_POST['stock_in_id']));
            $branch_id = htmlspecialchars(trim($_POST['branch_id']));
            $stock_in_qty = htmlspecialchars(trim($_POST['stock_in_qty']));
            $stock_in_sold = htmlspecialchars(trim($_POST['stock_in_sold']));
            $stock_in_backjob = htmlspecialchars(trim($_POST['stock_in_backjob']));
            
            $result = $db->updateInventoryRecord($stock_in_id,$branch_id, $stock_in_qty, $stock_in_sold, $stock_in_backjob);
            
            if ($result == "success") {
                echo json_encode(["status" => 200, "message" => "Stocks Update successfully added"]);
            } else {
                echo json_encode(["status" => 400, "message" => $result]);
            }
        }else if ($_POST['requestType'] == 'AddToCart') {


            $branch_id = htmlspecialchars(trim($_POST['branch_id']));
            $qty = htmlspecialchars(trim($_POST['sale_qty']));
            $sale_price = htmlspecialchars(trim($_POST['sale_price']));
            $prod_id = htmlspecialchars(trim($_POST['sale_prod_id']));
            
            $result = $db->AddToCart($branch_id,$qty,$sale_price, $prod_id);
            
            if ($result == "success") {
                echo json_encode(["status" => 200, "message" => "Cart record successfully added"]);
            } else {
                echo json_encode(["status" => 400, "message" => $result]);
            }
        }else if($_POST['requestType'] == 'RemoveCartItem'){
            
            $cart_id = htmlspecialchars(trim($_POST['cart_id']));
            $cart_prod_id = htmlspecialchars(trim($_POST['cart_prod_id']));
            $branch_id = htmlspecialchars(trim($_POST['branch_id']));
            
            $result = $db->RemoveCartItem($cart_id,$cart_prod_id,$branch_id);
            
            if ($result == "success") {
                echo json_encode(["status" => 200, "message" => "Cart record successfully removed"]);
            } else {
                echo json_encode(["status" => 400, "message" => $result]);
            }
        }else if ($_POST['requestType'] == 'CompletePurchase') {
            session_start();
            $user_id = $_SESSION['id'];

            // echo "<pre>";
            // print_r($_POST);
            // echo "</pre>";
            
            $branch_id = htmlspecialchars(trim($_POST['branch_id']));
            $total = htmlspecialchars(trim($_POST['total']));
            $payment = htmlspecialchars(trim($_POST['payment']));
            $changeAmount = htmlspecialchars(trim($_POST['changeAmount']));
            $paymentMethod = htmlspecialchars(trim($_POST['paymentMethod']));
            $remarks = htmlspecialchars(trim($_POST['remarks']));
            
            $purchase_result = $db->addpurchase_record($paymentMethod, $total,$payment, $changeAmount, $branch_id,$remarks, $user_id);
            
            if (isset($purchase_result['id']) && isset($purchase_result['invoice'])) { 
                $purchase_id = $purchase_result['id'];
                $purchase_invoice = $purchase_result['invoice'];
                $branch_id = $purchase_result['branch_id'];
            
                echo json_encode([
                    "status" => 200, 
                    "message" => "Inventory record successfully added",
                    "purchase_id" => $purchase_id,
                    "invoice" => $purchase_invoice,
                ]);
            
                // Process cart items only if purchase record was successfully inserted
                if (!empty($_POST['cartItems']) && is_array($_POST['cartItems'])) {
                    foreach ($_POST['cartItems'] as $item) {
                        if (isset($item['cart_prod_id']) && isset($item['quantity']) && isset($item['cart_id'])) {
                            $item_prod_id = $item['cart_prod_id'];
                            $item_qty = $item['quantity'];
                            $cart_id = $item['cart_id'];
                            $cart_sale_price = $item['cart_sale_price'];
                            $prod_capital = $item['prod_capital'];
            
                            // Pass the valid purchase ID
                            $db->addpurchase_item($purchase_id,$branch_id, $item_prod_id, $item_qty, $cart_id,$cart_sale_price,$prod_capital);
                        }
                    }
                } else {
                    echo json_encode(["status" => 400, "message" => "No valid cart items found"]);
                }
            } else {
                echo json_encode(["status" => 400, "message" => $purchase_result['error'] ?? "Failed to add purchase record"]);
            }
            
            
            
        }else if($_POST['requestType'] =='GenericDelete'){

            // echo "<pre>";
            // print_r($_POST);
            // echo "</pre>";
            $id = $_POST['id'];
            $table = $_POST['table'];
            $id_name = $_POST['id_name'];
          
    
            $result = $db->GenericDelete($id,$table,$id_name);
    
            if ($result == "success") {
                echo json_encode(["status" => 200, "message" => "Delete Successfully"]);
            } else {
                echo json_encode(["status" => 400, "message" => $result]);
            }
            
        }
    }
}
?>