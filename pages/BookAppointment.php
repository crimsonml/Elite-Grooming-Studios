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
    <div class="appointment-container">
      <h2>Book an Appointment</h2>
      <form id="appointment-form">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required />

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required />

        <label for="phone">Phone Number:</label>
        <input type="tel" id="phone" name="phone" required />

        <label for="date">Preferred Date:</label>
        <input type="date" id="date" name="date" required />

        <label for="time">Preferred Time:</label>
        <input type="time" id="time" name="time" required />

        <label for="service">Service:</label>
        <select id="service" name="service" required>
          <option value="haircut">Haircut</option>
          <option value="beard-trim">Beard Trim</option>
          <option value="full-grooming">Full Grooming</option>
        </select>

        <button type="submit">Book Appointment</button>
      </form>
    </div>
  </main>

  <?php require $_SERVER['DOCUMENT_ROOT'] . '/EGS/elements/footer.php'; ?>
</body>

</html>