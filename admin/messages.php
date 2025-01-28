<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages - Admin Panel</title>
    <link rel="stylesheet" href="adminPanel.css">
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
                <th>Message</th>
                <th>Date</th>
            </tr>
            <!-- Messages here -->
        </table>
    </main>
</body>

</html>