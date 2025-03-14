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
    
    
    



    public function fetch_all_user(){
        $query = $this->conn->prepare("SELECT * FROM `user` where user_status='1'");

        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }







}