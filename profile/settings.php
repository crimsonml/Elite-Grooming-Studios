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
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . '/EGS/functions.php';

    $userDetails = getUserDetails($_SESSION['user_id']);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $fullName = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];

        $updateResult = updateUserDetails($_SESSION['user_id'], $fullName, $email, $phone, $address);
        $userDetails = getUserDetails($_SESSION['user_id']);
    }
    ?>
    <main class="profile-container">
        <?php require $_SERVER['DOCUMENT_ROOT'] . '/EGS/profile/sidebar.php'; ?>

        <div class="profile-content">
            <h1>Profile Settings</h1>
            <?php if (isset($updateResult)): ?>
                <p id="updateMessage"><?= htmlspecialchars($updateResult['message']) ?></p>
                <script>
                    setTimeout(function() {
                        document.getElementById('updateMessage').style.display = 'none';
                    }, 5000);
                </script>
            <?php endif; ?>
            <form action="" method="POST" enctype="multipart/form-data">
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($userDetails['full_name']) ?>" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($userDetails['email']) ?>" required>

                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone" value="<?= htmlspecialchars($userDetails['phone']) ?>" required>

                <label for="address">Address:</label>
                <textarea id="address" name="address" required><?= htmlspecialchars($userDetails['address']) ?></textarea>

                <button type="submit">Update Profile</button>
            </form>
        </div>
    </main>

    <?php require $_SERVER['DOCUMENT_ROOT'] . '/EGS/elements/footer.php'; ?>
</body>

</html>