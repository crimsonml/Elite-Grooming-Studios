<?php
require_once 'adminFunctions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $smallDescription = $_POST['small_description'];
    $longDescription = $_POST['long_description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $image = $_FILES['image'];

    // Validate and upload the image
    $targetDir = $_SERVER['DOCUMENT_ROOT'] . '/EGS/assets/itemphotos/';
    $imageFileType = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
    $newFileName = uniqid() . '.' . $imageFileType;
    $targetFile = $targetDir . $newFileName;

    if (move_uploaded_file($image['tmp_name'], $targetFile)) {
        // Insert the product into the database
        $stmt = $conn->prepare("INSERT INTO items (item_name, small_description, long_description, price, stock, image_location) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$name, $smallDescription, $longDescription, $price, $stock, $newFileName])) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to upload image']);
    }
}
?>
