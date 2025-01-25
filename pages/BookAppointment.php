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
  <?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/EGS/functions.php';

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $preferredDate = $_POST['date'];
    $preferredTime = $_POST['time'];
    $service = $_POST['service'];

    $userId = $_SESSION['user_id']; // Assuming user is logged in and user_id is stored in session

    $result = recordAppointment($userId, $name, $email, $phone, $preferredDate, $preferredTime, $service);
  }
  ?>
  <main>
    <div class="appointment-container">
      <h2>Book an Appointment</h2>
      <?php if (isset($result)): ?>
        <p><?= htmlspecialchars($result['message']) ?></p>
      <?php endif; ?>
      <form id="appointment-form" method="POST" action="">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" require_onced />

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" require_onced />

        <label for="phone">Phone Number:</label>
        <input type="tel" id="phone" name="phone" require_onced />

        <label for="date">Preferred Date:</label>
        <input type="date" id="date" name="date" require_onced />

        <label for="time">Preferred Time:</label>
        <input type="time" id="time" name="time" require_onced />

        <label for="service">Service:</label>
        <select id="service" name="service" require_onced>
          <option value="haircut">Haircut</option>
          <option value="beard-trim">Beard Trim</option>
          <option value="full-grooming">Full Grooming</option>
        </select>

        <button type="submit">Book Appointment</button>
      </form>
    </div>
  </main>

  <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/EGS/elements/footer.php'; ?>
</body>

</html>