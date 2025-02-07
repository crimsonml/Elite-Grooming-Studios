<?php
require_once 'adminFunctions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $appointmentId = $data['appointment_id'];
    $status = $data['status'];

    try {
        $stmt = $conn->prepare("UPDATE appointments SET status = :status, updated_at = NOW() WHERE appointment_id = :appointment_id");
        $stmt->execute([':status' => $status, ':appointment_id' => $appointmentId]);

        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
}
