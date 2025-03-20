<?php
include('../class.php');
$db = new global_class();


session_start();
$id = intval($_SESSION['id']);
$On_Session = $db->check_account($id);
$branch_id = $On_Session[0]['branch_id'];

$orders = $db->getTodaySalesData($branch_id);

    
   