<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details - Elite Grooming Studio</title>
    <link rel="stylesheet" href="/EGS/assets/css/style.css">
</head>

<body>
    <?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/EGS/elements/header.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/EGS/functions.php';

    // Ensure user is logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: /EGS/pages/logIn.php");
        exit;
    }

    // Get the order details
    $orderId = $_GET['order_id'] ?? null;
    if (!$orderId) {
        die("Error: Order ID is missing.");
    }

    $userId = $_SESSION['user_id'];
    $order = getOrderDetails($orderId, $userId);
    $orderItems = getOrderItems($orderId);

    if (!$order) {
        die("Error: Order not found or you don't have access to it.");
    }
    ?>

    <main class="order-details-container">
        <h1>Order Details</h1>
        <div class="order-summary">
            <p><strong>Order ID:</strong> #<?= htmlspecialchars($order['order_id']) ?></p>
            <p><strong>Date:</strong> <?= htmlspecialchars($order['created_at']) ?></p>
            <p><strong>Status:</strong> <?= htmlspecialchars($order['order_status']) ?></p>
            <p><strong>Total Amount:</strong> $<?= htmlspecialchars($order['total_amount']) ?></p>
        </div>

        <h2>Items Ordered</h2>
        <ul class="order-items-list">
            <?php foreach ($orderItems as $item): ?>
                <li class="order-item">
                    <p><strong>Item:</strong> <?= htmlspecialchars($item['item_name']) ?></p>
                    <p><strong>Price:</strong> $<?= htmlspecialchars($item['price']) ?></p>
                    <p><strong>Quantity:</strong> <?= htmlspecialchars($item['quantity']) ?></p>
                    <p><strong>Subtotal:</strong> $<?= htmlspecialchars($item['subtotal']) ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    </main>

    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/EGS/elements/footer.php'; ?>
</body>

</html>