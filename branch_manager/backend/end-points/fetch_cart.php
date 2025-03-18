<?php 
include('../class.php');

$db = new global_class();

session_start();
$id = intval($_SESSION['id']);
$On_Session = $db->check_account($id);
$branch_id = $On_Session[0]['branch_id'];

$fetch_all_cart = $db->fetch_all_cart($branch_id);

echo json_encode($fetch_all_cart);
?>
