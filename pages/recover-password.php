<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Recover Password - Elite Grooming Studio</title>
    <link rel="stylesheet" href="/EGS/assets/css/style.css" />
</head>

<body>
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/EGS/elements/header.php'; ?>
    <main>
        <div class="recover-container">
            <h2>Recover Password</h2>
            <form id="recover-form">
                <label for="email">Enter your email address:</label>
                <input type="email" id="email" name="email" required />

                <button type="submit">Send OTP</button>
            </form>

            <!-- Confirmation Message -->
            <p class="form-link" id="otp-sent-message" style="display: none;">
                An OTP has been sent to your email. <a href="/EGS/pages/reset-password.php">Reset your password here</a>.
            </p>
        </div>
    </main>
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/EGS/elements/footer.php'; ?>
    <script>
        const recoverForm = document.getElementById("recover-form");
        const otpSentMessage = document.getElementById("otp-sent-message");

        recoverForm.addEventListener("submit", function(e) {
            e.preventDefault();
            // Simulate OTP being sent
            otpSentMessage.style.display = "block";
        });
    </script>
</body>

</html>