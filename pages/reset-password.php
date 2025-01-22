<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reset Password - Elite Grooming Studio</title>
    <link rel="stylesheet" href="/EGS/assets/css/style.css" />
</head>

<body>
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/EGS/elements/header.php'; ?>
    <main>
        <div class="reset-container">
            <h2>Reset Password</h2>
            <form id="reset-form">
                <label for="new-password">New Password:</label>
                <input type="password" id="new-password" name="new-password" required />

                <label for="confirm-password">Confirm Password:</label>
                <input type="password" id="confirm-password" name="confirm-password" required />

                <button type="submit">Reset Password</button>
            </form>
        </div>
    </main>
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/EGS/elements/footer.php'; ?>
    <script>
        const resetForm = document.getElementById("reset-form");

        resetForm.addEventListener("submit", function(e) {
            e.preventDefault();
            const newPassword = document.getElementById("new-password").value;
            const confirmPassword = document.getElementById("confirm-password").value;

            if (newPassword !== confirmPassword) {
                alert("Passwords do not match. Please try again.");
            } else {
                alert("Password successfully reset!");
                window.location.href = "/EGS/pages/login.php"; // Redirect to login page
            }
        });
    </script>
</body>

</html>