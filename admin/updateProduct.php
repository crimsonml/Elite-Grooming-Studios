<?php
require_once 'adminFunctions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'] ?? null;
    $smallDescription = $_POST['small_description'] ?? null;
    $longDescription = $_POST['long_description'] ?? null;
    $price = $_POST['price'] ?? null;
    $stock = $_POST['stock'] ?? null;
    $image = $_FILES['image'];

    $updateFields = [];
    $updateValues = [];

    if ($name) {
        $updateFields[] = 'item_name = ?';
        $updateValues[] = $name;
    }
    if ($smallDescription) {
        $updateFields[] = 'small_description = ?';
        $updateValues[] = $smallDescription;
    }
    if ($longDescription) {
        $updateFields[] = 'long_description = ?';
        $updateValues[] = $longDescription;
    }
    if ($price) {
        $updateFields[] = 'price = ?';
        $updateValues[] = $price;
    }
    if ($stock) {
        $updateFields[] = 'stock = ?';
        $updateValues[] = $stock;
    }

    if ($image['size'] > 0) {
        $targetDir = $_SERVER['DOCUMENT_ROOT'] . '/EGS/assets/itemphotos/';
        $imageFileType = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
        $newFileName = uniqid() . '.' . $imageFileType;
        $targetFile = $targetDir . $newFileName;

        if (move_uploaded_file($image['tmp_name'], $targetFile)) {
            $updateFields[] = 'image_location = ?';
            $updateValues[] = $newFileName;
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to upload image']);
            exit;
        }
    }

    if (!empty($updateFields)) {
        $updateValues[] = $id;
        $stmt = $conn->prepare("UPDATE items SET " . implode(', ', $updateFields) . " WHERE item_id = ?");
        if ($stmt->execute($updateValues)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No fields to update']);
    }
}
?>