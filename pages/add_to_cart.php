<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/EGS/functions.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $itemId = $data['itemId'];
    $quantity = $data['quantity'];

    $result = addToCart($itemId, $quantity);

    if ($result['success']) {
        $cartItemCount = getCartItemCount();
        echo json_encode(['success' => true, 'cartItemCount' => $cartItemCount]);
    } else {
        echo json_encode(['success' => false, 'message' => $result['message']]);
    }
} elseif ($_GET['action'] === 'get_cart_count') {
    $cartItemCount = getCartItemCount();
    echo json_encode(['success' => true, 'cartItemCount' => $cartItemCount]);
}
