<?php
include ('dbconnect.php');
date_default_timezone_set('Asia/Manila');
$getDateToday = date('Y-m-d H:i:s'); 


class global_class extends db_connect
{
    public function __construct()
    {
        $this->connect();
    }

    public function check_account($id) {

        $id = intval($id);
    
        $query = "SELECT * FROM user WHERE id = $id";
    
        $result = $this->conn->query($query);
    
        $items = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $items[] = $row;
            }
        }
        return $items; 
    }
}