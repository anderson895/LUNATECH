<?php

include ('dbconnect.php');

date_default_timezone_set('Asia/Manila');

class global_class extends db_connect
{
    public function __construct()
    {
        $this->connect();
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
                p.prod_price 
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
                'cart_qty' => $row['cart_qty'] // Summed quantity of the product in the cart
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
    
    
    



    public function addpurchase_item($item_purchase_id, $branch_id, $item_prod_id, $item_qty) {
        // Insert purchase item
        $query = $this->conn->prepare("
            INSERT INTO `purchase_item` (`item_purchase_id`, `item_prod_id`, `item_qty`) 
            VALUES (?, ?, ?)
        ");
        $query->bind_param("iii", $item_purchase_id, $item_prod_id, $item_qty);
    
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


     public function purchase_record($invoice) {
        $id = intval($invoice);
        $query = "SELECT purchase_record.*, user.*, branches.*, 
       purchase_item.*, products.*
        FROM purchase_item  
        LEFT JOIN products ON products.prod_id = purchase_item.item_prod_id  
        LEFT JOIN purchase_record ON purchase_record.purchase_id = purchase_item.item_purchase_id  
        LEFT JOIN user ON user.id = purchase_record.purchase_user_id  
        LEFT JOIN branches ON branches.branch_id = purchase_record.purchase_branch_id   
        WHERE purchase_record.purchase_invoice = ?
        GROUP BY purchase_item.item_id
        ";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $invoice);
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