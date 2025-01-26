<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/EGS/functions.php';

$data = json_decode(file_get_contents('php://input'), true);
$itemId = $data['itemId'];
$quantity = $data['quantity'];

session_start();
$pdo = connectDB();

if (isset($_SESSION['user_id'])) {
    // User is logged in, update cart item quantity in the database
    $userId = $_SESSION['user_id'];

    try {
        // Get the cart ID for the user
        $sql = "SELECT cart_id FROM carts WHERE user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        $cart = $stmt->fetch();

        if ($cart) {
            $cartId = $cart['cart_id'];

            // Update the quantity in the cart_items table
            $sql = "UPDATE cart_items SET quantity = :quantity WHERE cart_id = :cart_id AND item_id = :item_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':quantity' => $quantity, ':cart_id' => $cartId, ':item_id' => $itemId]);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Cart not found']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    // User is not logged in, update cart item quantity in the session
    if (isset($_SESSION['cart'][$itemId])) {
        $_SESSION['cart'][$itemId] = $quantity;
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Item not found in cart']);
    }
}
