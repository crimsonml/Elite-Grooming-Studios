<?php
require_once 'adminFunctions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    // Get the image location
    $stmt = $conn->prepare("SELECT image_location FROM items WHERE item_id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        // Delete the image file
        $imagePath = $_SERVER['DOCUMENT_ROOT'] . '/EGS/assets/itemphotos/' . $product['image_location'];
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        // Delete the product from the database
        $stmt = $conn->prepare("DELETE FROM items WHERE item_id = ?");
        if ($stmt->execute([$id])) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Product not found']);
    }
}
