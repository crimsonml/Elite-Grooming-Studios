<?php
// database.php

// Database connection settings
$host = 'localhost';
$db_name = 'egs'; // Change this to your database name
$username = 'root'; // Adjust based on your server credentials
$password = ''; // Adjust based on your server credentials

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Fetch items
function fetchItems($conn, $id = null) {
    if ($id) {
        $stmt = $conn->prepare("SELECT * FROM items WHERE item_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        $stmt = $conn->query("SELECT * FROM items");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

// Add an item
function addItem($conn, $name, $small_description, $long_description, $price, $stock, $image) {
    $image_name = time() . '_' . basename($image['name']);
    $target_dir = $_SERVER['DOCUMENT_ROOT'] . '/EGS/assets/itemphotos/';
    $target_file = $target_dir . $image_name;

    if (move_uploaded_file($image['tmp_name'], $target_file)) {
        $stmt = $conn->prepare("INSERT INTO items (item_name, small_description, long_description, price, stock, image_location) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $small_description, $long_description, $price, $stock, $image_name]);
    } else {
        throw new Exception('Failed to upload image');
    }
}

// Update an item
function updateItem($conn, $id, $name, $small_description, $long_description, $price, $stock, $image) {
    $image_name = null;
    if ($image && $image['tmp_name']) {
        $image_name = time() . '_' . basename($image['name']);
        $target_dir = $_SERVER['DOCUMENT_ROOT'] . '/EGS/assets/itemphotos/';
        $target_file = $target_dir . $image_name;

        if (!move_uploaded_file($image['tmp_name'], $target_file)) {
            throw new Exception('Failed to upload image');
        }
    }

    if ($image_name) {
        $stmt = $conn->prepare("UPDATE items SET item_name = ?, small_description = ?, long_description = ?, price = ?, stock = ?, image_location = ? WHERE item_id = ?");
        $stmt->execute([$name, $small_description, $long_description, $price, $stock, $image_name, $id]);
    } else {
        $stmt = $conn->prepare("UPDATE items SET item_name = ?, small_description = ?, long_description = ?, price = ?, stock = ? WHERE item_id = ?");
        $stmt->execute([$name, $small_description, $long_description, $price, $stock, $id]);
    }
}

// Delete an item
function deleteItem($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM items WHERE item_id = ?");
    $stmt->execute([$id]);
}

// Handle requests
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        echo json_encode(fetchItems($conn, $_GET['id']));
    } else {
        echo json_encode(fetchItems($conn));
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $small_description = $_POST['small_description'];
        $long_description = $_POST['long_description'];
        $price = $_POST['price'];
        $stock = $_POST['stock'];
        $image = isset($_FILES['image']) ? $_FILES['image'] : null;
        updateItem($conn, $id, $name, $small_description, $long_description, $price, $stock, $image);
        echo json_encode(['message' => 'Item updated successfully']);
    } else {
        $name = $_POST['name'];
        $small_description = $_POST['small_description'];
        $long_description = $_POST['long_description'];
        $price = $_POST['price'];
        $stock = $_POST['stock'];
        $image = $_FILES['image'];
        addItem($conn, $name, $small_description, $long_description, $price, $stock, $image);
        echo json_encode(['message' => 'Item added successfully']);
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $data);
    $id = $data['id'];
    deleteItem($conn, $id);
    echo json_encode(['message' => 'Item deleted successfully']);
    exit;
}
