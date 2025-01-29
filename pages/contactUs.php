<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Elite Grooming Studio</title>
  <link rel="stylesheet" href="/EGS/assets/css/style.css" />
  <link rel="icon" href="/EGS/assets/images/2.png" type="image/x-icon">
</head>

<body>
  <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/EGS/elements/header.php'; ?>
  <main>
    <div class="contact-container">
      <h3>Contact us through the website</h3>
      <form id="contact-form">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required />

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required />

        <label for="phone">Contact Number:</label>
        <input type="tel" id="phone" name="phone" />

        <label for="message">Message:</label>
        <textarea id="message" name="message" required></textarea>

        <button type="submit">Send Message</button>
      </form>
      <p id="confirmation-message" style="display: none">
        Thank you for reaching out! We’ll get back to you shortly.
      </p>
    </div>
  </main>
  <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/EGS/elements/footer.php'; ?>

  <script>
    document.getElementById('contact-form').addEventListener('submit', function(event) {
      event.preventDefault();
      var formData = new FormData(this);

      fetch('saveMessage.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          document.getElementById('confirmation-message').style.display = 'block';
          document.getElementById('contact-form').reset();
        } else {
          alert('Error: ' + data.message);
        }
      })
      .catch(error => {
        console.error('Error:', error);
      });
    });
  </script>
</body>

</html>