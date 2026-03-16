<?php
// staff_check.php requires the basic auth_check first
require_once __DIR__ . '/auth_check.php';

// Redirects out of staff pages if the user is not staff
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'staff') {
    header("Location: ../index.php");
    exit;
}
?>
