<?php
require_once 'adminFunctions.php';
$messages = fetchMessages($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages - Admin Panel</title>
    <link rel="stylesheet" href="adminPanel.css">
    <link rel="icon" href="/EGS/assets/images/2.png" type="image/x-icon">
</head>

<body>
    <header class="admin-header">
        <h1>Messages</h1>
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
        <h2>Customer Messages</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Contact Number</th>
                <th>Message</th>
                <th>Date</th>
            </tr>
            <?php foreach ($messages as $message): ?>
                <tr>
                    <td><?= htmlspecialchars($message['name']) ?></td>
                    <td><?= htmlspecialchars($message['email']) ?></td>
                    <td><?= htmlspecialchars($message['contact']) ?></td>
                    <td><?= htmlspecialchars($message['message']) ?></td>
                    <td><?= htmlspecialchars($message['date']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </main>

    <footer class="admin-footer">
        <p>&copy; 2025 Elite Grooming Studio. All Rights Reserved.</p>
    </footer>
</body>

</html>