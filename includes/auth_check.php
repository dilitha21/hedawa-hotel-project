<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirects to login if user is not authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}
?>
