<?php
require_once 'adminFunctions.php';
$orders = fetchOrders($conn);

function fetchOrders($conn) {
    $stmt = $conn->query("SELECT * FROM orders ORDER BY created_at DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function fetchOrderItems($conn, $orderId) {
    $stmt = $conn->prepare("SELECT * FROM order_items WHERE order_id = :order_id");
    $stmt->execute([':order_id' => $orderId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders - Admin Panel</title>
    <link rel="stylesheet" href="adminPanel.css">
</head>

<body>
    <header class="admin-header">
        <h1>Orders</h1>
        <nav class="admin-nav">
            <ul>
                <li><a href="panelDash.php">Dashboard</a></li>
                <li><a href="/EGS/index.php">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="messages.php">Messages</a></li>
                <li><a href="users.php">Users</a></li>
                <li><a href="appointments.php">Appointments</a></li>
                <li><a href="orders.php">Orders</a></li>
                <li><a href="/EGS/pages/login.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Manage Orders</h2>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>User ID</th>
                    <th>Guest ID</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= htmlspecialchars($order['order_id']) ?></td>
                        <td><?= htmlspecialchars($order['user_id']) ?></td>
                        <td><?= htmlspecialchars($order['guest_id']) ?></td>
                        <td>$<?= htmlspecialchars($order['total_amount']) ?></td>
                        <td>
                            <select class="status-dropdown" data-id="<?= $order['order_id'] ?>">
                                <option value="Pending" <?= $order['order_status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="Completed" <?= $order['order_status'] == 'Completed' ? 'selected' : '' ?>>Completed</option>
                                <option value="Cancelled" <?= $order['order_status'] == 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                            </select>
                        </td>
                        <td><?= htmlspecialchars($order['created_at']) ?></td>
                        <td><?= htmlspecialchars($order['updated_at']) ?></td>
                        <td><button class="save-status-button" data-id="<?= $order['order_id'] ?>">Save</button></td>
                    </tr>
                    <tr>
                        <td colspan="8">
                            <strong>Order Items:</strong>
                            <ul>
                                <?php $orderItems = fetchOrderItems($conn, $order['order_id']); ?>
                                <?php foreach ($orderItems as $item): ?>
                                    <li><?= htmlspecialchars($item['item_name']) ?> x<?= htmlspecialchars($item['quantity']) ?> - $<?= htmlspecialchars($item['subtotal']) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

    <script>
        document.querySelectorAll('.save-status-button').forEach(button => {
            button.addEventListener('click', function() {
                const orderId = this.getAttribute('data-id');
                const status = document.querySelector(`.status-dropdown[data-id="${orderId}"]`).value;

                fetch('updateOrderStatus.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ order_id: orderId, status: status })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Status updated successfully');
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        });
    </script>
</body>

</html>