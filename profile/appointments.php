<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment History - Elite Grooming Studio</title>
    <link rel="stylesheet" href="/EGS/assets/css/style.css">
</head>

<body>
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/EGS/elements/header.php'; ?>

    <main class="profile-container">
        <?php require $_SERVER['DOCUMENT_ROOT'] . '/EGS/profile/sidebar.php'; ?>

        <div class="profile-content">
            <h1>Appointment History</h1>

            <!-- Upcoming Appointments Section -->
            <section class="appointments-upcoming">
                <h2>Upcoming Appointments</h2>
                <ul class="appointment-list">
                    <li>
                        <p><strong>Service:</strong> Haircut</p>
                        <p><strong>Date:</strong> 2024-02-10</p>
                        <p><strong>Time:</strong> 2:30 PM</p>
                        <p><strong>Stylist:</strong> John Doe</p>
                        <p><strong>Status:</strong> Upcoming</p>
                    </li>
                    <li>
                        <p><strong>Service:</strong> Beard Trim</p>
                        <p><strong>Date:</strong> 2024-02-12</p>
                        <p><strong>Time:</strong> 4:00 PM</p>
                        <p><strong>Stylist:</strong> Michelle Snyder</p>
                        <p><strong>Status:</strong> Upcoming</p>
                    </li>
                </ul>
            </section>

            <!-- Past Appointments Section -->
            <section class="appointments-past">
                <h2>Past Appointments</h2>
                <ul class="appointment-list">
                    <li>
                        <p><strong>Service:</strong> Full Grooming</p>
                        <p><strong>Date:</strong> 2024-01-15</p>
                        <p><strong>Time:</strong> 11:00 AM</p>
                        <p><strong>Stylist:</strong> Myles Ashman</p>
                        <p><strong>Status:</strong> Completed</p>
                        <a href="/EGS/pages/BookAppointment.php" class="rebook-button">Rebook</a>
                    </li>
                    <li>
                        <p><strong>Service:</strong> Shaving</p>
                        <p><strong>Date:</strong> 2024-01-10</p>
                        <p><strong>Time:</strong> 9:30 AM</p>
                        <p><strong>Stylist:</strong> Dakota Jernigan</p>
                        <p><strong>Status:</strong> Completed</p>
                        <a href="/EGS/pages/BookAppointment.php" class="rebook-button">Rebook</a>
                    </li>
                </ul>
            </section>
        </div>
    </main>

    <?php require $_SERVER['DOCUMENT_ROOT'] . '/EGS/elements/footer.php'; ?>
</body>

</html>