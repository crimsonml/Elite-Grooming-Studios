<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>404 Not Found - Elite Grooming Studio</title>
  <link rel="stylesheet" href="/EGS/assets/css/style.css" />
  <link rel="icon" href="/EGS/assets/images/2.png" type="image/x-icon">
  <style>
    .error-container {
      text-align: center;
      padding: 50px;
    }

    .error-container h1 {
      font-size: 100px;
      margin: 0;
      color: #333;
    }

    .error-container h2 {
      font-size: 30px;
      margin: 20px 0;
      color: #666;
    }

    .error-container p {
      font-size: 18px;
      color: #333;
    }

    .error-container a {
      display: inline-block;
      margin-top: 20px;
      padding: 10px 20px;
      background-color: #ff5733;
      color: white;
      text-decoration: none;
      border-radius: 4px;
    }

    .error-container a:hover {
      background-color: #c70039;
    }
  </style>
</head>

<body>
  <?php require $_SERVER['DOCUMENT_ROOT'] . '/EGS/elements/header.php'; ?>
  <main>
    <div class="error-container">
      <h1>404</h1>
      <h2>Page Not Found</h2>
      <p>Sorry, the page you are looking for does not exist.</p>
      <a href="/EGS/index.html">Go to Home</a>
    </div>
  </main>
  <?php require $_SERVER['DOCUMENT_ROOT'] . '/EGS/elements/footer.php'; ?>
</body>

</html>