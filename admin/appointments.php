<?php
require_once 'adminFunctions.php';
$appointments = fetchAppointments($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments - Admin Panel</title>
    <link rel="stylesheet" href="adminPanel.css">
</head>

<body>
    <header class="admin-header">
        <h1>Appointments</h1>
        <nav class="admin-nav">
            <ul>
                <li><a href="panelDash.php">Dashboard</a></li>
                <li><a href="/EGS/index.php">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="messages.php">Messages</a></li>
                <li><a href="users.php">Users</a></li>
                <li><a href="appointments.php">Appointments</a></li>
                <li><a href="/EGS/pages/login.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Manage Appointments</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Preferred Date</th>
                    <th>Preferred Time</th>
                    <th>Service</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($appointments as $appointment): ?>
                    <tr>
                        <td><?= htmlspecialchars($appointment['appointment_id']) ?></td>
                        <td><?= htmlspecialchars($appointment['user_id']) ?></td>
                        <td><?= htmlspecialchars($appointment['name']) ?></td>
                        <td><?= htmlspecialchars($appointment['email']) ?></td>
                        <td><?= htmlspecialchars($appointment['phone']) ?></td>
                        <td><?= htmlspecialchars($appointment['preferred_date']) ?></td>
                        <td><?= htmlspecialchars($appointment['preferred_time']) ?></td>
                        <td><?= htmlspecialchars($appointment['service']) ?></td>
                        <td>
                            <select class="status-dropdown" data-id="<?= $appointment['appointment_id'] ?>">
                                <option value="Upcoming" <?= $appointment['status'] == 'Upcoming' ? 'selected' : '' ?>>Upcoming</option>
                                <option value="Completed" <?= $appointment['status'] == 'Completed' ? 'selected' : '' ?>>Completed</option>
                                <option value="Cancelled" <?= $appointment['status'] == 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                            </select>
                        </td>
                        <td><?= htmlspecialchars($appointment['created_at']) ?></td>
                        <td><?= htmlspecialchars($appointment['updated_at']) ?></td>
                        <td><button class="save-status-button" data-id="<?= $appointment['appointment_id'] ?>">Save</button></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

    <script>
        document.querySelectorAll('.save-status-button').forEach(button => {
            button.addEventListener('click', function() {
                const appointmentId = this.getAttribute('data-id');
                const status = document.querySelector(`.status-dropdown[data-id="${appointmentId}"]`).value;

                fetch('updateAppointmentStatus.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            appointment_id: appointmentId,
                            status: status
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Status updated successfully');
                            location.reload();
                        } else {
                            alert('Error: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });
    </script>
</body>

</html>