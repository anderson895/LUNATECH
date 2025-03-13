<?php


include ('dbconnect.php');

date_default_timezone_set('Asia/Manila');

class global_class extends db_connect
{
    public function __construct()
    {
        $this->connect();
    }


    public function Login($username, $password)
{
    $query = $this->conn->prepare("SELECT * FROM `user` WHERE `user_username` = ? AND user_status = '1'");
    $query->bind_param("s", $username);
    
    // Execute the query
    if ($query->execute()) {
        $result = $query->get_result();
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            if (password_verify($password, $user['user_password'])) {
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }

                session_regenerate_id(true);
                
                $_SESSION['id'] = $user['id'];
                $_SESSION['user_type'] = $user['user_type'];

                $query->close();

                return $user;
            }
        }
    }
    $query->close();
    return false;
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