<?php
require_once 'includes/db_connect.php';
require_once 'includes/auth_check.php';

// Requires user to be logged in to book

require_once 'includes/header.php';
?>

<h2>Book a Table</h2>
<form action="actions/booking_process.php" method="POST">
    <label>Date:</label>
    <input type="date" name="booking_date" required min="<?= date('Y-m-d') ?>">
    
    <label>Time:</label>
    <input type="time" name="booking_time" required>
    
    <label>Number of Guests:</label>
    <input type="number" name="guests" min="1" max="20" required>
    
    <button type="submit">Request Reservation</button>
</form>

<?php require_once 'includes/footer.php'; ?>
