<?php

include ('dbconnect.php');

date_default_timezone_set('Asia/Manila');

class global_class extends db_connect
{
    public function __construct()
    {
        $this->connect();
    }


    public function getDataAnalytics($branch_id)
    {
        $query = "
            SELECT 
                (SELECT COUNT(*) FROM `stock` WHERE stock_in_status='1') AS stockCount,
                (SELECT COUNT(*) FROM `purchase_record` WHERE purchase_branch_id=$branch_id) AS purchase_record_count,
                (
                    SELECT CONCAT(products.prod_name)
                    FROM `purchase_item` 
                    LEFT JOIN purchase_record ON purchase_record.purchase_id = purchase_item.item_purchase_id 
                    LEFT JOIN products ON products.prod_id = purchase_item.item_prod_id 
                    WHERE purchase_record.purchase_branch_id = $branch_id 
                    GROUP BY item_prod_id, products.prod_name
                    ORDER BY COUNT(item_prod_id) DESC 
                    LIMIT 1
                ) AS most_purchased_item
        ";
    
        // Execute the query
        $result = $this->conn->query($query);
        
        if ($result) {
            // Fetch the result and return as JSON
            $row = $result->fetch_assoc();
            echo json_encode($row);
        } else {
            // Error handling if query fails
            echo json_encode(['error' => 'Failed to retrieve counts', 'sql_error' => $this->conn->error]);
        }
    }
    
    

    

        public function getDailySalesData($branch_id)
    {
        $query = "
            SELECT 
                DATE(`purchase_date`) AS `order_day`, 
                SUM(`purchase_total_payment`) AS `daily_sales`
            FROM `purchase_record`
            WHERE purchase_record.purchase_branch_id = $branch_id 
            AND MONTH(`purchase_date`) = MONTH(CURDATE()) 
            AND YEAR(`purchase_date`) = YEAR(CURDATE())
            GROUP BY DATE(`purchase_date`)
            ORDER BY `order_day`
        ";

        $result = $this->conn->query($query);

        if ($result) {
            $salesData = [];
            while ($row = $result->fetch_assoc()) {
                $salesData[] = [
                    'date' => $row['order_day'],
                    'sales' => $row['daily_sales']
                ];
            }
            echo json_encode($salesData); // Return the sales data as JSON
        } else {
            echo json_encode(['error' => 'Failed to retrieve daily sales data']);
        }
    }




    public function getWeeklySales($branch_id)
    {
        $query = "
        SELECT 
            WEEK(`purchase_date`, 1) AS `order_week`,  -- `1` means the week starts on Monday
            SUM(`purchase_total_payment`) AS `weekly_sales`
        FROM `purchase_record`
        WHERE purchase_branch_id = $branch_id 
        AND YEAR(`purchase_date`) = YEAR(CURDATE())  -- Filter for current year
        GROUP BY WEEK(`purchase_date`, 1)
        ORDER BY `order_week`
    ";

    $result = $this->conn->query($query);

    if ($result) {
        $salesData = [];
        while ($row = $result->fetch_assoc()) {
            $salesData[] = [
                'week' => 'Week ' . $row['order_week'],
                'sales' => $row['weekly_sales']
            ];
        }
        echo json_encode($salesData); // Return the sales data as JSON
    } else {
        echo json_encode(['error' => 'Failed to retrieve weekly sales data']);
    }
    }





    



    public function getMonthlySales($branch_id)
    {
        $query = "
            SELECT 
                MONTH(`purchase_date`) AS `order_month`,
                SUM(`purchase_total_payment`) AS `monthly_sales`
            FROM `purchase_record`
            WHERE purchase_branch_id = $branch_id 
            AND YEAR(`purchase_date`) = YEAR(CURDATE()) 
            GROUP BY MONTH(`purchase_date`) 
            ORDER BY `order_month`
        ";
    
        $result = $this->conn->query($query);
    
        if ($result) {
            $salesData = [];
            while ($row = $result->fetch_assoc()) {
                $salesData[] = [
                    'month' => date('F', mktime(0, 0, 0, $row['order_month'], 10)),
                    'sales' => $row['monthly_sales']
                ];
            }
            echo json_encode($salesData);
        } else {
            // Log the error for debugging
            error_log('Database query failed: ' . $this->conn->error);
            echo json_encode(['error' => 'Failed to retrieve monthly sales data']);
        }
    }






