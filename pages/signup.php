<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Signup - Elite Grooming Studio</title>
    <link rel="stylesheet" href="/EGS/assets/css/style.css" />
    <link rel="icon" href="/EGS/assets/images/2.png" type="image/x-icon">
</head>

<body>
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/EGS/elements/header.php'; ?>
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/EGS/functions.php'; ?>
    <main>
        <div class="signup-container">
            <h2>Signup</h2>

            <!-- Form Handling -->
            <?php
            $message = '';
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $fullName = $_POST['fullname'];
                $email = $_POST['email'];
                $username = $_POST['username'];
                $password = $_POST['password'];
                $confirmPassword = $_POST['confirm-password'];

                // Call the signup function
                $result = registerUser($fullName, $email, $username, $password, $confirmPassword);
                $message = $result['message'];
            }
            ?>

            <!-- Display Success/Error Messages -->
            <?php if ($message): ?>
                <p class="form-message"><?= htmlspecialchars($message) ?></p>
            <?php endif; ?>

            <!-- Signup Form -->
            <form id="signup-form" method="POST" action="">
                <label for="fullname">Full Name:</label>
                <input type="text" id="fullname" name="fullname" required />

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required />

                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required />

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required />

                <label for="confirm-password">Confirm Password:</label>
                <input type="password" id="confirm-password" name="confirm-password" required />

                <button type="submit">Signup</button>
            </form>

            <p class="form-link">
                Already have an account?
                <a href="/EGS/pages/login.php">Login here</a>
            </p>
        </div>
    </main>
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/EGS/elements/footer.php'; ?>
</body>

</html>