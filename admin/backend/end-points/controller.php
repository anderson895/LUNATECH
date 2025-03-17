<?php 
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

        // Validate email format
        if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(["status" => 400, "message" => "Invalid email format"]);
            exit;
        }

        // Call the Adduser function
        $result = $db->Adduser($user_fullname, $user_email, $user_username, $user_password, $user_type);

        // Handle response
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

        // Validate email format
        if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(["status" => 400, "message" => "Invalid email format"]);
            exit;
        }

        // Call the Adduser function
        $result = $db->Updateuser($user_id,$user_fullname, $user_email, $user_username, $user_password, $user_type);

        // Handle response
        if ($result == "success") {
            echo json_encode(["status" => 200, "message" => "Update successfully"]);
        } else {
            echo json_encode(["status" => 400, "message" => $result]);
        }
        
    }
}
?>