    public function search_all_history($branch_id, $search = "", $limit = 10, $offset = 0) {
        $searchQuery = $search ? "AND (purchase_record.purchase_invoice LIKE ? OR purchase_record.purchase_date LIKE ?)" : "";
        
        $sql = "
            SELECT 
                purchase_record.*, 
                purchase_item.*, 
                user.user_fullname, 
                SUM(purchase_item.item_price_sold) AS total_item_price_sold, 
                SUM(purchase_item.item_price_capital) AS total_item_price_capital, 
                (SUM(purchase_item.item_price_sold) - SUM(purchase_item.item_price_capital)) AS total_profit
            FROM purchase_record
            LEFT JOIN user ON purchase_record.purchase_user_id = user.id
            LEFT JOIN branches ON branches.branch_id = purchase_record.purchase_branch_id 
            LEFT JOIN purchase_item ON purchase_item.item_purchase_id = purchase_record.purchase_id  
            WHERE purchase_record.purchase_branch_id = ? $searchQuery
            GROUP BY purchase_record.purchase_id, user.user_fullname
            ORDER BY branches.branch_name ASC
            LIMIT ? OFFSET ?
        ";
    
        $stmt = $this->conn->prepare($sql);
        
        if ($search) {
            $searchTerm = "%$search%";
            $stmt->bind_param("issii", $branch_id, $searchTerm, $searchTerm, $limit, $offset);
        } else {
            $stmt->bind_param("iii", $branch_id, $limit, $offset);
        }
    
        $stmt->execute();
        return $stmt->get_result();
    }
    
    
    // Function to count total history records
    public function count_all_history($branch_id, $search = "") {
        $searchQuery = $search ? "AND (purchase_record.purchase_invoice LIKE ? OR purchase_record.purchase_date LIKE ?)" : "";
        $sql = "
            SELECT COUNT(*) as total
            FROM purchase_record
            LEFT JOIN user ON purchase_record.purchase_user_id = user.id
            LEFT JOIN branches ON branches.branch_id = purchase_record.purchase_branch_id 
            WHERE purchase_record.purchase_branch_id = ? $searchQuery
        ";
    
        $stmt = $this->conn->prepare($sql);
        
        if ($search) {
            $searchTerm = "%$search%";
            $stmt->bind_param("iss", $branch_id, $searchTerm, $searchTerm);
        } else {
            $stmt->bind_param("i", $branch_id);
        }
    
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['total'] ?? 0;
    }
    
    













    public function AddToCart($branch_id, $qty, $prod_id) {
        // Get current stock quantities (FIFO order)
        $stockQuery = $this->conn->prepare(
            "SELECT stock_in_id, stock_in_qty 
             FROM stock 
             WHERE stock_in_prod_id = ? AND stock_in_branch_id = ? AND stock_in_status = '1' 
             ORDER BY stock_in_id"
        );
        $stockQuery->bind_param("ii", $prod_id, $branch_id);
        $stockQuery->execute();
        $stockResult = $stockQuery->get_result();
        
        // Fetch all stock entries for the product
        $stockEntries = [];
        while ($row = $stockResult->fetch_assoc()) {
            $stockEntries[] = $row;
        }
        
        // Check if there's enough stock
        $totalStock = array_sum(array_column($stockEntries, 'stock_in_qty'));
        if ($totalStock < $qty) {
            return 'Insufficient stock';
        }
    
        // Deduct stock from inventory and insert multiple entries in pos_cart
        foreach ($stockEntries as $stock) {
            if ($qty <= 0) break; // Stop if all quantity is allocated
    
            $deductQty = min($qty, $stock['stock_in_qty']);
    
            // Deduct from stock table
            $deductQuery = $this->conn->prepare(
                "UPDATE stock SET stock_in_qty = stock_in_qty - ? WHERE stock_in_id = ?"
            );
            $deductQuery->bind_param("ii", $deductQty, $stock['stock_in_id']);
            $deductQuery->execute();
    
            // Check if an entry with the same stock_in_id already exists in pos_cart
            $checkCartQuery = $this->conn->prepare(
                "SELECT cart_qty FROM pos_cart WHERE cart_prod_id = ? AND cart_branch_id = ? AND cart_stock_in_id = ?"
            );
            $checkCartQuery->bind_param("iii", $prod_id, $branch_id, $stock['stock_in_id']);
            $checkCartQuery->execute();
            $cartResult = $checkCartQuery->get_result();
    
            if ($cartResult->num_rows > 0) {
                // If exists, update the quantity
                $updateCartQuery = $this->conn->prepare(
                    "UPDATE pos_cart SET cart_qty = cart_qty + ? WHERE cart_prod_id = ? AND cart_branch_id = ? AND cart_stock_in_id = ?"
                );
                $updateCartQuery->bind_param("iiii", $deductQty, $prod_id, $branch_id, $stock['stock_in_id']);
                $updateCartQuery->execute();
            } else {
                // If not exists, insert a new row
                $insertCartQuery = $this->conn->prepare(
                    "INSERT INTO pos_cart (cart_prod_id, cart_qty, cart_branch_id, cart_stock_in_id) VALUES (?, ?, ?, ?)"
                );
                $insertCartQuery->bind_param("iiii", $prod_id, $deductQty, $branch_id, $stock['stock_in_id']);
                $insertCartQuery->execute();
            }
    
            $qty -= $deductQty; // Reduce remaining quantity
        }
    
        return 'success';
    }
    
    

