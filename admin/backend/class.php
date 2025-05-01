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



    public function count_notification()
    {
        // Count pending requests
        $sql = "
            SELECT  
                COUNT(CASE WHEN stock.stock_in_action_approval != 'stock_in_action_approval' THEN 1 END) AS ListOfRequestCounts
            FROM stock
            WHERE stock.stock_in_status = '1'
        ";
    
        $result = $this->conn->query($sql);
    
        if ($result && $row = $result->fetch_assoc()) {
            echo json_encode([
                'ListOfRequestCounts' => $row['ListOfRequestCounts']
            ]);
        } else {
            echo json_encode([
                'ListOfRequestCounts' => 0
            ]);
        }
    }
    

    







    public function StockUpdate($branch_id, $stock_in_prod_id, $stock_in_id, $stock_in_qty, $stock_in_sold, $stock_in_backjob) {
        $query = $this->conn->prepare(
            "UPDATE `stock` 
             SET `stock_in_branch_id` = ?, `stock_in_qty` = ?, `stock_in_sold` = ?, `stock_in_backjob` = ?, 
                 `stock_in_action_approval` = NULL, `stock_in_request_changes` = NULL 
             WHERE `stock_in_id` = ?"
        );
    
        $query->bind_param("iiiii", $branch_id, $stock_in_qty, $stock_in_sold, $stock_in_backjob, $stock_in_id);
    
        if ($query->execute()) {
            return 'success';
        } else {
            return 'Error: ' . $query->error;
        }
    }
    

    public function StockDeletion($stock_in_id) {
        $query = $this->conn->prepare(
            "DELETE FROM `stock` WHERE stock_in_id = ?"
        );
        $query->bind_param("i", $stock_in_id);
        
        if ($query->execute()) {
            return 'success';
        } else {
            return 'Error: ' . $query->error;
        }
    }
    


    
    public function listRequest() {
        $query = "SELECT * FROM stock WHERE stock_in_action_approval IS NOT NULL";  // Corrected the query
    
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
    
        return $items;
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



    public function search_all_history($search = "", $branch_id = 0, $limit = 10, $offset = 0) {
        $whereClauses = [];
        $params = [];
        $paramTypes = "";
    
        if (!empty($search)) {
            $whereClauses[] = "(purchase_record.purchase_invoice LIKE ? OR purchase_record.purchase_date LIKE ?)";
            $searchTerm = "%$search%";
            $params[] = &$searchTerm;
            $params[] = &$searchTerm;
            $paramTypes .= "ss";
        }
    
        if ($branch_id > 0) {
            $whereClauses[] = "branches.branch_id = ?";
            $params[] = &$branch_id;
            $paramTypes .= "i";
        }
    
        $whereSql = !empty($whereClauses) ? "WHERE " . implode(" AND ", $whereClauses) : "";
    
        $sql = "
            SELECT purchase_record.*, branches.branch_name, 
                SUM(purchase_item.item_price_sold) AS total_item_price_sold, 
                SUM(purchase_item.item_price_capital) AS total_item_price_capital, 
                (SUM(purchase_item.item_price_sold) - SUM(purchase_item.item_price_capital)) AS total_profit
            FROM purchase_record
            LEFT JOIN branches ON branches.branch_id = purchase_record.purchase_branch_id
            LEFT JOIN purchase_item ON purchase_item.item_purchase_id = purchase_record.purchase_id
            $whereSql
            GROUP BY purchase_record.purchase_id
            ORDER BY purchase_record.purchase_date DESC
            LIMIT ? OFFSET ?";
    
        $stmt = $this->conn->prepare($sql);
        $params[] = &$limit;
        $params[] = &$offset;
        $paramTypes .= "ii";
        
        $stmt->bind_param($paramTypes, ...$params);
        $stmt->execute();
        return $stmt->get_result();
    }

       // Function to count total history records
    public function count_all_history($search = "") {
        $searchQuery = $search ? "WHERE (purchase_record.purchase_invoice LIKE ? OR purchase_record.purchase_date LIKE ?)" : "";
        
        $sql = "
            SELECT COUNT(*) as total
            FROM purchase_record
            LEFT JOIN user ON purchase_record.purchase_user_id = user.id
            LEFT JOIN branches ON branches.branch_id = purchase_record.purchase_branch_id 
            $searchQuery
        ";
    
        $stmt = $this->conn->prepare($sql);
        
        if ($search) {
            $searchTerm = "%$search%";
            $stmt->bind_param("ss", $searchTerm, $searchTerm);
        }
    
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        return $row['total'] ?? 0;
    }
    

    


    public function get_all_branches() {
        $sql = "SELECT branch_name,branch_id FROM branches where branch_status='1' ORDER BY branch_name ASC";
        $result = $this->conn->query($sql);
        return $result;
    }
    
    
    
 







    
    public function getSalesAllBranches($filterType)
{
    date_default_timezone_set('Asia/Manila');
    $getDateToday = date('Y-m-d');
    $currentYear = date('Y');
    $currentMonth = date('m');

    $filterType = in_array($filterType, ['daily', 'monthly']) ? $filterType : 'monthly';

    // Fetch branches
    $queryBranches = "SELECT branch_id, branch_name FROM branches WHERE branch_status = '1'";
    $resultBranches = $this->conn->query($queryBranches);

    if (!$resultBranches) {
        error_log("❌ DB Error: " . $this->conn->error);
        http_response_code(500);
        echo json_encode(['error' => 'Failed to retrieve branches']);
        return;
    }

    // Setup time periods
    if ($filterType === 'monthly') {
        $timePeriods = [
            'January', 'February', 'March', 'April', 'May', 'June', 
            'July', 'August', 'September', 'October', 'November', 'December'
        ];
    } else {
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
        $timePeriods = array_map('strval', range(1, $daysInMonth));
    }

    // Initialize sales data
    $salesData = [];
    while ($branch = $resultBranches->fetch_assoc()) {
        $salesData[$branch['branch_name']] = array_fill_keys($timePeriods, ['products' => [], 'total_sales' => 0]);
    }

    // Product-level sales
    $querySales = "
        SELECT 
            pr.purchase_branch_id, 
            b.branch_name, 
            " . ($filterType === 'monthly' ? "MONTH(CONVERT_TZ(pr.purchase_date, '+00:00', '+08:00'))" : "DAY(CONVERT_TZ(pr.purchase_date, '+00:00', '+08:00'))") . " AS order_period, 
            COALESCE(p.prod_name, 'Unknown Product') AS prod_name,
            CAST(SUM(pi.item_price_sold * pi.item_qty) AS DECIMAL(10,2)) AS total_product_sales
        FROM purchase_record pr
        LEFT JOIN branches b ON b.branch_id = pr.purchase_branch_id
        LEFT JOIN purchase_item pi ON pi.item_purchase_id = pr.purchase_id
        LEFT JOIN products p ON p.prod_id = pi.item_prod_id
        WHERE YEAR(CONVERT_TZ(pr.purchase_date, '+00:00', '+08:00')) = $currentYear
          " . ($filterType === 'daily' ? "AND MONTH(CONVERT_TZ(pr.purchase_date, '+00:00', '+08:00')) = $currentMonth" : "") . "
          AND b.branch_status = '1'
        GROUP BY pr.purchase_branch_id, b.branch_name, order_period, p.prod_name
        ORDER BY pr.purchase_branch_id, order_period
    ";

    $resultSales = $this->conn->query($querySales);

    if (!$resultSales) {
        error_log("❌ DB Error (sales): " . $this->conn->error);
        http_response_code(500);
        echo json_encode(['error' => 'Failed to retrieve product sales']);
        return;
    }

    while ($row = $resultSales->fetch_assoc()) {
        $branchName = $row['branch_name'];
        $period = ($filterType === 'monthly') ? $timePeriods[$row['order_period'] - 1] : strval($row['order_period']);
        $salesData[$branchName][$period]['products'][$row['prod_name']] = (float) $row['total_product_sales'];
    }

    // Branch total sales
    $queryTotals = "
        SELECT 
            pr.purchase_branch_id,
            b.branch_name,
            " . ($filterType === 'monthly' ? "MONTH(CONVERT_TZ(pr.purchase_date, '+00:00', '+08:00'))" : "DAY(CONVERT_TZ(pr.purchase_date, '+00:00', '+08:00'))") . " AS order_period,
            CAST(SUM(pr.purchase_total_payment) AS DECIMAL(10,2)) AS total_sales
        FROM purchase_record pr
        LEFT JOIN branches b ON b.branch_id = pr.purchase_branch_id
        WHERE YEAR(CONVERT_TZ(pr.purchase_date, '+00:00', '+08:00')) = $currentYear
          " . ($filterType === 'daily' ? "AND MONTH(CONVERT_TZ(pr.purchase_date, '+00:00', '+08:00')) = $currentMonth" : "") . "
          AND b.branch_status = '1'
        GROUP BY pr.purchase_branch_id, b.branch_name, order_period
        ORDER BY pr.purchase_branch_id, order_period
    ";

    $resultTotals = $this->conn->query($queryTotals);

    if (!$resultTotals) {
        error_log("❌ DB Error (totals): " . $this->conn->error);
        http_response_code(500);
        echo json_encode(['error' => 'Failed to retrieve total sales']);
        return;
    }

    while ($row = $resultTotals->fetch_assoc()) {
        $branchName = $row['branch_name'];
        $period = ($filterType === 'monthly') ? $timePeriods[$row['order_period'] - 1] : strval($row['order_period']);
        $salesData[$branchName][$period]['total_sales'] = (float) $row['total_sales'];
    }

    // Return result
    header('Content-Type: application/json');
    echo json_encode([
        'filterType' => $filterType,
        'salesData' => $salesData,
        'dateChecked' => $getDateToday
    ]);
}



    
    
    
    
    

    

    



    public function getDataAnalytics()
    {
        $query = "
            SELECT 
                (SELECT COUNT(*) FROM `user` WHERE user_status='1') AS totalUser,
                (SELECT COUNT(*) FROM `branches` WHERE branch_status='1') AS totalBranches,
                (SELECT COUNT(*) FROM `products` WHERE prod_status='1') AS totalProduct
        ";
    
        $result = $this->conn->query($query);
        
        if ($result) {
            $row = $result->fetch_assoc();
            echo json_encode($row);
        } else {
            echo json_encode(['error' => 'Failed to retrieve counts', 'sql_error' => $this->conn->error]);
        }
    }
    



    public function check_branch($id) {
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


    public function check_product($id) {
        $id = intval($id);
    
        $query = "SELECT * FROM products WHERE products.prod_id  = ?";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
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
        $query = "SELECT * FROM user WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        
        return $items;
    }
    
    public function Updateuser($user_id, $user_fullname, $user_email, $user_username, $user_password, $user_type) {
        // Check if the account exists
        $this->check_account($user_id);
    
        // Check if email or username already exists for another user
        $check_query = $this->conn->prepare(
            "SELECT user_email, user_username FROM `user` WHERE (user_email = ? OR user_username = ?) AND id != ?"
        );
        $check_query->bind_param("ssi", $user_email, $user_username, $user_id);
        $check_query->execute();
        $result = $check_query->get_result();
    
        if ($row = $result->fetch_assoc()) {
            if ($row['user_email'] === $user_email && $row['user_username'] === $user_username) {
                return 'Both Email and Username already exist!';
            } elseif ($row['user_email'] === $user_email) {
                return 'Email already exists!';
            } elseif ($row['user_username'] === $user_username) {
                return 'Username already exists!';
            }
        }
    
        // Prepare dynamic update query
        $update_fields = "user_fullname = ?, user_username = ?, user_email = ?, user_type = ?";
        $params = [$user_fullname, $user_username, $user_email, $user_type];
        $types = "ssss"; // String types
    
        if (!empty($user_password)) {
            $update_fields .= ", user_password = ?";
            $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);
            $params[] = $hashed_password;
            $types .= "s";
        }
    
        $update_fields .= " WHERE id = ?";
        $params[] = $user_id;
        $types .= "i"; // Integer type for ID
    
        $query = $this->conn->prepare("UPDATE `user` SET $update_fields");
        $query->bind_param($types, ...$params);
    
        if ($query->execute()) {
            return 'success';
        } else {
            return 'Error: ' . $query->error;
        }
    }
    
    


    public function Adduser($user_fullname, $user_email, $user_username, $user_password, $user_type) {
        // Check if email or username already exists
        $check_query = $this->conn->prepare("SELECT user_email, user_username FROM `user` WHERE user_email = ? OR user_username = ?");
        $check_query->bind_param("ss", $user_email, $user_username);
        $check_query->execute();
        $result = $check_query->get_result();
    
        if ($row = $result->fetch_assoc()) {
            if ($row['user_email'] === $user_email && $row['user_username'] === $user_username) {
                return 'Both Email and Username already exist!';
            } elseif ($row['user_email'] === $user_email) {
                return 'Email already exists!';
            } elseif ($row['user_username'] === $user_username) {
                return 'Username already exists!';
            }
        }
    
        // Hash the password
        $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);
    
        // Insert user data
        $query = $this->conn->prepare(
            "INSERT INTO `user` (`user_fullname`, `user_username`, `user_email`, `user_password`, `user_type`) VALUES (?, ?, ?, ?, ?)"
        );
        $query->bind_param("sssss", $user_fullname, $user_username, $user_email, $hashed_password, $user_type);
    
        if ($query->execute()) {
            return 'success';
        } else {
            return 'Error: ' . $query->error;
        }
    }
    



    public function addbranch($branch_code, $branch_name, $branch_address, $branch_manager) {
        $query = $this->conn->prepare(
            "INSERT INTO `branches` (`branch_code`, `branch_name`, `branch_address`, `branch_manager_id`) VALUES (?,?, ?, ?)"
        );
        $query->bind_param("sssi", $branch_code, $branch_name, $branch_address, $branch_manager);
    
        if ($query->execute()) {
            return 'success';
        } else {
            return 'Error: ' . $query->error;
        }
    }




    public function addproduct($new_product_name,$new_product_capital, $new_product_current, $added_by) {
        // Generate a unique product code
        do {
            $Prod_code = "P" . rand(10000, 99999); 
            $checkQuery = $this->conn->prepare("SELECT 1 FROM products WHERE prod_code = ?");
            $checkQuery->bind_param("s", $Prod_code);
            $checkQuery->execute();
            $checkQuery->store_result();
        } while ($checkQuery->num_rows > 0); // Loop until unique code is found
    
        // Prepare the INSERT query
        $query = $this->conn->prepare(
            "INSERT INTO `products` (`prod_code`, `prod_name`,`prod_capital`,`prod_current_price`, `prod_added_by`) VALUES (?,?, ?,?, ?)"
        );
        $query->bind_param("ssddi", $Prod_code, $new_product_name,$new_product_capital,$new_product_current,  $added_by);
    
        if ($query->execute()) {
            return 'success';
        } else {
            return 'Error: ' . $query->error;
        }
    }







    public function updateProduct($prod_id,$prod_name,$product_capital,$product_current){
    
        // Prepare the UPDATE query
        $query = $this->conn->prepare(
            "UPDATE `products` 
             SET `prod_name` = ?,`prod_capital` = ?,`prod_current_price` = ?
             WHERE `prod_id` = ?"
        );
        $query->bind_param("sddi", $prod_name,$product_capital,$product_current, $prod_id);
    
        if ($query->execute()) {
            return 'success';
        } else {
            return 'Error: ' . $query->error;
        }
    }
    
    



    public function deletebranch($branch_id) {
        $status = 0; 
        
        $query = $this->conn->prepare(
            "UPDATE `branches` SET `branch_status` = ? WHERE `branch_id` = ?"
        );
        $query->bind_param("is", $status, $branch_id);
        
        if ($query->execute()) {
            return 'success';
        } else {
            return 'Error: ' . $query->error;
        }
    }


    public function DeleteProduct($prod_id) {
        $status = 0; 
        $query = $this->conn->prepare(
            "UPDATE `products` SET `prod_status` = ? WHERE `prod_id` = ?"
        );
        $query->bind_param("is", $status, $prod_id);
        
        if ($query->execute()) {
            return 'success';
        } else {
            return 'Error: ' . $query->error;
        }
    }
    
    public function DeleteUser($user_id) {
        $status = 0; 
        
        $query = $this->conn->prepare(
            "UPDATE `user` SET `user_status` = ? WHERE `id` = ?"
        );
        $query->bind_param("is", $status, $user_id);
        
        if ($query->execute()) {
            return 'success';
        } else {
            return 'Error: ' . $query->error;
        }
    }
    


    public function updatebranch($branch_id, $branch_code, $branch_name, $branch_address, $branch_manager) {
        $query = $this->conn->prepare(
            "UPDATE `branches` 
             SET `branch_code` = ?, `branch_name` = ?, `branch_address` = ?, `branch_manager_id` = ? 
             WHERE `branch_id` = ?"
        );
        
        // Bind the parameters (ssssi = string, string, string, string, int)
        $query->bind_param("sssii", $branch_code, $branch_name, $branch_address, $branch_manager, $branch_id);
        
        if ($query->execute()) {
            return 'success';
        } else {
            return 'Error: ' . $query->error;
        }
    }
    
    
    public function fetch_all_branch_manager() {
        $query = $this->conn->prepare("
            SELECT DISTINCT user.*
            FROM user
            LEFT JOIN branches 
            ON branches.branch_manager_id = user.id
            WHERE user.user_type = 'Branch Manager' 
            AND user.user_status = '1'
            AND (branches.branch_manager_id IS NULL OR branches.branch_status = '0')
            AND NOT EXISTS (
                SELECT 1 FROM branches b
                WHERE b.branch_manager_id = user.id
                AND b.branch_status = '1'
            )
        ");
    
        if ($query->execute()) {
            return $query->get_result();
        }
        
        return false; // Return false if execution fails
    }
    
    



    public function fetch_all_product() {
        $query = $this->conn->prepare("
            SELECT products.*,user.user_fullname
            FROM products
            LEFT JOIN user 
            ON products.prod_added_by = user.id
            WHERE products.prod_status = '1'
        ");
    
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }


    
    public function fetch_all_branch(){
        $query = $this->conn->prepare("SELECT * FROM `branches` 
        LEFT JOIN user
        ON branches.branch_manager_id = user.id
        where branches.branch_status='1'
        ");

        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }
    

    public function fetch_all_user(){
        $query = $this->conn->prepare("SELECT * FROM `user` where user_status='1'");

        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }


   




    public function search_all_branch($search = "", $limit = 10, $offset = 0) {
        $searchQuery = $search ? "AND (branches.branch_code LIKE ? OR branches.branch_name LIKE ? OR user.user_fullname LIKE ?)" : "";
        $sql = "
            SELECT branches.*, user.user_fullname 
            FROM branches
            LEFT JOIN user ON branches.branch_manager_id = user.id
            WHERE branches.branch_status = '1' $searchQuery
            ORDER BY branches.branch_name ASC
            LIMIT ? OFFSET ?
        ";
    
        $stmt = $this->conn->prepare($sql);
        
        if ($search) {
            $searchTerm = "%$search%";
            $stmt->bind_param("sssii", $searchTerm, $searchTerm, $searchTerm, $limit, $offset);
        } else {
            $stmt->bind_param("ii", $limit, $offset);
        }
    
        $stmt->execute();
        return $stmt->get_result();
    }
    
    // Function to count total branches
    public function count_all_branch($search = "") {
        $searchQuery = $search ? "AND (branches.branch_name LIKE ? OR user.user_fullname LIKE ?)" : "";
        $sql = "
            SELECT COUNT(*) as total
            FROM branches
            LEFT JOIN user ON branches.branch_manager_id = user.id
            WHERE branches.branch_status = '1' $searchQuery
        ";
    
        $stmt = $this->conn->prepare($sql);
        
        if ($search) {
            $searchTerm = "%$search%";
            $stmt->bind_param("ss", $searchTerm, $searchTerm);
        }
    
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['total'];
    }
    


    


    public function search_all_product($search = "", $limit = 10, $offset = 0) {
        $searchQuery = $search ? "AND (products.prod_name LIKE ? OR products.prod_code LIKE ?)" : "";
        $sql = "
            SELECT products.*, user.user_fullname
            FROM products
            LEFT JOIN user ON products.prod_added_by = user.id
            WHERE products.prod_status = '1' $searchQuery
            ORDER BY products.prod_date_added DESC
            LIMIT ? OFFSET ?
        ";
    
        $stmt = $this->conn->prepare($sql);
        
        if ($search) {
            $searchTerm = "%$search%";
            $stmt->bind_param("ssii", $searchTerm, $searchTerm, $limit, $offset);
        } else {
            $stmt->bind_param("ii", $limit, $offset);
        }
    
        $stmt->execute();
        return $stmt->get_result();
    }
    
    // Function to count total records for pagination
    public function count_all_product($search = "") {
        $searchQuery = $search ? "AND (products.prod_name LIKE ? OR products.prod_code LIKE ?)" : "";
        $sql = "
            SELECT COUNT(*) as total
            FROM products
            WHERE products.prod_status = '1' $searchQuery
        ";
    
        $stmt = $this->conn->prepare($sql);
        
        if ($search) {
            $searchTerm = "%$search%";
            $stmt->bind_param("ss", $searchTerm, $searchTerm);
        }
    
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['total'];
    }
    




}