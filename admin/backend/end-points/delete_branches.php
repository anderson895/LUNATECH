<?php
include('../class.php');

$db = new global_class();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decode JSON input
    $data = json_decode(file_get_contents("php://input"), true);
    $branchIds = $data['branchIds'] ?? [];

    if (!empty($branchIds) && is_array($branchIds)) {
        $placeholders = implode(',', array_fill(0, count($branchIds), '?'));
        $sql = "UPDATE `branches` SET `branch_status` = 0 WHERE `branch_id` IN ($placeholders)";
        $stmt = $db->conn->prepare($sql);

        if ($stmt) {
            $types = str_repeat('i', count($branchIds)); // 'i' for integer values
            $stmt->bind_param($types, ...$branchIds);

            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Branches removed successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to remove branches.']);
            }

            $stmt->close();
        } else {
            echo json_encode(['success' => false, 'message' => 'SQL prepare statement failed.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No branches selected or invalid input.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