    public function RemoveCartItem($cart_prod_id, $branch_id) {
        // Get all cart entries for the given product and branch
        $cartQuery = $this->conn->prepare("
            SELECT cart_id, cart_qty, cart_stock_in_id 
            FROM pos_cart 
            WHERE cart_prod_id = ? AND cart_branch_id = ?
        ");
        $cartQuery->bind_param("ii", $cart_prod_id, $branch_id);
        $cartQuery->execute();
        $result = $cartQuery->get_result();
        
        if ($result->num_rows > 0) {
            // Process each cart entry
            while ($cartRow = $result->fetch_assoc()) {
                $cart_id = $cartRow['cart_id'];
                $qty = $cartRow['cart_qty'];
                $stock_in_id = $cartRow['cart_stock_in_id']; // Track original stock source
                
                // Return stock to its original stock_in_id
                $returnStockQuery = $this->conn->prepare("
                    UPDATE stock 
                    SET stock_in_qty = stock_in_qty + ? 
                    WHERE stock_in_id = ?
                ");
                $returnStockQuery->bind_param("ii", $qty, $stock_in_id);
                $returnStockQuery->execute();
                
                // Delete the cart entry after restoring stock
                $deleteQuery = $this->conn->prepare("
                    DELETE FROM pos_cart 
                    WHERE cart_id = ?
                ");
                $deleteQuery->bind_param("i", $cart_id);
                $deleteQuery->execute();
            }
    
            return 'success';
        } else {
            return 'Error: No matching items found in cart';
        }
    }
    
    
    
    






    public function fetch_all_cart($branch_id) {
        $query = $this->conn->prepare("
            SELECT 
                MIN(c.cart_id) AS cart_id, 
                c.cart_prod_id, 
                SUM(c.cart_qty) AS cart_qty, 
                c.cart_branch_id, 
                p.prod_name, 
                p.prod_price,
                p.prod_capital
            FROM pos_cart c 
            JOIN products p ON c.cart_prod_id = p.prod_id
            WHERE c.cart_branch_id = ?
            GROUP BY c.cart_prod_id, c.cart_branch_id, p.prod_name, p.prod_price
        ");
        
        $query->bind_param("i", $branch_id);
        $query->execute();
        $result = $query->get_result();
    
        $cartItems = [];
    
        while ($row = $result->fetch_assoc()) {
            $cartItems[] = [
                'cart_id' => $row['cart_id'], // Only for reference, not meaningful in grouped data
                'cart_prod_id' => $row['cart_prod_id'],
                'prod_name' => $row['prod_name'],
                'prod_price' => $row['prod_price'],
                'prod_capital' => $row['prod_capital'],
                'cart_qty' => $row['cart_qty'] // Summed quantity of the product in the cart
            ];
        }
    
        return $cartItems;
    }
    
    


    public function GenericDelete($id,$table,$id_name) {
        $status = 0; 
        
        $query = $this->conn->prepare(
            "UPDATE `$table` SET `stock_in_status` = ? WHERE $id_name = ?"
        );
        $query->bind_param("ii", $status, $id);
        
        if ($query->execute()) {
            return 'success';
        } else {
            return 'Error: ' . $query->error;
        }
    }








    public function fetch_all_inventoryRecord_paginated($search = "", $branch_id, $limit = 10, $offset = 0) {
        $searchQuery = $search ? "AND (products.prod_name LIKE ? OR products.prod_code LIKE ?)" : "";
        
        $sql = "
            SELECT 
                products.prod_id,
                products.prod_code,
                products.prod_name,
                products.prod_price,
                stock.stock_in_id,
                SUM(stock.stock_in_qty) AS total_qty,
                SUM(stock.stock_in_sold) AS total_sold,
                SUM(stock.stock_in_backjob) AS total_backjob
            FROM stock
            LEFT JOIN products ON products.prod_id = stock.stock_in_prod_id
            WHERE stock.stock_in_status = '1' AND stock.stock_in_branch_id = ? $searchQuery
            GROUP BY products.prod_id
            LIMIT ? OFFSET ?
        ";
    
        $stmt = $this->conn->prepare($sql);
        
        if (!$stmt) {
            die("SQL Error: " . $this->conn->error);
        }
    
        if ($search) {
            $searchTerm = "%$search%";
            $stmt->bind_param("issii", $branch_id, $searchTerm, $searchTerm, $limit, $offset);
        } else {
            $stmt->bind_param("iii", $branch_id, $limit, $offset);
        }
    
        $stmt->execute();
        return $stmt->get_result();
    }
    
    

    public function count_all_inventoryRecord($branch_id,$search) {
        $query = $this->conn->prepare("
            SELECT COUNT(DISTINCT products.prod_id) AS total 
            FROM stock
            LEFT JOIN products ON products.prod_id = stock.stock_in_prod_id
            WHERE stock.stock_in_status = '1' AND stock.stock_in_branch_id = ?
        ");
    
        $query->bind_param("i", $branch_id);
        $query->execute();
        $result = $query->get_result()->fetch_assoc();
        return $result['total'];
    }
    
    
    


    public function addpurchase_record($paymentMethod, $total,$payment, $changeAmount, $branch_id, $user_id) {
        // Generate a unique invoice number
        do {
            $purchase_invoice = 'INV-' . time() . rand(1000, 9999);
            $checkQuery = $this->conn->prepare("SELECT COUNT(*) FROM `purchase_record` WHERE `purchase_invoice` = ?");
            $checkQuery->bind_param("s", $purchase_invoice);
            $checkQuery->execute();
            $checkQuery->bind_result($count);
            $checkQuery->fetch();
            $checkQuery->close();
        } while ($count > 0); // Repeat until a unique invoice is found
    
        // Prepare the insert query
        $query = $this->conn->prepare(
            "INSERT INTO `purchase_record` (`purchase_mode_of_payment`, `purchase_total_payment`,`purchase_payment`, `purchased_change`, `purchase_branch_id`, `purchase_user_id`, `purchase_invoice`) 
            VALUES (?, ?, ?,?, ?, ?, ?)"
        );
        $query->bind_param("sdddiis", $paymentMethod, $total,$payment, $changeAmount, $branch_id, $user_id, $purchase_invoice);
    
        if ($query->execute()) {
            return [
                'id' => $this->conn->insert_id, 
                'invoice' => $purchase_invoice,
                'branch_id' => $branch_id,
            ]; // Return both the inserted ID and the invoice number
        } else {
            return ['error' => 'Error: ' . $query->error];
        }
    }
    
    
    



    public function addpurchase_item($item_purchase_id,$branch_id, $item_prod_id, $item_qty, $cart_id,$prod_price,$prod_capital) {
        // Insert purchase item
        $query = $this->conn->prepare("
            INSERT INTO `purchase_item` (`item_purchase_id`, `item_prod_id`, `item_qty`,`item_price_sold`,`item_price_capital`) 
            VALUES (?, ?, ?,?,?)
        ");
        $query->bind_param("iiidd", $item_purchase_id, $item_prod_id, $item_qty,$prod_price,$prod_capital);
    
        if (!$query->execute()) {
            return 'Error: ' . $query->error;
        }
    
        // Fetch all cart items for the given product and branch
        $cartQuery = $this->conn->prepare("
            SELECT cart_id 
            FROM pos_cart 
            WHERE cart_prod_id = ? AND cart_branch_id = ?
        ");
        $cartQuery->bind_param("ii", $item_prod_id, $branch_id);
        $cartQuery->execute();
        $result = $cartQuery->get_result();
    
        if ($result->num_rows > 0) {
            // Loop through and delete each cart entry
            while ($row = $result->fetch_assoc()) {
                $deleteQuery = $this->conn->prepare("
                    DELETE FROM pos_cart WHERE cart_id = ?
                ");
                $deleteQuery->bind_param("i", $row['cart_id']);
                $deleteQuery->execute();
            }
        }
    
        return 'success';
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


     public function purchase_record($invoice,$purchase_id) {
        $id = intval($invoice);
        $purchase_id = intval($purchase_id);
        $query = "SELECT purchase_record.*, user.*, branches.*, 
       purchase_item.*, products.*
        FROM purchase_item  
        LEFT JOIN products ON products.prod_id = purchase_item.item_prod_id  
        LEFT JOIN purchase_record ON purchase_record.purchase_id = purchase_item.item_purchase_id  
        LEFT JOIN user ON user.id = purchase_record.purchase_user_id  
        LEFT JOIN branches ON branches.branch_id = purchase_record.purchase_branch_id   
        WHERE purchase_record.purchase_invoice = ? AND item_purchase_id=?
        GROUP BY purchase_item.item_id
        ";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $invoice,$purchase_id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        
        return $items;
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