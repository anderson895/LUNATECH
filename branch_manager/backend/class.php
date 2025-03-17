<?php

include ('dbconnect.php');

date_default_timezone_set('Asia/Manila');

class global_class extends db_connect
{
    public function __construct()
    {
        $this->connect();
    }

    public function fetch_all_inventoryRecord($branch_id) {
        $query = $this->conn->prepare("
            SELECT 
                products.prod_id,
                products.prod_code,
                products.prod_name,
                SUM(stock.stock_in_qty) AS total_qty,
                SUM(stock.stock_in_sold) AS total_sold,
                SUM(stock.stock_in_backjob) AS total_backjob
            FROM stock
            LEFT JOIN products ON products.prod_id = stock.stock_in_prod_id
            WHERE stock.stock_in_status = '1' AND stock.stock_in_branch_id = ?
            GROUP BY products.prod_id
        ");
    
        $query->bind_param("i", $branch_id); // Assuming branch_id is an integer
    
        if ($query->execute()) {
            return $query->get_result();
        }
        
        return false; // Return false if the query execution fails
    }
    
    
    


    public function addInventoryRecord($branch_id,$stock_in_prod_id, $stock_in_qty, $stock_in_sold, $stock_in_backjob){
        $query = $this->conn->prepare(
            "INSERT INTO `stock` (`stock_in_branch_id`, `stock_in_prod_id`, `stock_in_qty`, `stock_in_sold`, `stock_in_backjob`) VALUES (?, ?, ?, ?, ?)"
        );
        $query->bind_param("ssssi", $branch_id, $stock_in_prod_id, $stock_in_qty, $stock_in_sold, $stock_in_backjob);
    
        if ($query->execute()) {
            return 'success';
        } else {
            return 'Error: ' . $query->error;
        }
    }
  

    public function check_account($id) {
        $id = intval($id);
        $status = 1;
    
        $query = "SELECT * FROM user 
                  LEFT JOIN branches 
                  ON user.id = branches.branch_manager_id 
                  AND branches.branch_status = ?
                  WHERE user.id = ?";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $status, $id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        
        return $items;
    }
    
    
}