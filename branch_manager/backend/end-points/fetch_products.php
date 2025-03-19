<?php
include('../class.php'); 
$db = new global_class();

if (isset($_POST['query'])) {
    $search = $_POST['query'];
    

    $query = $db->conn->prepare("
        SELECT prod_code, prod_name, prod_id
        FROM products 
        WHERE (prod_code LIKE ? OR prod_name LIKE ?) AND prod_status = 1
        LIMIT 10
    ");
    
    $likeSearch = "%" . $search . "%";
    $query->bind_param("ss", $likeSearch, $likeSearch); // Bind both parameters
    $query->execute();
    $result = $query->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            "prod_id" => $row['prod_id'],
            "prod_code" => $row['prod_code'],
            "prod_name" => $row['prod_name']
        ];
    }

    echo json_encode($data);
}
?>
