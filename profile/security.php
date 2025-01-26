<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security - Elite Grooming Studio</title>
    <link rel="stylesheet" href="/EGS/assets/css/style.css">
</head>

<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/EGS/elements/header.php'; ?>

    <?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/EGS/functions.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $currentPassword = $_POST['current_password'];
        $newPassword = $_POST['new_password'];

        $updateResult = changeUserPassword($_SESSION['user_id'], $currentPassword, $newPassword);
    }
    ?>

    <main class="profile-container">
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/EGS/profile/sidebar.php'; ?>

        <div class="profile-content">
            <h1>Security</h1>
            <?php if (isset($updateResult)): ?>
                <p id="update-message"><?= htmlspecialchars($updateResult['message']) ?></p>
                <script>
                    setTimeout(function() {
                        document.getElementById('update-message').style.display = 'none';
                    }, 5000);
                </script>
            <?php endif; ?>
            <form action="" method="POST" enctype="multipart/form-data">
                <label for="current_password">Current Password:</label>
                <input type="password" id="current_password" name="current_password" placeholder="Enter current password" require_onced>

                <label for="new_password">New Password:</label>
                <input type="password" id="new_password" name="new_password" placeholder="Enter new password" require_onced>

                <button type="submit">Update Password</button>
            </form>
        </div>
    </main>

    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/EGS/elements/footer.php'; ?>
</body>

</html>