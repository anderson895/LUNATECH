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
    // Prepare the SQL query to fetch the stored password hash
    $query = $this->conn->prepare("SELECT * FROM `user` WHERE `user_username` = ? AND user_status = '1'");
    
    if (!$query) {
        return false; // Return false if preparation fails
    }

    // Bind the username
    $query->bind_param("s", $username);
    
    // Execute the query
    if ($query->execute()) {
        $result = $query->get_result();
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            // Verify the entered password with the stored hash
            if (password_verify($password, $user['user_password'])) {
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }

                // Regenerate session ID to prevent session fixation
                session_regenerate_id(true);
                
                $_SESSION['id'] = $user['id'];
                $_SESSION['user_type'] = $user['user_type'];

                // Close the statement
                $query->close();

                return $user;
            }
        }
    }

    // Close the statement and return false for failed login
    $query->close();
    return false;
}

    



}