<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/EGS/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];
    $date = date('Y-m-d H:i:s');

    $pdo = connectDB();

    try {
        $sql = "INSERT INTO messages (name, email, contact, message, date) VALUES (:name, :email, :contact, :message, :date)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':contact' => $phone,
            ':message' => $message,
            ':date' => $date
        ]);

        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
}
