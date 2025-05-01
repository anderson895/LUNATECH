<?php 

require '../../../vendor/autoload.php'; 
use Picqer\Barcode\BarcodeGeneratorPNG;


include('../class.php');












$db = new global_class();


$product_Category = $product_Promo = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if($_POST['requestType'] =='Adduser'){

        $user_fullname = htmlspecialchars(trim($_POST['user_fullname']));
        $user_email = filter_var(trim($_POST['user_email']), FILTER_SANITIZE_EMAIL);
        $user_username = htmlspecialchars(trim($_POST['user_username']));
        $user_password = trim($_POST['user_password']);
        $user_type = htmlspecialchars(trim($_POST['user_type']));

        if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(["status" => 400, "message" => "Invalid email format"]);
            exit;
        }
        $result = $db->Adduser($user_fullname, $user_email, $user_username, $user_password, $user_type);

        if ($result == "success") {
            echo json_encode(["status" => 200, "message" => "User successfully registered"]);
        } else {
            echo json_encode(["status" => 400, "message" => $result]);
        }
    }else if($_POST['requestType'] =='Updateuser'){

        $user_id = $_POST['update_id'];
        $user_fullname = htmlspecialchars(trim($_POST['update_user_fullname']));
        $user_email = filter_var(trim($_POST['update_user_email']), FILTER_SANITIZE_EMAIL);
        $user_username = htmlspecialchars(trim($_POST['update_user_username']));
        $user_password = trim($_POST['update_user_password']);
        $user_type = htmlspecialchars(trim($_POST['update_user_type']));

        if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(["status" => 400, "message" => "Invalid email format"]);
            exit;
        }

        $result = $db->Updateuser($user_id,$user_fullname, $user_email, $user_username, $user_password, $user_type);

        if ($result == "success") {
            echo json_encode(["status" => 200, "message" => "Update successfully"]);
        } else {
            echo json_encode(["status" => 400, "message" => $result]);
        }
        
    }else if($_POST['requestType'] =='addbranch'){

        $branch_code = htmlspecialchars(trim($_POST['branch_code']));
        $branch_name = htmlspecialchars(trim($_POST['branch_name']));
        $branch_address = htmlspecialchars(trim($_POST['branch_address']));
        $branch_manager = htmlspecialchars(trim($_POST['branch_manager']));

        $result = $db->addbranch($branch_code, $branch_name, $branch_address, $branch_manager);

        if ($result == "success") {
            echo json_encode(["status" => 200, "message" => "Successfully Added"]);
        } else {
            echo json_encode(["status" => 400, "message" => $result]);
        }
        
    }else if($_POST['requestType'] =='updatebranch'){

        $branch_id = $_POST['branch_id'];
        $branch_code = htmlspecialchars(trim($_POST['branch_code']));
        $branch_name = htmlspecialchars(trim($_POST['branch_name']));
        $branch_address = htmlspecialchars(trim($_POST['branch_address']));
        $branch_manager = htmlspecialchars(trim($_POST['branch_manager']));

        $result = $db->updatebranch($branch_id,$branch_code, $branch_name, $branch_address, $branch_manager);

        if ($result == "success") {
            echo json_encode(["status" => 200, "message" => "Update Successfully"]);
        } else {
            echo json_encode(["status" => 400, "message" => $result]);
        }
        
    }else if($_POST['requestType'] =='deletebranch'){

        $branch_id = $_POST['branch_id'];
      

        $result = $db->deletebranch($branch_id);

        if ($result == "success") {
            echo json_encode(["status" => 200, "message" => "Delete Successfully"]);
        } else {
            echo json_encode(["status" => 400, "message" => $result]);
        }
        
    }else if($_POST['requestType'] =='DeleteUser'){

        $user_id = $_POST['user_id'];
      

        $result = $db->DeleteUser($user_id);

        if ($result == "success") {
            echo json_encode(["status" => 200, "message" => "Delete Successfully"]);
        } else {
            echo json_encode(["status" => 400, "message" => $result]);
        }
        
    }else if($_POST['requestType'] =='addproduct'){
        session_start();
        $new_product_name = htmlspecialchars(trim($_POST['new_product_name']));
        $new_product_capital = htmlspecialchars(trim($_POST['new_product_capital']));
        $new_product_current = htmlspecialchars(trim($_POST['new_product_current']));
        $added_by = $_SESSION['id'];
        
        $result = $db->addproduct($new_product_name,$new_product_capital, $new_product_current, $added_by);
        
        if ($result == "success") {
            // Kunin ang latest product code (assuming auto-increment ID o last inserted code)
            $lastProdQuery = $db->conn->query("SELECT prod_code FROM products ORDER BY prod_id DESC LIMIT 1");
            $lastProd = $lastProdQuery->fetch_assoc();
            $Prod_code = $lastProd['prod_code'];
        
            // Generate barcode
            $generator = new BarcodeGeneratorPNG();
            $barcode = $generator->getBarcode($Prod_code, $generator::TYPE_CODE_128);
        
            // Save barcode image
            $barcodePath = "../../../barcodes/{$Prod_code}.png";
            file_put_contents($barcodePath, $barcode);
        
            echo json_encode([
                "status" => 200,
                "message" => "Product successfully added",
                "barcode_path" => $barcodePath
            ]);
        } else {
            echo json_encode(["status" => 400, "message" => $result]);
        }


    }else if($_POST['requestType'] =='updateProduct'){


        $prod_id = $_POST['prod_id'];
        $prod_name = htmlspecialchars(trim($_POST['prod_name']));
        $product_capital = htmlspecialchars(trim($_POST['update_product_capital']));
        $product_current = htmlspecialchars(trim($_POST['update_product_current']));

        $result = $db->updateProduct($prod_id,$prod_name,$product_capital,$product_current);

        if ($result == "success") {
            echo json_encode(["status" => 200, "message" => "Update Successfully"]);
        } else {
            echo json_encode(["status" => 400, "message" => $result]);
        }
        
    }else if($_POST['requestType'] =='DeleteProduct'){

        $prod_id = $_POST['prod_id'];
      

        $result = $db->DeleteProduct($prod_id);

        if ($result == "success") {
            echo json_encode(["status" => 200, "message" => "Delete Successfully"]);
        } else {
            echo json_encode(["status" => 400, "message" => $result]);
        }
        
    }else if($_POST['requestType'] =='StockChangeApproval'){

    //    echo "<pre>";
    //    print_r($_POST);
    //    echo "</pre>";

       $request = $_POST['request'];

        // Decode the JSON string to an associative array
        $request_changes = json_decode($request['stock_in_request_changes'], true);

        // Now access each field
        $stock_in_id = $request_changes['stock_in_id'];
        $user_id = $request_changes['user_id'];
        $branch_id = $request['stock_in_branch_id']; // This should come from $request, not $request_changes
        $stock_in_prod_id = $request['stock_in_prod_id']; // This should come from $request, not $request_changes
        $stock_in_qty = $request['stock_in_qty']; // This should come from $request, not $request_changes
        $stock_in_sold = $request['stock_in_sold']; // This should come from $request, not $request_changes
        $stock_in_backjob = $request['stock_in_backjob']; // This should come from $request, not $request_changes
        $date_request = $request_changes['date_request']; // This comes from $request_changes

        // Handle approval types
        if ($_POST['approval_type'] == "For Stock Deletion") {
            $result = $db->StockDeletion($stock_in_id);
        } elseif ($_POST['approval_type'] == "For Stock Update") {
            $result = $db->StockUpdate($branch_id, $stock_in_prod_id, $stock_in_id, $stock_in_qty, $stock_in_sold, $stock_in_backjob);
        }

        // Return result
        if ($result == "success") {
            echo json_encode(["status" => 200, "message" => "Delete Successfully"]);
        } else {
            echo json_encode(["status" => 400, "message" => $result]);
        }

        
    }
}
?>

