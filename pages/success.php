<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/EGS/functions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/EGS/vendor/autoload.php';

\Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_GET['session_id'])) {
    header("Location: /EGS/pages/cart.php");
    exit;
}

$session_id = $_GET['session_id'];
$checkout_session = \Stripe\Checkout\Session::retrieve($session_id);

$userId = $_SESSION['user_id'] ?? null;
$guestData = json_decode($checkout_session->metadata->guestData, true);
$totalAmount = $checkout_session->amount_total / 100; // Convert cents to dollars

// Check if the order has already been processed using the session ID
$pdo = connectDB();
$sql = "SELECT order_id FROM orders WHERE session_id = :session_id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':session_id' => $session_id]);
$order = $stmt->fetch();

if ($order) {
    $orderId = $order['order_id'];
} else {
    $cartItems = getCartItems();
    $orderId = storeOrder($userId, $guestData, $totalAmount, $cartItems, $session_id);

    // Clear the cart
    clearCart($userId);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Success - Elite Grooming Studio</title>
    <link rel="stylesheet" href="/EGS/assets/css/style.css">
    <link rel="icon" href="/EGS/assets/images/2.png" type="image/x-icon">
</head>

<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/EGS/elements/header.php'; ?>

    <main>
        <div class="success-container">
            <h2>Order Successful</h2>
            <p>Thank you for your order! Your order ID is <strong><?= htmlspecialchars($orderId) ?></strong>.</p>
            <p class="order-total">Total Amount: <strong>$<?= htmlspecialchars($totalAmount) ?></strong>.</p>
            <a href="/EGS/pages/shop.php" class="continue-shopping">Continue Shopping</a>
        </div>
    </main>

    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/EGS/elements/footer.php'; ?>
</body>

</html>