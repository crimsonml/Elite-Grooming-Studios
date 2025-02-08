<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History - Elite Grooming Studio</title>
    <link rel="stylesheet" href="/EGS/assets/css/style.css">
</head>

<body>
    <?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/EGS/elements/header.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/EGS/functions.php';

    // Ensure the user is logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: /EGS/pages/logIn.php");
        exit;
    }

    $userId = $_SESSION['user_id'];
    $orders = getRecentOrders($userId);
    ?>
    <main class="profile-container">
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/EGS/profile/sidebar.php'; ?>
        <div class="profile-content">
            <h1>Order History</h1>
            <?php if ($orders && count($orders) > 0): ?>
                <ul class="order-list">
                    <?php foreach ($orders as $order):
                        $orderItems = getOrderItems($order['order_id']);
                    ?>
                        <li>
                            <p><strong>Order ID:</strong> #<?= htmlspecialchars($order['order_id']) ?></p>
                            <p><strong>Date:</strong> <?= htmlspecialchars($order['created_at']) ?></p>
                            <p><strong>Total:</strong> $<?= htmlspecialchars($order['total_amount']) ?></p>
                            <?php if ($orderItems && count($orderItems) > 0): ?>
                                <p><strong>Items:</strong>
                                    <?php
                                    $itemsText = [];
                                    foreach ($orderItems as $item) {
                                        // Format: ItemName xQuantity
                                        $itemsText[] = htmlspecialchars($item['item_name']) . " x" . htmlspecialchars($item['quantity']);
                                    }
                                    echo implode(", ", $itemsText);
                                    ?>
                                </p>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>You have no orders.</p>
            <?php endif; ?>
        </div>
    </main>

    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/EGS/elements/footer.php'; ?>
</body>

</html>