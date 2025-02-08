<?php
require_once 'adminFunctions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $orderId = $data['order_id'];
    $status = $data['status'];

    try {
        $stmt = $conn->prepare("UPDATE orders SET order_status = :status, updated_at = NOW() WHERE order_id = :order_id");
        $stmt->execute([':status' => $status, ':order_id' => $orderId]);

        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
}
?>