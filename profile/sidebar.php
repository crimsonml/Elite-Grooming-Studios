<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<div class="profile-sidebar">
    <ul>
        <li><a href="/EGS/profile/settings.php" class="<?= $current_page == 'settings.php' ? 'active' : '' ?>">Profile Settings</a></li>
        <li><a href="/EGS/profile/security.php" class="<?= $current_page == 'security.php' ? 'active' : '' ?>">Security</a></li>
        <li><a href="/EGS/profile/orders.php" class="<?= $current_page == 'orders.php' ? 'active' : '' ?>">Order History</a></li>
        <li><a href="/EGS/profile/appointments.php" class="<?= $current_page == 'appointments.php' ? 'active' : '' ?>">Appointment History</a></li>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <li><a href="/EGS/admin/panelDash.php" class="<?= $current_page == 'panelDash.php' ? 'active' : '' ?>">Admin Panel</a></li>
        <?php endif; ?>
        <li><a href="/EGS/profile/logout.php" class="<?= $current_page == 'logout.php' ? 'active' : '' ?>">Logout</a></li>
    </ul>
</div>