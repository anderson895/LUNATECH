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
    



    public function addbranch($branch_code, $branch_name, $branch_address, $branch_started, $branch_manager) {
        $query = $this->conn->prepare(
            "INSERT INTO `branches` (`branch_code`, `branch_name`, `branch_address`, `branch_started`, `branch_manager_id`) VALUES (?, ?, ?, ?, ?)"
        );
        $query->bind_param("ssssi", $branch_code, $branch_name, $branch_address, $branch_started, $branch_manager);
    
        if ($query->execute()) {
            return 'success';
        } else {
            return 'Error: ' . $query->error;
        }
    }




    public function addproduct($new_product_name, $added_by) {
        // Generate a unique product code
        do {
            $Prod_code = "P" . rand(10000, 99999); // Example: P12345
            $checkQuery = $this->conn->prepare("SELECT 1 FROM products WHERE prod_code = ?");
            $checkQuery->bind_param("s", $Prod_code);
            $checkQuery->execute();
            $checkQuery->store_result();
        } while ($checkQuery->num_rows > 0); // Loop until unique code is found
    
        // Prepare the INSERT query
        $query = $this->conn->prepare(
            "INSERT INTO `products` (`prod_code`, `prod_name`, `prod_added_by`) VALUES (?, ?, ?)"
        );
        $query->bind_param("ssi", $Prod_code, $new_product_name, $added_by);
    
        if ($query->execute()) {
            return 'success';
        } else {
            return 'Error: ' . $query->error;
        }
    }







    public function updateProduct($prod_id, $prod_name) {
    
        // Prepare the UPDATE query
        $query = $this->conn->prepare(
            "UPDATE `products` 
             SET `prod_name` = ?
             WHERE `prod_id` = ?"
        );
        $query->bind_param("si", $prod_name, $prod_id);
    
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
    


    public function updatebranch($branch_id, $branch_code, $branch_name, $branch_address, $branch_started, $branch_manager) {
        $query = $this->conn->prepare(
            "UPDATE `branches` 
             SET `branch_code` = ?, `branch_name` = ?, `branch_address` = ?, `branch_started` = ?, `branch_manager_id` = ? 
             WHERE `branch_id` = ?"
        );
        
        // Bind the parameters (ssssi = string, string, string, string, int)
        $query->bind_param("ssssii", $branch_code, $branch_name, $branch_address, $branch_started, $branch_manager, $branch_id);
        
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
        $searchQuery = $search ? "AND (branches.branch_name LIKE ? OR user.user_fullname LIKE ?)" : "";
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
            $stmt->bind_param("ssii", $searchTerm, $searchTerm, $limit, $offset);
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