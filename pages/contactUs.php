<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Elite Grooming Studio</title>
  <link rel="stylesheet" href="/EGS/assets/css/style.css" />
</head>

<body>
  <?php require $_SERVER['DOCUMENT_ROOT'] . '/EGS/elements/header.php'; ?>
  <main>
    <div class="contact-container">
      <h3>Contact us through the website</h3>
      <form id="contact-form">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required />

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required />

        <label for="phone">Phone Number (optional):</label>
        <input type="tel" id="phone" name="phone" />

        <label for="message">Message:</label>
        <textarea id="message" name="message" required></textarea>

        <button type="submit">Send Message</button>
      </form>
      <p id="confirmation-message" style="display: none">
        Thank you for reaching out! We’ll get back to you shortly.
      </p>
      <div class="social-media-icons">
        <a href="https://www.instagram.com" target="_blank">&#x1F47E; Instagram</a>
        <a href="https://www.facebook.com" target="_blank">&#x1F47E; Facebook</a>
        <a href="https://www.twitter.com" target="_blank">&#x1F47E; Twitter</a>
        <a href="https://www.youtube.com" target="_blank">&#x1F47E; YouTube</a>
      </div>
    </div>
  </main>
  <?php require $_SERVER['DOCUMENT_ROOT'] . '/EGS/elements/footer.php'; ?>
</body>

</html>