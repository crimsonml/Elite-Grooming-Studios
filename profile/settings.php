<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Settings - Elite Grooming Studio</title>
    <link rel="stylesheet" href="/EGS/assets/css/style.css">
</head>

<body>
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/EGS/elements/header.php'; ?>

    <main class="profile-container">
        <div class="profile-sidebar">
            <ul>
                <li><a href="/EGS/profile/settings.php" class="active">Profile Settings</a></li>
                <li><a href="/EGS/profile/orders.php">Order History</a></li>
                <li><a href="/EGS/profile/appointments.php">Appointment History</a></li>
                <li><a href="/EGS/profile/logout.php" class="logout">Logout</a></li>
            </ul>
        </div>

        <div class="profile-content">
            <h1>Profile Settings</h1>
            <form action="/EGS/profile/settings-update.php" method="POST" enctype="multipart/form-data">
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" value="John Doe" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="johndoe@example.com" required>

                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone" value="1234567890" required>

                <label for="address">Address:</label>
                <textarea id="address" name="address" required>123 Elite St., Grooming City</textarea>

                <label for="password">Change Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter new password">

                <button type="submit">Update Profile</button>
            </form>
        </div>
    </main>

    <?php require $_SERVER['DOCUMENT_ROOT'] . '/EGS/elements/footer.php'; ?>
</body>

</html>