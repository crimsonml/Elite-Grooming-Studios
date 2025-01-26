<?php session_start(); ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/EGS/functions.php'; ?>
<header>
    <!-- Website Logo -->
    <img src="/EGS/assets/images/1.png" alt="Elite Grooming Studio Logo" />

    <!-- Navigation Menu -->
    <nav>
        <button class="menu-toggle">&#9776;</button>
        <ul class="nav-list">
            <li><a href="/EGS/index.php">Home</a></li>
            <li><a href="/EGS/pages/services.php">Services</a></li>
            <li><a href="/EGS/pages/shop.php">Shop</a></li>
            <li><a href="/EGS/pages/BookAppointment.php">Book Appointment</a></li>
            <li>
                <!-- Cart Icon with Bubble -->
                <a href="/EGS/pages/cart.php" class="cart-icon">
                    <i class="fas fa-shopping-cart"></i>
                    <?php
                    $cartItemCount = getCartItemCount();
                    if ($cartItemCount > 0): ?>
                        <span class="cart-bubble"><?= $cartItemCount ?></span>
                    <?php endif; ?>
                </a>
            </li>
            <?php if (isset($_SESSION['username'])): ?>
                <li><a href="/EGS/profile/index.php"><?= htmlspecialchars($_SESSION['username']) ?></a></li>
            <?php endif; ?>
            <?php if (!isset($_SESSION['username'])): ?>
                <li>
                    <!-- Login Icon -->
                    <a href="/EGS/pages/login.php" class="login-icon">
                        <i class="fas fa-user"></i>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</header>