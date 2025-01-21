<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - Elite Grooming Studio</title>
  <link rel="stylesheet" href="/EGS/assets/css/style.css" />
</head>

<body>
  <?php require $_SERVER['DOCUMENT_ROOT'] . '/EGS/elements/header.php'; ?>
  <main>
    <div class="login-container">
      <h2>Login</h2>
      <form id="login-form">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required />

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required />

        <button type="submit">Login</button>
      </form>
    </div>
  </main>
  <?php require $_SERVER['DOCUMENT_ROOT'] . '/EGS/elements/footer.php'; ?>
</body>

</html>