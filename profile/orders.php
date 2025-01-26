<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History - Elite Grooming Studio</title>
    <link rel="stylesheet" href="/EGS/assets/css/style.css">
</head>

<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/EGS/elements/header.php'; ?>

    <main class="profile-container">
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/EGS/profile/sidebar.php'; ?>

        <div class="profile-content">
            <h1>Order History</h1>
            <ul class="order-list">
                <li>
                    <p><strong>Order ID:</strong> #12345</p>
                    <p><strong>Date:</strong> 2024-01-15</p>
                    <p><strong>Items:</strong> Beard Oil x1, Hair Cream x2</p>
                    <p><strong>Total:</strong> $49.99</p>
                    <a href="/EGS/orders/download-invoice.php?order_id=12345" class="download-invoice">Download Invoice</a>
                </li>
                <!-- Additional orders go here -->
            </ul>
        </div>
    </main>

    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/EGS/elements/footer.php'; ?>
</body>

</html>