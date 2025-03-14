<?php 
include('../class.php');

$db = new global_class();


$product_Category = $product_Promo = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if($_POST['requestType'] =='Adduser'){

      
        $user_fullname=$_POST['user_fullname'];
        $user_email=$_POST['user_email'];
        $user_username=$_POST['user_username'];
        $user_password=$_POST['user_password'];
        $user_type=$_POST['user_type'];
        
        $result = $db->Adduser($user_fullname,$user_email,$user_username,$user_password,$user_type);
        if ($result=="success") {
            echo 200; 
        } else {
            echo 'Failed to add user in the database.';
        }
        
    }
}
?>

