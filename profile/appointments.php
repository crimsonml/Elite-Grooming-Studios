<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/EGS/functions.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /EGS/pages/login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$appointments = fetchAppointmentsByUserId($userId);

$upcomingAppointments = [];
$pastAppointments = [];

foreach ($appointments as $appointment) {
    if (isUpcoming($appointment) && $appointment['status'] === 'Upcoming') {
        $upcomingAppointments[] = $appointment;
    } else {
        $pastAppointments[] = $appointment;
    }
}

function fetchAppointmentsByUserId($userId)
{
    $pdo = connectDB();

    try {
        $stmt = $pdo->prepare("SELECT * FROM appointments WHERE user_id = :user_id ORDER BY preferred_date, preferred_time");
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}

function isUpcoming($appointment)
{
    $currentDateTime = new DateTime();
    $appointmentDateTime = new DateTime($appointment['preferred_date'] . ' ' . $appointment['preferred_time']);
    return $appointmentDateTime >= $currentDateTime;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment History - Elite Grooming Studio</title>
    <link rel="stylesheet" href="/EGS/assets/css/style.css">
</head>

<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/EGS/elements/header.php'; ?>

    <main class="profile-container">
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/EGS/profile/sidebar.php'; ?>

        <div class="profile-content">
            <h1>Appointment History</h1>

            <!-- Upcoming Appointments Section -->
            <section class="appointments-upcoming">
                <h2>Upcoming Appointments</h2>
                <ul class="appointment-list">
                    <?php if (empty($upcomingAppointments)): ?>
                        <li>No upcoming appointments found.</li>
                    <?php else: ?>
                        <?php foreach ($upcomingAppointments as $appointment): ?>
                            <li>
                                <p><strong>Service:</strong> <?= htmlspecialchars($appointment['service']) ?></p>
                                <p><strong>Date:</strong> <?= htmlspecialchars($appointment['preferred_date']) ?></p>
                                <p><strong>Time:</strong> <?= htmlspecialchars($appointment['preferred_time']) ?></p>
                                <p><strong>Status:</strong> <?= htmlspecialchars($appointment['status']) ?></p>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </section>

            <!-- Past Appointments Section -->
            <section class="appointments-past">
                <h2>Past Appointments</h2>
                <ul class="appointment-list">
                    <?php if (empty($pastAppointments)): ?>
                        <li>No past appointments found.</li>
                    <?php else: ?>
                        <?php foreach ($pastAppointments as $appointment): ?>
                            <li>
                                <p><strong>Service:</strong> <?= htmlspecialchars($appointment['service']) ?></p>
                                <p><strong>Date:</strong> <?= htmlspecialchars($appointment['preferred_date']) ?></p>
                                <p><strong>Time:</strong> <?= htmlspecialchars($appointment['preferred_time']) ?></p>
                                <p><strong>Status:</strong> <?= htmlspecialchars($appointment['status']) ?></p>
                                <a href="/EGS/pages/BookAppointment.php" class="rebook-button">Rebook</a>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </section>
        </div>
    </main>

    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/EGS/elements/footer.php'; ?>
</body>

</html>