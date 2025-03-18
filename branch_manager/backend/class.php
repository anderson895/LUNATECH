<?php

include ('dbconnect.php');

date_default_timezone_set('Asia/Manila');

class global_class extends db_connect
{
    public function __construct()
    {
        $this->connect();
    }



    public function RemoveCartItem($cart_id) {
        $query = $this->conn->prepare("DELETE FROM `pos_cart` WHERE cart_id = ?");
        $query->bind_param("i", $cart_id); 
    
        if ($query->execute()) {
            return 'success';
        } else {
            return 'Error: ' . $query->error;
        }
    }
    






    public function fetch_all_cart($branch_id) {
        $query = $this->conn->prepare("
            SELECT c.cart_id, c.cart_prod_id, c.cart_qty, c.cart_branch_id, p.prod_name, p.prod_price 
            FROM pos_cart c 
            JOIN products p ON c.cart_prod_id = p.prod_id
            WHERE c.cart_branch_id = ?
        ");
        
        $query->bind_param("i", $branch_id);
        $query->execute();
        $result = $query->get_result();
    
        $cartItems = [];
    
        while ($row = $result->fetch_assoc()) {
            $cartItems[] = [
                'cart_id' => $row['cart_id'],
                'cart_prod_id' => $row['cart_prod_id'],
                'prod_name' => $row['prod_name'],
                'prod_price' => $row['prod_price'],
                'cart_qty' => $row['cart_qty']
            ];
        }
    
        return $cartItems; 
    }
    

    public function fetch_all_inventoryRecord($branch_id) {
        $query = $this->conn->prepare("
            SELECT 
                products.prod_id,
                products.prod_code,
                products.prod_name,
                products.prod_price,
                SUM(stock.stock_in_qty) AS total_qty,
                SUM(stock.stock_in_sold) AS total_sold,
                SUM(stock.stock_in_backjob) AS total_backjob
            FROM stock
            LEFT JOIN products ON products.prod_id = stock.stock_in_prod_id
            WHERE stock.stock_in_status = '1' AND stock.stock_in_branch_id = ?
            GROUP BY products.prod_id
        ");
    
        $query->bind_param("i", $branch_id); 
    
        if ($query->execute()) {
            return $query->get_result();
        }
        
        return false; 
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


    public function AddToCart($branch_id, $qty, $prod_id) {
        // Check if product already exists in the cart
        $checkQuery = $this->conn->prepare(
            "SELECT cart_qty FROM pos_cart WHERE cart_prod_id = ? AND cart_branch_id = ?"
        );
        $checkQuery->bind_param("ii", $prod_id, $branch_id);
        $checkQuery->execute();
        $result = $checkQuery->get_result();
    
        if ($result->num_rows > 0) {
            // Update existing quantity
            $updateQuery = $this->conn->prepare(
                "UPDATE pos_cart SET cart_qty = cart_qty + ? WHERE cart_prod_id = ? AND cart_branch_id = ?"
            );
            $updateQuery->bind_param("iii", $qty, $prod_id, $branch_id);
    
            if ($updateQuery->execute()) {
                return 'success';
            } else {
                return 'Error: ' . $updateQuery->error;
            }
        } else {
            // Insert new record
            $insertQuery = $this->conn->prepare(
                "INSERT INTO pos_cart (cart_prod_id, cart_qty, cart_branch_id) VALUES (?, ?, ?)"
            );
            $insertQuery->bind_param("iii", $prod_id, $qty, $branch_id);
    
            if ($insertQuery->execute()) {
                return 'success';
            } else {
                return 'Error: ' . $insertQuery->error;
            }
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