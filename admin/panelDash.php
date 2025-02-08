<?php
require_once 'adminFunctions.php';

// Fetch summary data
$productCount = fetchProductCount($conn);
$messageCount = fetchMessageCount($conn);
$userCount = fetchUserCount($conn);
$appointmentCount = fetchAppointmentCount($conn);
$orderCount = fetchOrderCount($conn);

function fetchProductCount($conn)
{
    $stmt = $conn->query("SELECT COUNT(*) AS count FROM items");
    return $stmt->fetch(PDO::FETCH_ASSOC)['count'];
}

function fetchMessageCount($conn)
{
    $stmt = $conn->query("SELECT COUNT(*) AS count FROM messages");
    return $stmt->fetch(PDO::FETCH_ASSOC)['count'];
}

function fetchUserCount($conn)
{
    $stmt = $conn->query("SELECT COUNT(*) AS count FROM users");
    return $stmt->fetch(PDO::FETCH_ASSOC)['count'];
}

function fetchAppointmentCount($conn)
{
    $stmt = $conn->query("SELECT COUNT(*) AS count FROM appointments");
    return $stmt->fetch(PDO::FETCH_ASSOC)['count'];
}

function fetchOrderCount($conn)
{
    $stmt = $conn->query("SELECT COUNT(*) AS count FROM orders");
    return $stmt->fetch(PDO::FETCH_ASSOC)['count'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Dashboard</title>
    <link rel="stylesheet" href="adminPanel.css">
    <link rel="icon" href="/EGS/assets/images/2.png" type="image/x-icon">
</head>

<body>
    <header class="admin-header">
        <h1>Admin Panel</h1>
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

    <main class="admin-main">
        <h2>Dashboard</h2>
        <p>Welcome to the admin panel of Elite Grooming Studio. Use the navigation menu to manage your website.</p>

        <div class="summary-container">
            <div class="summary-item">
                <h3>Products</h3>
                <p>Total Products: <?= htmlspecialchars($productCount) ?></p>
                <a href="products.php">Manage Products</a>
            </div>
            <div class="summary-item">
                <h3>Messages</h3>
                <p>Total Messages: <?= htmlspecialchars($messageCount) ?></p>
                <a href="messages.php">View Messages</a>
            </div>
            <div class="summary-item">
                <h3>Users</h3>
                <p>Total Users: <?= htmlspecialchars($userCount) ?></p>
                <a href="users.php">Manage Users</a>
            </div>
            <div class="summary-item">
                <h3>Appointments</h3>
                <p>Total Appointments: <?= htmlspecialchars($appointmentCount) ?></p>
                <a href="appointments.php">Manage Appointments</a>
            </div>
            <div class="summary-item">
                <h3>Orders</h3>
                <p>Total Orders: <?= htmlspecialchars($orderCount) ?></p>
                <a href="orders.php">Manage Orders</a>
            </div>
        </div>
    </main>

    <footer class="admin-footer">
        <p>&copy; 2025 Elite Grooming Studio. All Rights Reserved.</p>
    </footer>
</body>

</html>