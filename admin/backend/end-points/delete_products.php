<?php
include('../class.php');

$db = new global_class();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productIds = $_POST['productIds'] ?? [];

    if (!empty($productIds)) {
        $placeholders = implode(',', array_fill(0, count($productIds), '?'));
        $sql = "UPDATE `products` SET `prod_status` = 0 WHERE prod_id IN ($placeholders)";
        $stmt = $db->conn->prepare($sql);
        
        if ($stmt) {
            $types = str_repeat('i', count($productIds)); // 'i' for integer types
            $stmt->bind_param($types, ...$productIds);
            
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Products deleted successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete products.']);
            }

            $stmt->close();
        } else {
            echo json_encode(['success' => false, 'message' => 'SQL prepare failed.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No products selected.']);
    }
}
?>
