<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - Elite Grooming Studio</title>
  <link rel="stylesheet" href="/EGS/assets/css/style.css" />
  <link rel="icon" href="/EGS/assets/images/2.png" type="image/x-icon">
</head>

<body>
  <?php require $_SERVER['DOCUMENT_ROOT'] . '/EGS/elements/header.php'; ?>
  <?php require $_SERVER['DOCUMENT_ROOT'] . '/EGS/functions.php'; ?>

  <main>
    <div class="login-container">
      <h2>Login</h2>

      <!-- Form Handling -->
      <?php
      $message = '';

      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = htmlspecialchars($_POST['username']); // Sanitize input
        $password = $_POST['password'];

        // Call the login function
        $result = loginUser($username, $password);

        if ($result['success']) {
          // Redirect to the dashboard or home page on success
          header("Location: /EGS/index.php");
          exit();
        } else {
          $message = $result['message']; // Display error message
        }
      }
      ?>

      <!-- Display Error Message -->
      <?php if ($message): ?>
        <p class="form-message"><?= htmlspecialchars($message) ?></p>
      <?php endif; ?>

      <!-- Login Form -->
      <form id="login-form" method="POST" action="">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required />

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required />

        <button type="submit">Login</button>
      </form>

      <!-- Link to Signup Page -->
      <p class="form-link">
        Don't have an account?
        <a href="/EGS/pages/signup.php">Signup here</a>
      </p>

      <!-- Forgot Password Link -->
      <p class="form-link">
        Forgot your password?
        <a href="/EGS/pages/recover-password.php">Recover here</a>
      </p>
    </div>
  </main>

  <?php require $_SERVER['DOCUMENT_ROOT'] . '/EGS/elements/footer.php'; ?>
</body>

</html>