<?php
include('../class.php');

$db = new global_class();



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['requestType'])) {
        if ($_POST['requestType'] == 'Login') {
                // Sanitize input
                    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
                    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

                    // Check for empty fields
                    if (empty($username) || empty($password)) {
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'Please enter both username and password.'
                        ]);
                        exit;
                    }

                    // Attempt login
                    $user = $db->Login($username, $password);

                    if ($user) {
                        // Start session securely
                        if (session_status() == PHP_SESSION_NONE) {
                            session_start();
                        }
                        session_regenerate_id(true);

                        // Determine the redirect path based on user_type
                        $redirectPath = '';
                        if ($user['user_type'] === 'Administrator'||$user['user_type'] === 'General Manager') {
                            $redirectPath = 'admin/dashboard';
                        } elseif ($user['user_type'] === 'Branch Manager') {
                            $redirectPath = 'branch_manager/';
                        }

                        echo json_encode([
                            'status' => 'success',
                            'message' => 'Login successful',
                            'redirect' => $redirectPath // Send the redirect path
                        ]);
                    } else {
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'Invalid username or password.'
                        ]);
                    }


        } else {
            echo 'requestType NOT FOUND';
        }
    } else {
        echo 'Access Denied! No Request Type.';
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
}
?>