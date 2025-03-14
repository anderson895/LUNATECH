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


    public function Adduser($user_fullname, $user_email, $user_username, $user_password, $user_type) {
        // Hash the password using the default PHP hash algorithm (BCRYPT)
        $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);
    
        // Prepare the SQL query
        $query = $this->conn->prepare(
            "INSERT INTO `user` (`user_fullname`, `user_username`, `user_email`, `user_password`, `user_type`) VALUES (?, ?, ?, ?, ?)"
        );  
    
        // Bind parameters (s = string)
        $query->bind_param("sssss", $user_fullname, $user_username, $user_email, $hashed_password, $user_type);
    
        // Execute the query and check for success
        if ($query->execute()) {
            return 'success';
        } else {
            return 'Error: ' . $query->error;
        }
    }
    



    public function fetch_all_user(){
        $query = $this->conn->prepare("SELECT * FROM `user` where user_status='1'");

        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }







}