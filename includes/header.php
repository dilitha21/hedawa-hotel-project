<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Ensure paths resolve correctly whether running from root, /pages/, or /staff/
$base_url = (strpos($_SERVER['SCRIPT_NAME'], '/pages/') !== false || strpos($_SERVER['SCRIPT_NAME'], '/staff/') !== false) ? '../' : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hedawa Restaurant</title>
    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/style.css">
</head>
<body>
    <header class="header">
        <nav class="navbar container">
            <div class="logo">
                <a href="<?= $base_url ?>index.php">
                    <i class="fa-solid fa-leaf logo-icon"></i>හේඩෑව
                </a>
            </div>
            
            <button class="mobile-toggle" aria-label="Toggle navigation">
                <i class="fa-solid fa-bars"></i>
            </button>

            <ul class="nav-links">
                <li><a href="<?= $base_url ?>index.php">Home</a></li>
                <li><a href="<?= $base_url ?>pages/bookings.php">Rooms</a></li>
                <li><a href="<?= $base_url ?>pages/reservation.php">Reservation</a></li>
                <li><a href="<?= $base_url ?>pages/orders.php">Food</a></li>
                <li><a href="<?= $base_url ?>pages/contact.php">Contact</a></li>
                <li><a href="<?= $base_url ?>cart.php" class="cart-link"><i class="fa-solid fa-shopping-cart"></i> Cart</a></li>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'staff'): ?>
                        <li><a href="<?= $base_url ?>staff/dashboard.php">Dashboard</a></li>
                    <?php else: ?>
                        <li><a href="<?= $base_url ?>profile.php">Profile</a></li>
                    <?php endif; ?>
                    <li><a href="<?= $base_url ?>actions/logout_process.php" class="btn" style="background-color: #C82909; color: white;">Logout</a></li>
                <?php else: ?>
                    <li><a href="<?= $base_url ?>login.php" class="btn">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main class="main-content container">
