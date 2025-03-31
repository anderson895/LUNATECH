<?php
include('../class.php');
$db = new global_class();

$filterType=$_GET['filterType'];

$orders = $db->getSalesAllBranches($filterType);

    
   